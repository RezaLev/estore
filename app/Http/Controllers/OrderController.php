<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use App\Services\Midtrans\CreateSnapTokenService;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use PhpParser\Node\Expr\Empty_;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::orderBy('id', 'DESC');

        // Ambil tanggal awal dan akhir dari request atau default ke bulan ini
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
        }
        if ($request->has('order') && $request->order != 'all') {
            $query->where('status', $request->order);
        }
        // Filter berdasarkan rentang tanggal
        $query->whereBetween('created_at', [$startDate, $endDate]);
        // Paginasi data order
        $orders = $query->paginate(10);
        // Ambil daftar status unik dari tabel orders
        $status = Order::select('status')->distinct()->get();

        return view('backend.order.index', compact('orders', 'status', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'address1' => 'string|required',
            'coupon' => 'nullable|numeric',
            'phone' => 'numeric|required',
            'post_code' => 'string|nullable',
            'email' => 'string|required'
        ]);
        // return $request->all();

        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            request()->session()->flash('error', 'Cart is Empty !');
            return back();
        }
        // $cart=Cart::get();
        // // return $cart;
        // $cart_index='ORD-'.strtoupper(uniqid());
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }

        // $total_prod=0;
        // if(session('cart')){
        //         foreach(session('cart') as $cart_items){
        //             $total_prod+=$cart_items['quantity'];
        //         }
        // }
        

        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = $request->user()->id;
        $order_data['courier_name'] = explode('_', $request->shipping)[0];
        $order_data['courier_charge'] = explode('_', $request->shipping)[1];
        $shipping = $order_data['courier_charge'];
        // return session('coupon')['value'];
        $order_data['sub_total'] = Helper::totalCartPrice();
        $order_data['quantity'] = Helper::cartCount();
        $order_data['has_custom_name'] = $request->has('custom_name') ? 1 : 0;
        $order_data['custom_name'] = $request->custom_name;
        $order_data['custom_name_price'] = $request->custom_name_price;
        $order_data['has_custom_tag'] = $request->has('custom_tag') ? 1 : 0;
        $order_data['custom_tag'] = $request->custom_tag;
        $order_data['custom_tag_price'] = $request->custom_tag_price;

        $customPrice = ($order_data['has_custom_name'] ? $order_data['custom_name_price'] : 0) +
                        ($order_data['has_custom_tag'] ? $order_data['custom_tag_price'] : 0);

        if (session('coupon')) {
            $order_data['coupon'] = session('coupon')['value'];
        }

        if ($request->shipping) {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() + $customPrice + $shipping - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice() + $customPrice + $shipping;
            }
        } else {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() + $customPrice - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice() + $customPrice;
            }
        }
        // return $order_data['total_amount'];
        $order_data['status'] = "received";
        if (request('payment_method') == 'paypal') {
            $order_data['payment_method'] = 'paypal';
            $order_data['payment_status'] = 'paid';
        } else {
            $order_data['payment_method'] = 'cod';
            $order_data['payment_status'] = 'Unpaid';
        }
        $order->fill($order_data);

        $status = $order->save();
        if ($order)
            // dd($order->id);
            $users = User::where('role', 'admin')->first();
        $details = [
            'title' => 'New order created',
            'actionURL' => route('order.show', $order->id),
            'fas' => 'fa-file-alt'
        ];
        FacadesNotification::send($users, new StatusNotification($details));
        if (request('payment_method') == 'paypal') {
            return redirect()->route('payment')->with(['id' => $order->id]);
        } else {
            session()->forget('cart');
            session()->forget('coupon');
        }

        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        $tempItem =
            DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.id', 'carts.price', 'carts.quantity', 'carts.order_id', 'carts.user_id', 'products.title as name', 'products.stock as stock')
            ->where('user_id', auth()->user()->id)
            ->where('order_id', $order->id)
            ->get()->toArray();


        $items = [];
        $hasPo = 0;
        foreach ($tempItem as $key => $value) {
            if ($value->stock < $value->quantity) {
                $hasPo = 1;
            }
            $items[] = (array) $value;
        }

        $items[] = [
            'id' => 'ongkir',
            'price' => intval($order_data['courier_charge']),
            'name' => 'Ongkir',
            'quantity' => 1,
        ];

        $order->items = $items;
        $midtrans = new CreateSnapTokenService($order);
        $snapToken = $midtrans->getSnapToken();
        if (!empty($snapToken)) {
            Order::where('id', $order->id)->update(['snap_token' => $snapToken]);
        }
        if ($hasPo == 1) {
            Order::where('id', $order->id)->update([
                'has_po' => 1,
                'approved_status' => 0
            ]);
        }
        // dd($users);        
        request()->session()->flash('success', 'Your product successfully placed in order');
        request()->session()->flash('snap_token_status', true);
        request()->session()->flash('snap_token', $snapToken);
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $orderedProducts = Cart::where('order_id', $id)->get();
        return view('backend.order.show', compact('order', 'orderedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $user = User::find($order->user_id);
        return view('backend.order.edit')->with('order', $order)->with('user_role', $user->role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $this->validate($request, [
            'status' => 'required|in:received,process,delivered,cancel,return_request,return_accepted,return_rejected'
        ]);

        $data = $request->all();
        // return $request->status;
        if ($request->status == 'delivered') {
            if ($order->approved_status == null) {
                foreach ($order->cart as $cart) {
                    $product = $cart->product;
                    // return $product;
                    $product->stock -= $cart->quantity;
                    $product->save();
                }
            }
        }
        $status = $order->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated order');
        } else {
            request()->session()->flash('error', 'Error while updating order');
        }
        return redirect()->route('order.index');
    }

    public function orderApproved(Request $request, $id)
    {
        $order = Order::find($id);

        $status = $order->fill([
            'approved_status' => 1,
            'approved_at' => Carbon::now(),
        ])->save();

        if ($status) {
            request()->session()->flash('success', 'Successfully updated order');
        } else {
            request()->session()->flash('error', 'Error while updating order');
        }
        return redirect()->route('order.index');
    }

    public function orderRejected(Request $request, $id)
    {
        $order = Order::find($id);

        $status = $order->fill([
            'approved_status' => 2,
            'approved_at' => Carbon::now(),
        ])->save();

        if ($status) {
            request()->session()->flash('success', 'Successfully updated order');
        } else {
            request()->session()->flash('error', 'Error while updating order');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                request()->session()->flash('success', 'Order Successfully deleted');
            } else {
                request()->session()->flash('error', 'Order can not deleted');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request)
    {
        // return $request->all();
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();
        // if (!empty($order->snap_token)) {
        //     request()->session()->flash('snap_token_status', true);
        //     request()->session()->flash('snap_token', $order->snap_token);
        // }
        if ($order) {
            switch ($order->approved_status) {
                case '0':
                    request()->session()->flash('success', 'Your order has requested for approval.');
                    break;
                case null:
                case '1':
                    if ($order->status == "received") {
                        request()->session()->flash('success', 'Your order has been placed. please wait.');
                    } elseif ($order->status == "process") {
                        request()->session()->flash('success', 'Your order is under processing please wait.');
                    } elseif ($order->status == "delivered") {
                        request()->session()->flash('success', 'Your order is successfully delivered.');
                    } elseif ($order->status == "cancel") {
                        request()->session()->flash('error', 'Your order canceled. please try again');
                    } elseif ($order->status == "return_request") {
                        request()->session()->flash('success', 'Your order return is requested.');
                    } elseif ($order->status == "return_accepted") {
                        request()->session()->flash('success', 'Your order return request is accepted.');
                    } elseif ($order->status == "return_rejected") {
                        request()->session()->flash('success', 'Your order return request is rejected.');
                    } elseif ($order->status == "completed") {
                        request()->session()->flash('success', 'Your order is completed.');
                    }
                    break;
                case '2':
                    request()->session()->flash('error', 'Your order has rejected.');
                    break;
            }
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid order number please try again');
            return back();
        }
    }

    public function orderReturn()
    {
        return view('frontend.pages.order-return');
    }

    public function productReturnOrder(Request $request)
    {
        // return $request->all();
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();

        if ($order) {
            if ($order->status == "received") {
                request()->session()->flash('success', 'Your order has been placed. please wait.');
            } elseif ($order->status == "process") {
                request()->session()->flash('success', 'Your order is under processing please wait.');
            } elseif ($order->status == "delivered") {
                $order->fill(['status' => 'return_request'])->save();
                request()->session()->flash('success', 'Your order return request is successfully delivered.');
            } elseif ($order->status == "cancel") {
                request()->session()->flash('error', 'Your order canceled. please try again');
            } elseif ($order->status == "return_request") {
                request()->session()->flash('success', 'Your order return is requested.');
            } elseif ($order->status == "return_accepted") {
                request()->session()->flash('success', 'Your order return request is accepted.');
            } elseif ($order->status == "return_rejected") {
                request()->session()->flash('success', 'Your order return request is rejected.');
            } elseif ($order->status == "completed") {
                request()->session()->flash('success', 'Your order is completed.');
            }
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid order number please try again');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request)
    {
        // Mengambil order berdasarkan id atau sejenisnya (sesuaikan dengan logika aplikasi Anda)
        $order = Order::getAllOrder($request->id);

        // Filter berdasarkan tanggal jika ada request 'start_date' dan 'end_date'
        $query = Order::query(); // Inisialisasi query builder untuk model Order
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Ambil data order yang sesuai dengan filter
        $orders = $query->get();
        // Generate nama file PDF berdasarkan detail order
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        // Load view PDF menggunakan library PDF (misalnya, dompdf)
        $pdf = PDF::loadView('backend.order.pdf', compact('order', 'orders'));
        // Mengembalikan PDF untuk diunduh dengan nama file yang telah dibuat
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'completed')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                // dd($amount);
                $m = intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }

    public function getCourier(Request $request)
    {
        try {
            $data = $request->all();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=492&originType=city&destination=" . $data['id'] . "&destinationType=city&weight=1000&courier=jne:jnt:ninja:pos:sicepat:tiki:anteraja",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: " . env('RAJAONGKIR_API_KEY')
                ),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ));

            $rajaongkir = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) throw new Exception($err);
            $rajaongkir = json_decode($rajaongkir, true);
            if ($rajaongkir['rajaongkir']['status']['code'] != 200) throw new Exception($rajaongkir['rajaongkir']['status']['description']);

            $res = [];
            foreach ($rajaongkir['rajaongkir']['results'] as $k1 => $v1) {
                $v1['code'] = str_replace('&', 'N', $v1['code']);
                foreach ($v1['costs'] as $k2 => $v2) {
                    $res[] =  [
                        "id" => Str::upper($v1['code'] . '-' . $v2['service']) . '_' . $v2['cost'][0]['value'],
                        "name" => Str::upper($v1['code'] . ' ' . $v2['service']) . ' : ' . Helper::rupiahFormatter($v2['cost'][0]['value']),
                        "cost" => $v2['cost'][0]['value'],
                    ];
                }
            }



            request()->session()->flash('success', 'Courier Information Updated');
            return response()->json([
                'success' => true,
                'data' => $res,
                'message' => 'Data berhasil diambil'
            ]);
        } catch (\Throwable $th) {
            request()->session()->flash('error', 'Failed to Update Courier Information');
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}

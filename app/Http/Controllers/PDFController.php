<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function exportPDF()
    {
        $data = [
            'title' => 'Order Lists',
            'orders' => Order::orderBy('created_at', 'DESC')->get(),
        ]; // Sample data


        // Load a view and pass the data to it
        $pdf = Pdf::loadView('pdf_view', $data);
        $pdf->setPaper('a4', 'landscape');

        // Download the generated PDF
        return $pdf->download('Order List.pdf');
    }
}

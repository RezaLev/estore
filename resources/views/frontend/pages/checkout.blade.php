@extends('frontend.layouts.master')

@section('title', 'Checkout page')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
            <form class="form" method="POST" action="{{ route('cart.order') }}">
                @csrf
                <div class="row">

                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <h2>Make Your Checkout Here</h2>
                            <p>Please register in order to checkout more quickly</p>
                            <!-- Form -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>First Name<span>*</span></label>
                                        <input type="text" name="first_name" placeholder=""
                                            value="{{ old('first_name') }}" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Last Name<span>*</span></label>
                                        <input type="text" name="last_name" placeholder="" value="{{ old('lat_name') }}">
                                        @error('last_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Email Address<span>*</span></label>
                                        <input type="email" name="email" placeholder="" value="{{ old('email') }}">
                                        @error('email')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Phone Number <span>*</span></label>
                                        <input type="number" name="phone" placeholder="" required
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Country<span>*</span></label>
                                        <select name="country" id="country">
                                            <option value="ID" selected>Indonesia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Address Line 1<span>*</span></label>
                                        <input type="text" name="address1" placeholder="" value="{{ old('address1') }}">
                                        @error('address1')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Address Line 2</label>
                                        <input type="text" name="address2" placeholder="" value="{{ old('address2') }}">
                                        @error('address2')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <select name="post_code" id="post_code" onchange="checkPostCode()">
                                            <option value="1">23681 - Kabupaten Aceh Barat</option>
                                            <option value="10">24454 - Kabupaten Aceh Timur</option>
                                            <option value="100">97351 - Kabupaten Buru Selatan</option>
                                            <option value="101">93754 - Kabupaten Buton</option>
                                            <option value="102">93745 - Kabupaten Buton Utara</option>
                                            <option value="103">46211 - Kabupaten Ciamis</option>
                                            <option value="104">43217 - Kabupaten Cianjur</option>
                                            <option value="105">53211 - Kabupaten Cilacap</option>
                                            <option value="106">42417 - Kota Cilegon</option>
                                            <option value="107">40512 - Kota Cimahi</option>
                                            <option value="108">45611 - Kabupaten Cirebon</option>
                                            <option value="109">45116 - Kota Cirebon</option>
                                            <option value="11">24382 - Kabupaten Aceh Utara</option>
                                            <option value="110">22211 - Kabupaten Dairi</option>
                                            <option value="111">98784 - Kabupaten Deiyai (Deliyai)</option>
                                            <option value="112">20511 - Kabupaten Deli Serdang</option>
                                            <option value="113">59519 - Kabupaten Demak</option>
                                            <option value="114">80227 - Kota Denpasar</option>
                                            <option value="115">16416 - Kota Depok</option>
                                            <option value="116">27612 - Kabupaten Dharmasraya</option>
                                            <option value="117">98866 - Kabupaten Dogiyai</option>
                                            <option value="118">84217 - Kabupaten Dompu</option>
                                            <option value="119">94341 - Kabupaten Donggala</option>
                                            <option value="12">26411 - Kabupaten Agam</option>
                                            <option value="120">28811 - Kota Dumai</option>
                                            <option value="121">31811 - Kabupaten Empat Lawang</option>
                                            <option value="122">86351 - Kabupaten Ende</option>
                                            <option value="123">91719 - Kabupaten Enrekang</option>
                                            <option value="124">98651 - Kabupaten Fakfak</option>
                                            <option value="125">86213 - Kabupaten Flores Timur</option>
                                            <option value="126">44126 - Kabupaten Garut</option>
                                            <option value="127">24653 - Kabupaten Gayo Lues</option>
                                            <option value="128">80519 - Kabupaten Gianyar</option>
                                            <option value="129">96218 - Kabupaten Gorontalo</option>
                                            <option value="13">85811 - Kabupaten Alor</option>
                                            <option value="130">96115 - Kota Gorontalo</option>
                                            <option value="131">96611 - Kabupaten Gorontalo Utara</option>
                                            <option value="132">92111 - Kabupaten Gowa</option>
                                            <option value="133">61115 - Kabupaten Gresik</option>
                                            <option value="134">58111 - Kabupaten Grobogan</option>
                                            <option value="135">55812 - Kabupaten Gunung Kidul</option>
                                            <option value="136">74511 - Kabupaten Gunung Mas</option>
                                            <option value="137">22813 - Kota Gunungsitoli</option>
                                            <option value="138">97757 - Kabupaten Halmahera Barat</option>
                                            <option value="139">97911 - Kabupaten Halmahera Selatan</option>
                                            <option value="14">97222 - Kota Ambon</option>
                                            <option value="140">97853 - Kabupaten Halmahera Tengah</option>
                                            <option value="141">97862 - Kabupaten Halmahera Timur</option>
                                            <option value="142">97762 - Kabupaten Halmahera Utara</option>
                                            <option value="143">71212 - Kabupaten Hulu Sungai Selatan</option>
                                            <option value="144">71313 - Kabupaten Hulu Sungai Tengah</option>
                                            <option value="145">71419 - Kabupaten Hulu Sungai Utara</option>
                                            <option value="146">22457 - Kabupaten Humbang Hasundutan</option>
                                            <option value="147">29212 - Kabupaten Indragiri Hilir</option>
                                            <option value="148">29319 - Kabupaten Indragiri Hulu</option>
                                            <option value="149">45214 - Kabupaten Indramayu</option>
                                            <option value="15">21214 - Kabupaten Asahan</option>
                                            <option value="150">98771 - Kabupaten Intan Jaya</option>
                                            <option value="151">11220 - Kota Jakarta Barat</option>
                                            <option value="152">10540 - Kota Jakarta Pusat</option>
                                            <option value="153">12230 - Kota Jakarta Selatan</option>
                                            <option value="154">13330 - Kota Jakarta Timur</option>
                                            <option value="155">14140 - Kota Jakarta Utara</option>
                                            <option value="156">36111 - Kota Jambi</option>
                                            <option value="157">99352 - Kabupaten Jayapura</option>
                                            <option value="158">99114 - Kota Jayapura</option>
                                            <option value="159">99511 - Kabupaten Jayawijaya</option>
                                            <option value="16">99777 - Kabupaten Asmat</option>
                                            <option value="160">68113 - Kabupaten Jember</option>
                                            <option value="161">82251 - Kabupaten Jembrana</option>
                                            <option value="162">92319 - Kabupaten Jeneponto</option>
                                            <option value="163">59419 - Kabupaten Jepara</option>
                                            <option value="164">61415 - Kabupaten Jombang</option>
                                            <option value="165">98671 - Kabupaten Kaimana</option>
                                            <option value="166">28411 - Kabupaten Kampar</option>
                                            <option value="167">73583 - Kabupaten Kapuas</option>
                                            <option value="168">78719 - Kabupaten Kapuas Hulu</option>
                                            <option value="169">57718 - Kabupaten Karanganyar</option>
                                            <option value="17">80351 - Kabupaten Badung</option>
                                            <option value="170">80819 - Kabupaten Karangasem</option>
                                            <option value="171">41311 - Kabupaten Karawang</option>
                                            <option value="172">29611 - Kabupaten Karimun</option>
                                            <option value="173">22119 - Kabupaten Karo</option>
                                            <option value="174">74411 - Kabupaten Katingan</option>
                                            <option value="175">38911 - Kabupaten Kaur</option>
                                            <option value="176">78852 - Kabupaten Kayong Utara</option>
                                            <option value="177">54319 - Kabupaten Kebumen</option>
                                            <option value="178">64184 - Kabupaten Kediri</option>
                                            <option value="179">64125 - Kota Kediri</option>
                                            <option value="18">71611 - Kabupaten Balangan</option>
                                            <option value="180">99461 - Kabupaten Keerom</option>
                                            <option value="181">51314 - Kabupaten Kendal</option>
                                            <option value="182">93126 - Kota Kendari</option>
                                            <option value="183">39319 - Kabupaten Kepahiang</option>
                                            <option value="184">29991 - Kabupaten Kepulauan Anambas</option>
                                            <option value="185">97681 - Kabupaten Kepulauan Aru</option>
                                            <option value="186">25771 - Kabupaten Kepulauan Mentawai</option>
                                            <option value="187">28791 - Kabupaten Kepulauan Meranti</option>
                                            <option value="188">95819 - Kabupaten Kepulauan Sangihe</option>
                                            <option value="189">14550 - Kabupaten Kepulauan Seribu</option>
                                            <option value="19">76111 - Kota Balikpapan</option>
                                            <option value="190">95862 - Kabupaten Kepulauan Siau Tagulandang Biaro
                                                (Sitaro)</option>
                                            <option value="191">97995 - Kabupaten Kepulauan Sula</option>
                                            <option value="192">95885 - Kabupaten Kepulauan Talaud</option>
                                            <option value="193">98211 - Kabupaten Kepulauan Yapen (Yapen Waropen)
                                            </option>
                                            <option value="194">37167 - Kabupaten Kerinci</option>
                                            <option value="195">78874 - Kabupaten Ketapang</option>
                                            <option value="196">57411 - Kabupaten Klaten</option>
                                            <option value="197">80719 - Kabupaten Klungkung</option>
                                            <option value="198">93511 - Kabupaten Kolaka</option>
                                            <option value="199">93911 - Kabupaten Kolaka Utara</option>
                                            <option value="2">23764 - Kabupaten Aceh Barat Daya</option>
                                            <option value="20">23238 - Kota Banda Aceh</option>
                                            <option value="200">93411 - Kabupaten Konawe</option>
                                            <option value="201">93811 - Kabupaten Konawe Selatan</option>
                                            <option value="202">93311 - Kabupaten Konawe Utara</option>
                                            <option value="203">72119 - Kabupaten Kotabaru</option>
                                            <option value="204">95711 - Kota Kotamobagu</option>
                                            <option value="205">74119 - Kabupaten Kotawaringin Barat</option>
                                            <option value="206">74364 - Kabupaten Kotawaringin Timur</option>
                                            <option value="207">29519 - Kabupaten Kuantan Singingi</option>
                                            <option value="208">78311 - Kabupaten Kubu Raya</option>
                                            <option value="209">59311 - Kabupaten Kudus</option>
                                            <option value="21">35139 - Kota Bandar Lampung</option>
                                            <option value="210">55611 - Kabupaten Kulon Progo</option>
                                            <option value="211">45511 - Kabupaten Kuningan</option>
                                            <option value="212">85362 - Kabupaten Kupang</option>
                                            <option value="213">85119 - Kota Kupang</option>
                                            <option value="214">75711 - Kabupaten Kutai Barat</option>
                                            <option value="215">75511 - Kabupaten Kutai Kartanegara</option>
                                            <option value="216">75611 - Kabupaten Kutai Timur</option>
                                            <option value="217">21412 - Kabupaten Labuhan Batu</option>
                                            <option value="218">21511 - Kabupaten Labuhan Batu Selatan</option>
                                            <option value="219">21711 - Kabupaten Labuhan Batu Utara</option>
                                            <option value="22">40311 - Kabupaten Bandung</option>
                                            <option value="220">31419 - Kabupaten Lahat</option>
                                            <option value="221">74611 - Kabupaten Lamandau</option>
                                            <option value="222">62218 - Kabupaten Lamongan</option>
                                            <option value="223">34814 - Kabupaten Lampung Barat</option>
                                            <option value="224">35511 - Kabupaten Lampung Selatan</option>
                                            <option value="225">34212 - Kabupaten Lampung Tengah</option>
                                            <option value="226">34319 - Kabupaten Lampung Timur</option>
                                            <option value="227">34516 - Kabupaten Lampung Utara</option>
                                            <option value="228">78319 - Kabupaten Landak</option>
                                            <option value="229">20811 - Kabupaten Langkat</option>
                                            <option value="23">40111 - Kota Bandung</option>
                                            <option value="230">24412 - Kota Langsa</option>
                                            <option value="231">99531 - Kabupaten Lanny Jaya</option>
                                            <option value="232">42319 - Kabupaten Lebak</option>
                                            <option value="233">39264 - Kabupaten Lebong</option>
                                            <option value="234">86611 - Kabupaten Lembata</option>
                                            <option value="235">24352 - Kota Lhokseumawe</option>
                                            <option value="236">26671 - Kabupaten Lima Puluh Koto/Kota</option>
                                            <option value="237">29811 - Kabupaten Lingga</option>
                                            <option value="238">83311 - Kabupaten Lombok Barat</option>
                                            <option value="239">83511 - Kabupaten Lombok Tengah</option>
                                            <option value="24">40721 - Kabupaten Bandung Barat</option>
                                            <option value="240">83612 - Kabupaten Lombok Timur</option>
                                            <option value="241">83711 - Kabupaten Lombok Utara</option>
                                            <option value="242">31614 - Kota Lubuk Linggau</option>
                                            <option value="243">67319 - Kabupaten Lumajang</option>
                                            <option value="244">91994 - Kabupaten Luwu</option>
                                            <option value="245">92981 - Kabupaten Luwu Timur</option>
                                            <option value="246">92911 - Kabupaten Luwu Utara</option>
                                            <option value="247">63153 - Kabupaten Madiun</option>
                                            <option value="248">63122 - Kota Madiun</option>
                                            <option value="249">56519 - Kabupaten Magelang</option>
                                            <option value="25">94711 - Kabupaten Banggai</option>
                                            <option value="250">56133 - Kota Magelang</option>
                                            <option value="251">63314 - Kabupaten Magetan</option>
                                            <option value="252">45412 - Kabupaten Majalengka</option>
                                            <option value="253">91411 - Kabupaten Majene</option>
                                            <option value="254">90111 - Kota Makassar</option>
                                            <option value="255">65163 - Kabupaten Malang</option>
                                            <option value="256">65112 - Kota Malang</option>
                                            <option value="257">77511 - Kabupaten Malinau</option>
                                            <option value="258">97451 - Kabupaten Maluku Barat Daya</option>
                                            <option value="259">97513 - Kabupaten Maluku Tengah</option>
                                            <option value="26">94881 - Kabupaten Banggai Kepulauan</option>
                                            <option value="260">97651 - Kabupaten Maluku Tenggara</option>
                                            <option value="261">97465 - Kabupaten Maluku Tenggara Barat</option>
                                            <option value="262">91362 - Kabupaten Mamasa</option>
                                            <option value="263">99381 - Kabupaten Mamberamo Raya</option>
                                            <option value="264">99553 - Kabupaten Mamberamo Tengah</option>
                                            <option value="265">91519 - Kabupaten Mamuju</option>
                                            <option value="266">91571 - Kabupaten Mamuju Utara</option>
                                            <option value="267">95247 - Kota Manado</option>
                                            <option value="268">22916 - Kabupaten Mandailing Natal</option>
                                            <option value="269">86551 - Kabupaten Manggarai</option>
                                            <option value="27">33212 - Kabupaten Bangka</option>
                                            <option value="270">86711 - Kabupaten Manggarai Barat</option>
                                            <option value="271">86811 - Kabupaten Manggarai Timur</option>
                                            <option value="272">98311 - Kabupaten Manokwari</option>
                                            <option value="273">98355 - Kabupaten Manokwari Selatan</option>
                                            <option value="274">99853 - Kabupaten Mappi</option>
                                            <option value="275">90511 - Kabupaten Maros</option>
                                            <option value="276">83131 - Kota Mataram</option>
                                            <option value="277">98051 - Kabupaten Maybrat</option>
                                            <option value="278">20228 - Kota Medan</option>
                                            <option value="279">79672 - Kabupaten Melawi</option>
                                            <option value="28">33315 - Kabupaten Bangka Barat</option>
                                            <option value="280">37319 - Kabupaten Merangin</option>
                                            <option value="281">99613 - Kabupaten Merauke</option>
                                            <option value="282">34911 - Kabupaten Mesuji</option>
                                            <option value="283">34111 - Kota Metro</option>
                                            <option value="284">99962 - Kabupaten Mimika</option>
                                            <option value="285">95614 - Kabupaten Minahasa</option>
                                            <option value="286">95914 - Kabupaten Minahasa Selatan</option>
                                            <option value="287">95995 - Kabupaten Minahasa Tenggara</option>
                                            <option value="288">95316 - Kabupaten Minahasa Utara</option>
                                            <option value="289">61382 - Kabupaten Mojokerto</option>
                                            <option value="29">33719 - Kabupaten Bangka Selatan</option>
                                            <option value="290">61316 - Kota Mojokerto</option>
                                            <option value="291">94911 - Kabupaten Morowali</option>
                                            <option value="292">31315 - Kabupaten Muara Enim</option>
                                            <option value="293">36311 - Kabupaten Muaro Jambi</option>
                                            <option value="294">38715 - Kabupaten Muko Muko</option>
                                            <option value="295">93611 - Kabupaten Muna</option>
                                            <option value="296">73911 - Kabupaten Murung Raya</option>
                                            <option value="297">30719 - Kabupaten Musi Banyuasin</option>
                                            <option value="298">31661 - Kabupaten Musi Rawas</option>
                                            <option value="299">98816 - Kabupaten Nabire</option>
                                            <option value="3">23951 - Kabupaten Aceh Besar</option>
                                            <option value="30">33613 - Kabupaten Bangka Tengah</option>
                                            <option value="300">23674 - Kabupaten Nagan Raya</option>
                                            <option value="301">86911 - Kabupaten Nagekeo</option>
                                            <option value="302">29711 - Kabupaten Natuna</option>
                                            <option value="303">99541 - Kabupaten Nduga</option>
                                            <option value="304">86413 - Kabupaten Ngada</option>
                                            <option value="305">64414 - Kabupaten Nganjuk</option>
                                            <option value="306">63219 - Kabupaten Ngawi</option>
                                            <option value="307">22876 - Kabupaten Nias</option>
                                            <option value="308">22895 - Kabupaten Nias Barat</option>
                                            <option value="309">22865 - Kabupaten Nias Selatan</option>
                                            <option value="31">69118 - Kabupaten Bangkalan</option>
                                            <option value="310">22856 - Kabupaten Nias Utara</option>
                                            <option value="311">77421 - Kabupaten Nunukan</option>
                                            <option value="312">30811 - Kabupaten Ogan Ilir</option>
                                            <option value="313">30618 - Kabupaten Ogan Komering Ilir</option>
                                            <option value="314">32112 - Kabupaten Ogan Komering Ulu</option>
                                            <option value="315">32211 - Kabupaten Ogan Komering Ulu Selatan</option>
                                            <option value="316">32312 - Kabupaten Ogan Komering Ulu Timur</option>
                                            <option value="317">63512 - Kabupaten Pacitan</option>
                                            <option value="318">25112 - Kota Padang</option>
                                            <option value="319">22763 - Kabupaten Padang Lawas</option>
                                            <option value="32">80619 - Kabupaten Bangli</option>
                                            <option value="320">22753 - Kabupaten Padang Lawas Utara</option>
                                            <option value="321">27122 - Kota Padang Panjang</option>
                                            <option value="322">25583 - Kabupaten Padang Pariaman</option>
                                            <option value="323">22727 - Kota Padang Sidempuan</option>
                                            <option value="324">31512 - Kota Pagar Alam</option>
                                            <option value="325">22272 - Kabupaten Pakpak Bharat</option>
                                            <option value="326">73112 - Kota Palangka Raya</option>
                                            <option value="327">30111 - Kota Palembang</option>
                                            <option value="328">91911 - Kota Palopo</option>
                                            <option value="329">94111 - Kota Palu</option>
                                            <option value="33">70619 - Kabupaten Banjar</option>
                                            <option value="330">69319 - Kabupaten Pamekasan</option>
                                            <option value="331">42212 - Kabupaten Pandeglang</option>
                                            <option value="332">46511 - Kabupaten Pangandaran</option>
                                            <option value="333">90611 - Kabupaten Pangkajene Kepulauan</option>
                                            <option value="334">33115 - Kota Pangkal Pinang</option>
                                            <option value="335">98765 - Kabupaten Paniai</option>
                                            <option value="336">91123 - Kota Parepare</option>
                                            <option value="337">25511 - Kota Pariaman</option>
                                            <option value="338">94411 - Kabupaten Parigi Moutong</option>
                                            <option value="339">26318 - Kabupaten Pasaman</option>
                                            <option value="34">46311 - Kota Banjar</option>
                                            <option value="340">26511 - Kabupaten Pasaman Barat</option>
                                            <option value="341">76211 - Kabupaten Paser</option>
                                            <option value="342">67153 - Kabupaten Pasuruan</option>
                                            <option value="343">67118 - Kota Pasuruan</option>
                                            <option value="344">59114 - Kabupaten Pati</option>
                                            <option value="345">26213 - Kota Payakumbuh</option>
                                            <option value="346">98354 - Kabupaten Pegunungan Arfak</option>
                                            <option value="347">99573 - Kabupaten Pegunungan Bintang</option>
                                            <option value="348">51161 - Kabupaten Pekalongan</option>
                                            <option value="349">51122 - Kota Pekalongan</option>
                                            <option value="35">70712 - Kota Banjarbaru</option>
                                            <option value="350">28112 - Kota Pekanbaru</option>
                                            <option value="351">28311 - Kabupaten Pelalawan</option>
                                            <option value="352">52319 - Kabupaten Pemalang</option>
                                            <option value="353">21126 - Kota Pematang Siantar</option>
                                            <option value="354">76311 - Kabupaten Penajam Paser Utara</option>
                                            <option value="355">35312 - Kabupaten Pesawaran</option>
                                            <option value="356">35974 - Kabupaten Pesisir Barat</option>
                                            <option value="357">25611 - Kabupaten Pesisir Selatan</option>
                                            <option value="358">24116 - Kabupaten Pidie</option>
                                            <option value="359">24186 - Kabupaten Pidie Jaya</option>
                                            <option value="36">70117 - Kota Banjarmasin</option>
                                            <option value="360">91251 - Kabupaten Pinrang</option>
                                            <option value="361">96419 - Kabupaten Pohuwato</option>
                                            <option value="362">91311 - Kabupaten Polewali Mandar</option>
                                            <option value="363">63411 - Kabupaten Ponorogo</option>
                                            <option value="364">78971 - Kabupaten Pontianak</option>
                                            <option value="365">78112 - Kota Pontianak</option>
                                            <option value="366">94615 - Kabupaten Poso</option>
                                            <option value="367">31121 - Kota Prabumulih</option>
                                            <option value="368">35719 - Kabupaten Pringsewu</option>
                                            <option value="369">67282 - Kabupaten Probolinggo</option>
                                            <option value="37">53419 - Kabupaten Banjarnegara</option>
                                            <option value="370">67215 - Kota Probolinggo</option>
                                            <option value="371">74811 - Kabupaten Pulang Pisau</option>
                                            <option value="372">97771 - Kabupaten Pulau Morotai</option>
                                            <option value="373">98981 - Kabupaten Puncak</option>
                                            <option value="374">98979 - Kabupaten Puncak Jaya</option>
                                            <option value="375">53312 - Kabupaten Purbalingga</option>
                                            <option value="376">41119 - Kabupaten Purwakarta</option>
                                            <option value="377">54111 - Kabupaten Purworejo</option>
                                            <option value="378">98489 - Kabupaten Raja Ampat</option>
                                            <option value="379">39112 - Kabupaten Rejang Lebong</option>
                                            <option value="38">92411 - Kabupaten Bantaeng</option>
                                            <option value="380">59219 - Kabupaten Rembang</option>
                                            <option value="381">28992 - Kabupaten Rokan Hilir</option>
                                            <option value="382">28511 - Kabupaten Rokan Hulu</option>
                                            <option value="383">85982 - Kabupaten Rote Ndao</option>
                                            <option value="384">23512 - Kota Sabang</option>
                                            <option value="385">85391 - Kabupaten Sabu Raijua</option>
                                            <option value="386">50711 - Kota Salatiga</option>
                                            <option value="387">75133 - Kota Samarinda</option>
                                            <option value="388">79453 - Kabupaten Sambas</option>
                                            <option value="389">22392 - Kabupaten Samosir</option>
                                            <option value="39">55715 - Kabupaten Bantul</option>
                                            <option value="390">69219 - Kabupaten Sampang</option>
                                            <option value="391">78557 - Kabupaten Sanggau</option>
                                            <option value="392">99373 - Kabupaten Sarmi</option>
                                            <option value="393">37419 - Kabupaten Sarolangun</option>
                                            <option value="394">27416 - Kota Sawah Lunto</option>
                                            <option value="395">79583 - Kabupaten Sekadau</option>
                                            <option value="396">92812 - Kabupaten Selayar (Kepulauan Selayar)</option>
                                            <option value="397">38811 - Kabupaten Seluma</option>
                                            <option value="398">50511 - Kabupaten Semarang</option>
                                            <option value="399">50135 - Kota Semarang</option>
                                            <option value="4">23654 - Kabupaten Aceh Jaya</option>
                                            <option value="40">30911 - Kabupaten Banyuasin</option>
                                            <option value="400">97561 - Kabupaten Seram Bagian Barat</option>
                                            <option value="401">97581 - Kabupaten Seram Bagian Timur</option>
                                            <option value="402">42182 - Kabupaten Serang</option>
                                            <option value="403">42111 - Kota Serang</option>
                                            <option value="404">20915 - Kabupaten Serdang Bedagai</option>
                                            <option value="405">74211 - Kabupaten Seruyan</option>
                                            <option value="406">28623 - Kabupaten Siak</option>
                                            <option value="407">22522 - Kota Sibolga</option>
                                            <option value="408">91613 - Kabupaten Sidenreng Rappang/Rapang</option>
                                            <option value="409">61219 - Kabupaten Sidoarjo</option>
                                            <option value="41">53114 - Kabupaten Banyumas</option>
                                            <option value="410">94364 - Kabupaten Sigi</option>
                                            <option value="411">27511 - Kabupaten Sijunjung (Sawah Lunto Sijunjung)
                                            </option>
                                            <option value="412">86121 - Kabupaten Sikka</option>
                                            <option value="413">21162 - Kabupaten Simalungun</option>
                                            <option value="414">23891 - Kabupaten Simeulue</option>
                                            <option value="415">79117 - Kota Singkawang</option>
                                            <option value="416">92615 - Kabupaten Sinjai</option>
                                            <option value="417">78619 - Kabupaten Sintang</option>
                                            <option value="418">68316 - Kabupaten Situbondo</option>
                                            <option value="419">55513 - Kabupaten Sleman</option>
                                            <option value="42">68416 - Kabupaten Banyuwangi</option>
                                            <option value="420">27365 - Kabupaten Solok</option>
                                            <option value="421">27315 - Kota Solok</option>
                                            <option value="422">27779 - Kabupaten Solok Selatan</option>
                                            <option value="423">90812 - Kabupaten Soppeng</option>
                                            <option value="424">98431 - Kabupaten Sorong</option>
                                            <option value="425">98411 - Kota Sorong</option>
                                            <option value="426">98454 - Kabupaten Sorong Selatan</option>
                                            <option value="427">57211 - Kabupaten Sragen</option>
                                            <option value="428">41215 - Kabupaten Subang</option>
                                            <option value="429">24882 - Kota Subulussalam</option>
                                            <option value="43">70511 - Kabupaten Barito Kuala</option>
                                            <option value="430">43311 - Kabupaten Sukabumi</option>
                                            <option value="431">43114 - Kota Sukabumi</option>
                                            <option value="432">74712 - Kabupaten Sukamara</option>
                                            <option value="433">57514 - Kabupaten Sukoharjo</option>
                                            <option value="434">87219 - Kabupaten Sumba Barat</option>
                                            <option value="435">87453 - Kabupaten Sumba Barat Daya</option>
                                            <option value="436">87358 - Kabupaten Sumba Tengah</option>
                                            <option value="437">87112 - Kabupaten Sumba Timur</option>
                                            <option value="438">84315 - Kabupaten Sumbawa</option>
                                            <option value="439">84419 - Kabupaten Sumbawa Barat</option>
                                            <option value="44">73711 - Kabupaten Barito Selatan</option>
                                            <option value="440">45326 - Kabupaten Sumedang</option>
                                            <option value="441">69413 - Kabupaten Sumenep</option>
                                            <option value="442">37113 - Kota Sungaipenuh</option>
                                            <option value="443">98164 - Kabupaten Supiori</option>
                                            <option value="444">60119 - Kota Surabaya</option>
                                            <option value="445">57113 - Kota Surakarta (Solo)</option>
                                            <option value="446">71513 - Kabupaten Tabalong</option>
                                            <option value="447">82119 - Kabupaten Tabanan</option>
                                            <option value="448">92212 - Kabupaten Takalar</option>
                                            <option value="449">98475 - Kabupaten Tambrauw</option>
                                            <option value="45">73671 - Kabupaten Barito Timur</option>
                                            <option value="450">77611 - Kabupaten Tana Tidung</option>
                                            <option value="451">91819 - Kabupaten Tana Toraja</option>
                                            <option value="452">72211 - Kabupaten Tanah Bumbu</option>
                                            <option value="453">27211 - Kabupaten Tanah Datar</option>
                                            <option value="454">70811 - Kabupaten Tanah Laut</option>
                                            <option value="455">15914 - Kabupaten Tangerang</option>
                                            <option value="456">15111 - Kota Tangerang</option>
                                            <option value="457">15435 - Kota Tangerang Selatan</option>
                                            <option value="458">35619 - Kabupaten Tanggamus</option>
                                            <option value="459">21321 - Kota Tanjung Balai</option>
                                            <option value="46">73881 - Kabupaten Barito Utara</option>
                                            <option value="460">36513 - Kabupaten Tanjung Jabung Barat</option>
                                            <option value="461">36719 - Kabupaten Tanjung Jabung Timur</option>
                                            <option value="462">29111 - Kota Tanjung Pinang</option>
                                            <option value="463">22742 - Kabupaten Tapanuli Selatan</option>
                                            <option value="464">22611 - Kabupaten Tapanuli Tengah</option>
                                            <option value="465">22414 - Kabupaten Tapanuli Utara</option>
                                            <option value="466">71119 - Kabupaten Tapin</option>
                                            <option value="467">77114 - Kota Tarakan</option>
                                            <option value="468">46411 - Kabupaten Tasikmalaya</option>
                                            <option value="469">46116 - Kota Tasikmalaya</option>
                                            <option value="47">90719 - Kabupaten Barru</option>
                                            <option value="470">20632 - Kota Tebing Tinggi</option>
                                            <option value="471">37519 - Kabupaten Tebo</option>
                                            <option value="472">52419 - Kabupaten Tegal</option>
                                            <option value="473">52114 - Kota Tegal</option>
                                            <option value="474">98551 - Kabupaten Teluk Bintuni</option>
                                            <option value="475">98591 - Kabupaten Teluk Wondama</option>
                                            <option value="476">56212 - Kabupaten Temanggung</option>
                                            <option value="477">97714 - Kota Ternate</option>
                                            <option value="478">97815 - Kota Tidore Kepulauan</option>
                                            <option value="479">85562 - Kabupaten Timor Tengah Selatan</option>
                                            <option value="48">29413 - Kota Batam</option>
                                            <option value="480">85612 - Kabupaten Timor Tengah Utara</option>
                                            <option value="481">22316 - Kabupaten Toba Samosir</option>
                                            <option value="482">94683 - Kabupaten Tojo Una-Una</option>
                                            <option value="483">94542 - Kabupaten Toli-Toli</option>
                                            <option value="484">99411 - Kabupaten Tolikara</option>
                                            <option value="485">95416 - Kota Tomohon</option>
                                            <option value="486">91831 - Kabupaten Toraja Utara</option>
                                            <option value="487">66312 - Kabupaten Trenggalek</option>
                                            <option value="488">97612 - Kota Tual</option>
                                            <option value="489">62319 - Kabupaten Tuban</option>
                                            <option value="49">51211 - Kabupaten Batang</option>
                                            <option value="490">34613 - Kabupaten Tulang Bawang</option>
                                            <option value="491">34419 - Kabupaten Tulang Bawang Barat</option>
                                            <option value="492">66212 - Kabupaten Tulungagung</option>
                                            <option value="493">90911 - Kabupaten Wajo</option>
                                            <option value="494">93791 - Kabupaten Wakatobi</option>
                                            <option value="495">98269 - Kabupaten Waropen</option>
                                            <option value="496">34711 - Kabupaten Way Kanan</option>
                                            <option value="497">57619 - Kabupaten Wonogiri</option>
                                            <option value="498">56311 - Kabupaten Wonosobo</option>
                                            <option value="499">99041 - Kabupaten Yahukimo</option>
                                            <option value="5">23719 - Kabupaten Aceh Selatan</option>
                                            <option value="50">36613 - Kabupaten Batang Hari</option>
                                            <option value="500">99481 - Kabupaten Yalimo</option>
                                            <option value="501">55111 - Kota Yogyakarta</option>
                                            <option value="51">65311 - Kota Batu</option>
                                            <option value="52">21655 - Kabupaten Batu Bara</option>
                                            <option value="53">93719 - Kota Bau-Bau</option>
                                            <option value="54">17837 - Kabupaten Bekasi</option>
                                            <option value="55">17121 - Kota Bekasi</option>
                                            <option value="56">33419 - Kabupaten Belitung</option>
                                            <option value="57">33519 - Kabupaten Belitung Timur</option>
                                            <option value="58">85711 - Kabupaten Belu</option>
                                            <option value="59">24581 - Kabupaten Bener Meriah</option>
                                            <option value="6">24785 - Kabupaten Aceh Singkil</option>
                                            <option value="60">28719 - Kabupaten Bengkalis</option>
                                            <option value="61">79213 - Kabupaten Bengkayang</option>
                                            <option value="62">38229 - Kota Bengkulu</option>
                                            <option value="63">38519 - Kabupaten Bengkulu Selatan</option>
                                            <option value="64">38319 - Kabupaten Bengkulu Tengah</option>
                                            <option value="65">38619 - Kabupaten Bengkulu Utara</option>
                                            <option value="66">77311 - Kabupaten Berau</option>
                                            <option value="67">98119 - Kabupaten Biak Numfor</option>
                                            <option value="68">84171 - Kabupaten Bima</option>
                                            <option value="69">84139 - Kota Bima</option>
                                            <option value="7">24476 - Kabupaten Aceh Tamiang</option>
                                            <option value="70">20712 - Kota Binjai</option>
                                            <option value="71">29135 - Kabupaten Bintan</option>
                                            <option value="72">24219 - Kabupaten Bireuen</option>
                                            <option value="73">95512 - Kota Bitung</option>
                                            <option value="74">66171 - Kabupaten Blitar</option>
                                            <option value="75">66124 - Kota Blitar</option>
                                            <option value="76">58219 - Kabupaten Blora</option>
                                            <option value="77">96319 - Kabupaten Boalemo</option>
                                            <option value="78">16911 - Kabupaten Bogor</option>
                                            <option value="79">16119 - Kota Bogor</option>
                                            <option value="8">24511 - Kabupaten Aceh Tengah</option>
                                            <option value="80">62119 - Kabupaten Bojonegoro</option>
                                            <option value="81">95755 - Kabupaten Bolaang Mongondow (Bolmong)</option>
                                            <option value="82">95774 - Kabupaten Bolaang Mongondow Selatan</option>
                                            <option value="83">95783 - Kabupaten Bolaang Mongondow Timur</option>
                                            <option value="84">95765 - Kabupaten Bolaang Mongondow Utara</option>
                                            <option value="85">93771 - Kabupaten Bombana</option>
                                            <option value="86">68219 - Kabupaten Bondowoso</option>
                                            <option value="87">92713 - Kabupaten Bone</option>
                                            <option value="88">96511 - Kabupaten Bone Bolango</option>
                                            <option value="89">75313 - Kota Bontang</option>
                                            <option value="9">24611 - Kabupaten Aceh Tenggara</option>
                                            <option value="90">99662 - Kabupaten Boven Digoel</option>
                                            <option value="91">57312 - Kabupaten Boyolali</option>
                                            <option value="92">52212 - Kabupaten Brebes</option>
                                            <option value="93">26115 - Kota Bukittinggi</option>
                                            <option value="94">81111 - Kabupaten Buleleng</option>
                                            <option value="95">92511 - Kabupaten Bulukumba</option>
                                            <option value="96">77211 - Kabupaten Bulungan (Bulongan)</option>
                                            <option value="97">37216 - Kabupaten Bungo</option>
                                            <option value="98">94564 - Kabupaten Buol</option>
                                            <option value="99">97371 - Kabupaten Bur</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="order-details">
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>CART TOTALS</h2>
                                <div class="content">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">Cart
                                            Subtotal<span>{{ Helper::rupiahFormatter(Helper::totalCartPrice(), 2) }}</span>
                                        </li>
                                        <li class="shipping">
                                            Shipping Cost
                                            @if (Helper::cartCount() > 0)
                                                <select name="shipping" class="nice-select">
                                                    <option value="">Select your address</option>
                                                </select>
                                            @else
                                                <span>Free</span>
                                            @endif
                                        </li>

                                        @if (session('coupon'))
                                            <li class="coupon_price" data-price="{{ session('coupon')['value'] }}">You
                                                Save<span>{{ Helper::rupiahFormatter(session('coupon')['value'], 2) }}</span>
                                            </li>
                                        @endif
                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if (session('coupon')) {
                                                $total_amount = $total_amount - session('coupon')['value'];
                                            }
                                        @endphp
                                        @if (session('coupon'))
                                            <li class="last" id="order_total_price">
                                                Total<span>{{ Helper::rupiahFormatter($total_amount, 2) }}</span></li>
                                        @else
                                            <li class="last" id="order_total_price">
                                                Total<span>{{ Helper::rupiahFormatter($total_amount, 2) }}</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>Payments</h2>
                                <div class="content">
                                    <div class="checkbox">
                                        {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                        <form-group>
                                            <input name="payment_method" type="radio" value="cod"> <label> Cash On
                                                Delivery</label><br>
                                        </form-group>

                                    </div>
                                </div>
                            </div>
                            <!--/ End Order Widget -->

                            <!-- Button Widget -->
                            <div class="single-widget get-button">
                                <div class="content">
                                    <div class="button">
                                        <button type="submit" class="btn">proceed to checkout</button>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Button Widget -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--/ End Checkout -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shipping</h4>
                        <p>Orders over $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Secure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Price</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services -->

    <!-- Start Shop Newsletter  -->
    <section class="shop-newsletter section">
        <div class="container">
            <div class="inner-top">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <!-- Start Newsletter Inner -->
                        <div class="inner">
                            <h4>Newsletter</h4>
                            <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="EMAIL" placeholder="Your email address" required="" type="email">
                                <button class="btn">Subscribe</button>
                            </form>
                        </div>
                        <!-- End Newsletter Inner -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->
@endsection
@push('styles')
    <style>
        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();
    </script>
    <script>
        function showMe(box) {
            var checkbox = document.getElementById('shipping').style.display;
            // alert(checkbox);
            var vis = 'none';
            if (checkbox == "none") {
                vis = 'block';
            }
            if (checkbox == "block") {
                vis = "none";
            }
            document.getElementById(box).style.display = vis;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.shipping select[name=shipping]').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                // alert(coupon);
                $('#order_total_price span').text(new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(subtotal + cost - coupon));
            });

            checkPostCode = () => {
                $('.preloader').fadeIn('slow');

                $.ajax({
                    url: "{{ route('order.getCourier') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: $('#post_code').val()
                    },
                    success: function(response) {
                        $('[name="shipping"]').html('<option value="">Select your address</option>')
                        if (response.success) {
                            response.data.map((data) => {
                                $('[name="shipping"]').append(
                                    `<option value="${data.id}" class="shippingOption" data-price="${data.cost}">${data.name}</option>`
                                    )
                            })
                        }

                        $('[name="shipping"]').next('.nice-select').remove();
                        $('[name="shipping"]').niceSelect();
                    },
                    error: function(xhr) {
                        // Handle error response
                        console.error(xhr.responseText);
                    }
                });
                $('.preloader').delay(2000).fadeOut('slow');

            }

        });
    </script>
@endpush

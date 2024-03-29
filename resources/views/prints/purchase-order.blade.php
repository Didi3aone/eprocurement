<?php
libxml_use_internal_errors(true);
?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $vendor->name."_".'0000' }}</title>
    <style>
         @page {
            size:  auto;
            margin: 8mm 4mm;
            counter-increment: page;
            counter-reset: page 1;
        }
        /* @font-face {
            font-family:"1979 Dot Matrix Regular";
            src:url("{{public_path('printer/1979_dot_matrix.eot?')}}") format("eot"),url("{{ public_path('printer/1979_dot_matrix.woff')}}") format("woff"),url("{{ public_path('printer/1979_dot_matrix.ttf') }}") format("truetype"),url("{{ public_path('printer/1979_dot_matrix.svg#1979-Dot-Matrix') }}") format("svg");
            font-weight:normal;
            font-style:normal;
        } */
        div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, font, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-weight: inherit;
            font-style: inherit;
            font-size: 100%;
            font-family: "Times New Roman", Times, serif;
            vertical-align: top;
        }
        /* remember to define focus styles! */
        :focus {
            outline: 0;
        }
        body {
            line-height: 1;
            color: black;
            background: white;
        }
        ol, ul {
            list-style: none;
        }
        /* tables still need 'cellspacing="0"' in the markup */
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        caption, th, td {
            text-align: left;
            font-weight: normal;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {
            content: "";
        }
        blockquote, q {
            quotes: "" "";
        }
        .row {
            width: 100%;
            display: block;
        }
        .row {
            width: 100%;
            display: block;
        }
        .row > div {
            display: inline-block;
            vertical-align: top;
        }
        .row .left {
            width: 27%;
        }
        .row .middle {
            width: 44%;
            text-align: center;
        }
        .row .right {
            width: 27%;
        }
        p {
            font-size: 12px;
        }
        table.table {
            width: 100%;
            margin-top: 1px;
            font-size: 12px;
            border-top: 1px solid #000;
            border-left: 1px solid #000;
        }
        table th, table td {
            padding: 4px 2px;
        }
        table thead tr th {
            font-weight: bold;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        table thead th, table tbody {
            white-space: nowrap;
            text-align: center;
            padding: 4px 2px;
        }
        table tbody tr td {
            border-right: 1px solid #000;
            /* overflow:hidden; */
            margin-top:1.5px;
        }   
        table tbody tr:last-child td {
            border-bottom: 1px solid #000;
        }
        table tfoot tr td {
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        table tbody td:nth-child(3), table tbody td:nth-child(4) {
            white-space: wrap;
        }
        .to-top {
            padding-top: 3.8px;
        }
    </style>
</head>
<body>
    @php
        if (!function_exists('cutWord'))  
        { 
            function cutWord($text, $length, $count = 6) {
                $numwords = $count;
                preg_match("/(\S+\s*){0,$numwords}/", $text, $regs);
                if(strlen($regs[0])>$length) {
                    return trim(cutWord($regs[0], $length, $count-1));
                }
                return trim($regs[0]);
            }
        }  

        if (!function_exists('trimLongText'))  
        { 
            function trimLongText($string, $length=28) {
                $tick = strlen($string)>$length?'...':'';
                return cutWord($string, $length).$tick;
                return mb_strimwidth($string, 0, $length, "-");
            }
        }
    @endphp
    <div class="page">
        <!-- Header Start -->
        <div class="header row">
            <div class="left">
                <div class="row">
                    <div style="width: 25%;">
                        <img src="{{ $print ? asset('index.jpg') : public_path('index.jpg') }}" style="position:absolute; top: -4px;" height="70">
                    </div>
                    <div style="width: 74%;">
                        @if($data['plant_code'][0] == '1101')
                            <p class="to-top">
                                PT. Herlina Indah <br>
                            </p>
                            <p class="to-top">
                                Jl. Rawa Sumur II Blok DD.16 
                            </p>
                            <p class="to-top">
                                Pulo Gadung Industri Estate,
                            </p> 
                            <p class="to-top">
                                Jakarta
                            </p>
                            <p class="to-top">
                                13930 
                            </p>
                        @elseif($data['plant_code'][0] == '2101')
                            <p class="to-top">
                                PT. Marketama Indah 
                            </p>
                            <p class="to-top">
                                Jl. Rawa Sumur II Blok DD.16 
                            </p>
                            <p class="to-top">
                                Pulo Gadung Industri Estate,
                            </p> 
                            <p class="to-top">
                                Jakarta
                            </p>
                            <p class="to-top">
                                13930 
                            </p>
                        @elseif($data['plant_code'][0] == '1201')
                            <p class="to-top">
                                PT. Sari Enesis Indah Cikarang
                            </p>
                            <p class="to-top">
                                Jl. Kruing I Blok L5 No. 5, 
                            </p>
                            <p class="to-top">
                                Delta Silicon Industrial Estate,
                            </p> 
                            <p class="to-top">
                                Cikarang Bekasi
                            </p>
                            <p class="to-top">
                                17550 
                            </p>
                        @elseif($data['plant_code'][0] == '1202')
                            <p class="to-top">
                                PT. Sari Enesis Indah Ciawi
                            </p>
                            <p class="to-top">
                                Jl. Veteran II RT 004/ RW 006  
                            </p>
                            <p class="to-top">
                                Kel.Teluk Pinang,
                            </p> 
                            <p class="to-top">
                                Kec. Ciawi Kab. Bogor
                            </p>
                            <p class="to-top">
                                16720 
                            </p>
                        @endif
                    </div>
                </div>
                <div class="row" style="margin-top: 2px;">
                    <div style="width: 25%;" align="center">
                        <p>To :</p>
                    </div>
                    <div>
                        {{-- <p style="font-size: 11px;">
                            {{ trim($vendor->name) }} <br>
                            {{ trim($vendor->street) }} <br/>
                            Telp. {{ trim($vendor->office_telephone) }} <br/>
                        </p> --}}
                        <p>
                        {{ trim($vendor->name) }} 
                        </p>
                        <p class="to-top">
                        {{ trim($vendor->street) }} 
                        {{-- {{ trim($vendor->street_2) }} 
                        {{ trim($vendor->street_3) }}  --}}
                        </p>
                        <p class="to-top">
                        {{ trim($vendor->street_2) }}
                        </p>
                        <p class="to-top">
                        {{ trim($vendor->street_3) }} 
                        </p>
                        <p class="to-top">
                        Telp. {{ trim($vendor->office_telephone) }} 
                        </p>
                    </div>
                </div>
            </div>
            <div class="middle">
                <h6>
                    <b>PURCHASE ORDER</b>
                </h6>
            </div>
            <div class="right">
                <p style="margin-bottom: 6px">    PO NO &nbsp;&nbsp;&nbsp;&nbsp;: {{ '000000' }}</p>
                <p style="margin-bottom: 6px">    Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ date('d.m.Y') }} </p>
                <p style="margin-bottom: 6px">    Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ '0000' }} </p>
                <p></p>
                <br>
                <p class="to-top">
                    Shipped To: <br>
                </p>
                    {{-- {{dd($ship)}} --}}
                    {{-- <p> {{ $ship->name }} <p>
                    <p> {{ $ship->alamat }} </p> <br> --}}
                    <p class="to-top">
                    {{ $ship->name }}
                    </p>
                    <p class="to-top">
                    {{ $ship->alamat }}
                    </p> 
                {{-- </p> --}}
            </div>
        </div>
        <!-- End Header -->
        <!-- Table Start -->
        <table class="table" >
            <thead>
                <tr>
                    <th width=''>No</th>
                    <th width=''>Item Code </th>
                    <th width=''>Description </th>
                    <th width=''>Spesification </th>
                    <th width=''>Delivery Deadline </th>
                    <th width=''>Qty Units </th>
                    <th width=''>PR Ref </th>
                    <th width=''>Price ({{ $data['currency'] }})</th>
                    <th width=''>Total Price ({{ $data['currency'] }})</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $totalTax = 0;
                @endphp
                {{-- {{ dd($data) }} --}}
                @foreach($data['id'] as $key => $value)
                    @php
                        $materialId = $data['material_id'][$key];
                        if( $materialId == '' ) {
                            $materialId = $data['short_text'][$key];
                        }
                        
                        $tax = 0;

                        if ($data['acp_id'][$key] == '0') {
                            $getRfq= \App\Models\RfqDetail::where('rfq_number',$data['rfq'][$key] )->first();
                            $totalPrice = (\removeComma($data['price'][$key])/$getRfq->per_unit) * ($data['qty'][$key]);
                            if( isset($data['tax_code'])) {
                                $tax = ($totalPrice) * 10/100;
                            }
                        } else {
                            $qtyAcp = \App\Models\AcpTableMaterial::getQtyAcp($materialId, $data['acp_id'][$key]);
                            $perQty = ($data['qty'][$key]/$qtyAcp->qty);
                            $totalPrice = (\removeComma($data['price'][$key]) * $perQty);
                            if( isset($data['tax_code'])) {
                                $tax = ($totalPrice) * 10/100;
                            }
                        }
                        $totalTax += $tax;
                        $material = \App\Models\PurchaseRequestsDetail::where('material_id', $data['material_id'][$key])->first();
                        $totalRows = count($data['id']);
                        $total += \removeComma($data['price'][$key]) * $data['qty'][$key] ;

                        $cols = "";
                        if( $totalRows == $key+1 ){
                            $cols = "10";
                        }
                        $size = $key+1===count($data['id']) ? (600-($key*30)).'px' : 'auto';
                    @endphp
                <tr>
                    <td>
                        <div style="display:block; height: {{ $size }}; min-height: {{ $size }};">{{ $key + 1 }}</div>
                    </td>
                    <td>{{ $data['material_id'][$key] ?? '' }}</td>
                    <td style="word-wrap: break-word; overflow:hidden; " width="150px">
                        {!! \wordwrap($data['short_text'][$key],20,'<br>') !!}
                    </td>
                    <td>
                        {!! \wordwrap($data['notes_detail'][$key],20,'<br>') !!}
                    </td>
                    <td style="text-align: center">{{ date('d.m.Y',strtotime($data['delivery_date_new'][$key])) }}</td>
                    <td style="text-align: center">{{ $data['qty'][$key]." ".\App\Models\UomConvert::where('uom_1', $data['unit'][$key])->first()->uom_2}}</td>
                    <td>{{ $data['PR_NO'][$key] }}</td>
                    {{-- <td>{{ \toDecimal(\removeComma($data['price'][$key])) }}</td>
                    <td>{{ \toDecimal(\removeComma($data['price'][$key])) }}</td> --}}
                    <td style="text-align: right">{{ \toDecimal(\removeComma($data['price'][$key])) }}</td>
                    <td style="text-align: right">{{ \toDecimal($totalPrice) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @php
                    $grandTotal = ($totalPrice + $totalTax);
                @endphp
                <tr>
                    <td rowspan="3" colspan="5">
                        <p>
                            Amount <br>
                            <br>
                            {{ ucfirst(Terbilang::make($grandTotal)) }} Rupiah
                            <br>
                            <br>
                        </p>
                    </td>
                    <td colspan="3">Total ({{ $data['currency'] }})</td>
                    <td colspan="1" style="text-align: right">{{ \toDecimal($totalPrice) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Tax ({{ $data['currency'] }})</td>
                    <td colspan="1" style="text-align: right">{{ \toDecimal($totalTax) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Grand Total ({{ $data['currency'] }})</td>
                    <td colspan="1" style="text-align: right">{{ \toDecimal($grandTotal) }}</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>
                        Term of payment
                            : {{ $paymentTerm->no_of_days." days" }}
                        </p>
                    </td>
                    <td colspan="4">{{ $data['payment_terms'] }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center">
                        Supplier *) <br>
                        <br>
                        <br>
                        <br>
                        <p>
                            (................)
                        </p>
                    </td>
                    <td colspan="3" style="text-align:center">
                        Approve By *) <br>
                        <br>
                        <p>{{ date('d.m.y H:i:s') }}</p>
                        <p>
                            This document has been electronically approved. <br>
                            Signature is no longer required
                        </p>
                        <br>
                    </td>
                    <td colspan="4">
                        <p style="margin-bottom: 6px"> Notes : </p>
                        <p style="margin-bottom: 6px">        1. Invoicing will be done on Tuesday 09.00am - 5.00pm </p>
                        <p style="margin-bottom: 6px">        2. Delivery not on schedule, will be refused </p>
                        <p style="margin-bottom: 6px">        3. Please bring along print out purchase order when invoicing  </p>
                    </td>
                </tr>
            </tfoot>
        </table>
        <!-- End Table -->
    </div>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "{PAGE_NUM} Page Of {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>
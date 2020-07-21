<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $po->vendors['name']."_".$po->PO_NUMBER }}</title>
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
            font-family: inherit;
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
            margin-top: 18px;
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
        table thead th, table tbody td {
            white-space: nowrap;
            text-align: center;
            padding: 4px 2px;
        }
        table tbody tr td {
            border-right: 1px solid #000;
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
    </style>
</head>
<body>
    <div class="page">
        <!-- Header Start -->
        <div class="header row">
            <div class="left">
                <div class="row">
                    <div style="width: 20%;">
                        <img src="{{ $print ? asset('index.jpg') : public_path('index.jpg') }}" style="position:absolute; top: -4px;" height="70">
                    </div>
                    <div style="width: 74%;">
                        <p>
                        @if($po->orderDetail[0]['plant_code'] == '1101')
                        PT. Herlina Indah <br>
                        @elseif($po->orderDetail[0]['plant_code'] == '2101')
                        PT. Marketama Indah 
                        @elseif($po->orderDetail[0]['plant_code'] == '1201' OR $po->orderDetail[0]['plant_code'] == '1201')
                        PT. Sari Enesis Indah 
                        @endif
                        Jl. Rawa Sumur II Blok DD.16 <br>
                        Pulo Gadung Industri Estate, Jakarta <br>
                        13930 <br>
                        </p>
                    </div>
                </div>
                <div class="row" style="margin-top: 8px;">
                    <div>
                        <p>To:</p>
                    </div>
                    <div>
                        <p>
                            {{ $po->vendors['name'] }} <br>
                            {{ $po->vendors['street'] }} <br/>
                            Telp. {{ $po->vendors['office_telephone'] }} <br/>
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
                <p>
                    PO NO &nbsp;&nbsp;&nbsp;: {{ $po->PO_NUMBER }}<br>
                    Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ date('d.m.Y') }} <br>
                    Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ '0000' }} <br>
                </p>
                <p></p>
                <br>
                <p>
                    Shipped T0: <br>
                    @if($po->orderDetail[0]['plant_code'] == '1101')
                        Herlina Indah <br>
                    @elseif($po->orderDetail[0]['plant_code'] == '2101')
                        Marketama Indah 
                    @elseif($po->orderDetail[0]['plant_code'] == '1201' OR $po->orderDetail[0]['plant_code'] == '1201')
                        Sari Enesis Indah 
                    @endif
                    Jl. Rawa Sumur II Blok DD.16 <br>
                    Pulo Gadung Industri Estate, Jakarta <br>
                </p>
            </div>
        </div>
        <!-- End Header -->
        <!-- Table Start -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Code </th>
                    <th>Description </th>
                    <th>Spesification </th>
                    <th>Delivery Deadline </th>
                    <th>Qty Units </th>
                    <th>PR Ref </th>
                    <th>Price </th>
                    <th>Total Price </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $totalTax = 0;
                @endphp
                @foreach($po->orderDetail as $key => $value)
                    @php
                        $tax = 0;
                        if( $value->tax_code == 'V1' ) {
                            $tax = ($value->price * 10/100);
                        }

                        $totalTax += $tax;

                        $totalRows = count($po->orderDetail);
                        $total += $value->price;

                        $cols = "";
                        if( $totalRows == $key+1 ){
                            $cols = "10";
                        }
                        $size = $key+1===count($po->orderDetail) ? (700-($key*20)).'px' : 'auto';
                    @endphp
                <tr>
                    <td>
                        <div style="display:block; height: {{ $size }}; min-height: {{ $size }};">{{ $key + 1 }}</div>
                    </td>
                    <td>{{ $value->material_id ?? '' }}</td>
                    <td>{{ $value->short_text }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ date('d-m-Y',strtotime($value->delivery_date)) }}</td>
                    <td>{{ $value->qty." - ".$value->unit }}</td>
                    <td>{{ $value->PR_NO }}</td>
                    <td>{{ \toDecimal($value->price) }}</td>
                    <td>{{ \toDecimal($value->price) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @php
                    $grandTotal = ($total + $totalTax);
                @endphp
                <tr>
                    <td rowspan="3" colspan="5">
                        <p>
                            Amount <br>
                            <br>
                            {{ ucfirst(Terbilang::make($grandTotal)) }}
                            <br>
                            <br>
                        </p>
                    </td>
                    <td colspan="3">Total</td>
                    <td colspan="1">{{ \toDecimal($total) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Tax</td>
                    <td colspan="1">{{ \toDecimal($totalTax) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Grand Total</td>
                    <td colspan="1">{{ \toDecimal($grandTotal) }}</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>
                        Term of payment
                            : {{ $po->paymentTerm['no_of_days'] }}
                        </p>
                    </td>
                    <td colspan="4">{{ $po->notes }}</td>
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
                        <p>{{ date('d.m.y H:i:s',strtotime($po->updated_at)) }}</p>
                        <p>
                            This document has been electronically approved. <br>
                            Signature is no longer required
                        </p>
                        <br>
                    </td>
                    <td colspan="4">
                        <p>
                            Notes : <br>
                                1. Invoicing will be done on Tuesday 09.00am - 5.00pm <br>
                                2. Delivery not on schedule, will be refused <br>
                                3. Please bring along print out purchase order when invoicing <br>
                        </p>
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
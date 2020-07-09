<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $po->vendors['name']."_".$po->PO_NUMBER }}</title>
    <style>
        @page {
            size:  auto;
            margin: 0mm;
            @bottom-right {
                content: counter(page) " of " counter(pages);
            }
            counter-increment: page;
            counter-reset: page 1;
            @top-right {
                content: "Page " counter(page) " of " counter(pages);
            }
            /**size: 500mm 200mm potrait;*/
        }
        @font-face {
            font-family:"1979 Dot Matrix Regular";
            src:url("/printer/1979_dot_matrix.eot?") format("eot"),url("/printer/1979_dot_matrix.woff") format("woff"),url("/printer/1979_dot_matrix.ttf") format("truetype"),url("/printer/1979_dot_matrix.svg#1979-Dot-Matrix") format("svg");
            font-weight:normal;
            font-style:normal;
        }
        html
        {
            margin: 0px;  /* this affects the margin on the html before sending to printer */
        }
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "1979 Dot Matrix Regular";
            font-size: 3mm;
            margin: 0mm;
            padding: 0mm;
            line-height: 4mm;
        }
        .page {
            /*width: 210mm;
            height: 148mm;*/
            position: fixed;
            /* background: none; */
            /* border: none; */
        }
        p {
            margin: 0 0 1mm 0;
            background-color: none;
        }
        div {
            background-color: none;
            /*#f7f7f7;*/
        }
        .title {
            font-weight: bold;
        }
        .list-product {
            height: 62mm;
            overflow: hidden;
            padding-top:19px;
        }
        .list-product p {
            margin: 0;
        }
        table {
            border-collapse: collapse;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding:1mm 3mm 0.5mm 0mm;
            /* border:none; */
            font-family: "1979 Dot Matrix Regular";
            font-size: 3mm;
            margin: 0mm;
            padding: 0mm;
            line-height: 4mm;
            text-align:center;
        }
        .table>thead {
            text-align: left;
            font-family: "1979 Dot Matrix Regular";
            font-size: 3mm;
            margin: 0mm;
            padding: 0mm;
            line-height: 4mm;
        }
        .table>tbody>tr>td:last-child, .table>tbody>tr>th:last-child,.table>thead>tr>td:last-child, .table>thead>tr>th:last-child {
            padding-right: 0mm;
        }

        hr {
            border: 1px solid black;
        }
        #pageFooter:after {
            counter-increment: page;
            content:"Page " counter(page);
            left: 0; 
            top: 100%;
            white-space: nowrap; 
            z-index: 20;
            -moz-border-radius: 5px; 
            -moz-box-shadow: 0px 0px 4px #222;  
            background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);  
        }
        #content {
            display: table;
        }

        #pageFooter {
            display: table-footer-group;
        }

        #pageFooter:after {
            counter-increment: page;
            content: counter(page);
        }
    </style>
</head>
<body onload="onbeforeunload()">
    <div class="page">
        <div style="position: fixed;margin-top: 10mm;margin-left: 5mm;">
            <h2>
                <img src="{{ asset('index.jpg') }}" style="margin-left:" height=80>
            </h2>
        </div>
        <div style="position: fixed;margin-top: 14mm;margin-left: 19mm;">
            PT. Herlina Indah <br>
            Jl. Rawa Sumur II Blok DD.16 <br>
            Pulo Gadung Industri Estate, Jakarta <br>
            13930 <br>
        </div>
        <div style="position: fixed;margin-top: 13mm;margin-left: 70mm;">
            <p style="max-width:170mm;font-size:20px">
                <h6>
                    <b style="font-size:6mm">PURCHASE ORDER</b>
                </h6>
            </p>
        </div>
        <div style="position: fixed;margin-top: 19mm;margin-left: 160mm;">
            <p style="max-width:120mm;">
                PO NO &nbsp;&nbsp;&nbsp;: {{ $po->PO_NUMBER }}<br>
                Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ date('d.m.Y') }} <br>
                Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ '0000' }} <br>
            </p>
            <p></p>
            <br>
            <p style="max-width:120mm;">
                Shipped T0: <br>
                Herlina Indah <br>
                Jl. Rawa Sumur II Blok DD.16 <br>
                Pulo Gadung Industri Estate, Jakarta <br>
            </p>
        </div>
        <div style="position: fixed;margin-top: 34mm;margin-left: 10mm;width: 50mm;overflow: hidden;height: 14mm;">
             <p class="" style="width: 200mm;margint-left:40mm;">
                <span style="">TO : </span> 
                    &nbsp;&nbsp;&nbsp;{{ $po->vendors['name'] }} <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $po->vendors['street'] }} <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telp. {{ $po->vendors['office_telephone'] }} <br/>
                </span>
            </p>
        </div> 
        <div style="position: fixed;margin-top: 44mm;margin-left: 68mm;width: 54mm;height: 4mm;overflow: hidden;">
        </div> 
        

        <!-- tanda tangan -->
        <div style="position: fixed;margin-top: 180mm; margin-left: 87mm;">
            <div style="position: relative;margin-left: 0mm;background:none;float: left;">
                <p style="text-align: center;width: 100%;">
                    <div id="content">
                        <div id="pageFooter">Page </div>
                    </div>
                </p>
            </div>
        </div>

        <!-- tampung data ke variabel biar gampang -->
        <!-- fix ok -->
        <div style="position: fixed;margin-top: 60mm; margin-left: 4mm;width: 190mm;">
            <div class="list-product">
                <table border="2" width="100%" class="table">
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
                        @endphp
                        @foreach($po->orderDetail as $key => $value)
                            @php
                                $total += $value->price;
                            @endphp
                        <tr>
                            <td>{{ $value->key + 1 }}</td>
                            <td>{{ $value->material_id ?? '' }}</td>
                            <td>{{ $value->short_text }}</td>
                            <td>{{ $value->description }}</td>
                            <td>{{ $value->delivery_date }}</td>
                            <td>{{ $value->qty." - ".$value->unit }}</td>
                            <td>{{ $value->PR_NO }}</td>
                            <td>{{ $value->price }}</td>
                            <td>{{ $value->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td rowspan="4" colspan="5">
                                <p class="" style="text-align:left;">
                                    Amount <br>
                                    <br>
                                    {{ ucfirst(Terbilang::make($total)) }}
                                    <br>
                                    <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:left;">Total</td>
                            <td colspan="3">{{ number_format($total,2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:left;">Tax</td>
                            <td colspan="3">10</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:left;">Grand Total</td>
                            <td colspan="3">{{ number_format($total,2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p class="" style="height: 4mm;width: mm;text-align:left;">
                                Term of payment
                                    : {{ $po->paymentTerm['no_of_days'] }}
                                </p>
                            </td>
                            <td colspan="4" style="text-align:left;">{{ $po->notes }}</td>
                        </tr>
                        <tr>
                            <td rowspan="" colspan="2">
                                Supplier *) <br>
                                <br>
                                <br>
                                <br>
                                <p style="height: 10mm;width: mm;text-align:center;">
                                    (................)
                                </p>
                            </td>
                            <td rowspan="" colspan="3">
                                Approve By *) <br>
                                <br>
                                <p>{{ date('d.m.y H:i:s',strtotime($po->updated_at)) }}</p>
                                <p style="height: 10mm;width: mm;text-align:center;">
                                    This document has been electronically approved. <br>
                                    Signature is no longer required
                                </p>
                                <br>
                            </td>
                            <td colspan="5" style="text-align:left;">
                                <p style="margin-top:3mm;">
                                    Notes : <br>
                                        1. Invoicing will be done on Tuesday 09.00am - 5.00pm <br>
                                        2. Delivery not on schedule, will be refused <br>
                                        3. Please bring along print out purchase order when invoicing <br>
                                </p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script>
       window.print()
    </script>
</body>
</html>
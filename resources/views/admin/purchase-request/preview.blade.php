<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PRINT GI</title>
    <style>
        @page {
            size:  auto;
            margin: 0mm;
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
            border-top: 0.5mm solid black;
            border-bottom: 0.5mm solid black;
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
    </style>
</head>
<body onload="onbeforeunload()">
    <div class="page">
        <div style="position: fixed;margin-top: 4mm;margin-left: 15mm;">
            <h2>
                <img src="{{ asset('index.jpg') }}" style="margin-left:5mm" height=80><br>
                <b>PT HERLINA INDAH</b>
            </h2>
        </div>
        <div style="position: fixed;margin-top: 13mm;margin-left: 70mm;">
            <p style="max-width:170mm;font-size:20px">
                <h6>
                    <b style="font-size:6mm">RECEIVE NOTE</b>
                </h6>
            </p>
        </div>
        <div style="position: fixed;margin-top: 7mm;margin-left: 165mm;">
            <p style="max-width:90mm;">
                <hr>
                    <b>NO: </b><br>
                    <b>Date: {{ date('Y-m-d') }} </b><br>
                <hr>
            </p>
        </div>
        {{-- <div style="position: fixed;margin-top: 34mm;margin-left: 4mm;width: 75mm;overflow: hidden;height: 14mm;">
             <p class="title" style="height: 4mm;width: 75mm;overflow: hidden;">
                <span style="width: 25mm;display: inline-block;">No. PO</span> <span>:</span>
            </p>
            <p class="title" style="height: 4mm;width: 75mm;overflow: hidden;">
                <span style="width: 25mm;display: inline-block;">No Faktur</span> <span>:</span>
            </p>
            <p class="title" style="height: 4mm;width: 75mm;overflow: hidden;">
                <span style="width: 25mm;display: inline-block;">Jatuh Tempo</span> <span>: </span>
            </p>
        </div> 
         <div style="position: fixed;margin-top: 44mm;margin-left: 68mm;width: 54mm;height: 4mm;overflow: hidden;">
        </div>  --}}
        

        <!-- tanda tangan -->
        <div style="position: fixed;margin-top: 120mm; margin-left: 103mm;">
            <div style="position: relative;margin-left: 0mm;background:none;float: left;">
                <p style="text-align: center;width: 100%;">
                    Total Goods Received, &nbsp;&nbsp;&nbsp;&nbsp;2
                </p>
                <p style="height: 11mm;">
                </p>
            </div>
        </div>

        <!-- tampung data ke variabel biar gampang -->
        <!-- fix ok -->
        <div style="position: fixed;margin-top: 50mm; margin-left: 4mm;width: 190mm;">
            <div class="list-product">
                <table border="1" width="100%" class="table">
                    <tr>
                        <td><b>No</b></td>
                        <td><b>Req Dept.</b></td>
                        <td><b>Item Code </b></td>
                        <td><b>Description </b></td>
                        <td><b>Units </b></td>
                        <td><b>Qty PO </b></td>
                        <td><b>Qty Supply </b></td>
                        <td><b>Qty Received </b></td>
                        <td><b>Qty Outstanding </b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script>
        window.print()
    </script>
</body>
</html>
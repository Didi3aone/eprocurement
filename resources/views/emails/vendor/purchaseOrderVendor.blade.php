<!DOCTYPE html>
<html>
<head>
	<title>TITLE</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="margin: 20px 0; padding: 20px; background: #f2f2f2; font-family: Arial;">

<table style="width: 85%; height: auto; margin: 20px auto !important; background: #fff; border-spacing: 0; border: 0;">
	<tr>
		<td colspan="2" style="padding: 10px; line-height: 1.5; background: #196A39; text-align: center; color: #fff; border-bottom: 3px solid #ddd;">
			<h1 style="font-size: 20px; margin: 0;">Purchase Order</h1>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="padding: 10px; line-height: 1.5;">

			<h3 style="font-size: 14px; margin: 0;">Dear,
			</h3>

            <p style="font-size: 13px;">
               Below is the purchase order information
			</p>
			<p style="font-size: 13px;">
                Po Number : {{ $po->PO_NUMBER }} <br>
			</p>

			<div style="border-top: 1px dashed #ddd; border-bottom:1px dashed #ddd">
				
			</div>
            <p style="font-size: 13px;">
                Click this link for more info <a href='https://eprocurement.enesis.com/vendor/login'>link</a>
            </p>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding: 10px; line-height: 1.5; font-size: 12px; background:#196A39; text-align: center; color:#fff;">
			Copyright 2020.
		</td>
	</tr>
</table>

</body>
</html>
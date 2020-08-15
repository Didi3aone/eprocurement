<!DOCTYPE html>
<html>
<head>
	<title>Billing</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="margin: 20px 0; padding: 20px; background: #f2f2f2; font-family: Arial;">

<table style="width: 85%; height: auto; margin: 20px auto !important; background: #fff; border-spacing: 0; border: 0;">
	<tr>
		<td colspan="2" style="padding: 10px; line-height: 1.5; background: #196A39; text-align: center; color: #fff; border-bottom: 3px solid #ddd;">
			<h1 style="font-size: 20px; margin: 0;">Billing</h1>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="padding: 10px; line-height: 1.5;">

			<h3 style="font-size: 14px; margin: 0;">Dear {{ $name }}</h3>

			<div style="border-top: 1px dashed #ddd; border-bottom:1px dashed #ddd">
                <p style="font-size: 13px;">
                Your input billing id ( {{ $billing->billing_no }} ) approved 
                </p>
                <p style="font-size: 13px;">
                please send hardcopy to Enesis 
                </p>
                <p style="font-size: 13px;">
                and dont forget print billing id and attach in your hardcopy for process next step 
                </p>
            </div>
            <p style="font-size: 13px;">
                thanks,

                {{-- Untuk info detail <a href='https://employee.enesis.com'>link</a> --}}
            </p>
		</td>
	</tr>
	<tr>
		<!-- <td style="width: 55%;padding: 10px; line-height: 1.5; font-size: 12px; border-top: 1px solid #ddd; border-right: 1px dashed #ddd;">
		<b>
			<img src="https://www.tiketux.com/images/email/v2/phone.png" alt="email" style="position: relative; top: 3px; margin-left: 5px;"> 0812-3456-789
			<img src="https://www.tiketux.com/images/email/v2/mail.png" alt="phone" style="position: relative; top: 3px; margin-left: 5px;"> info@email.com
		</b>
		</td> -->
	</tr>
	<tr>
		<td colspan="2" style="padding: 10px; line-height: 1.5; font-size: 12px; background:#196A39; text-align: center; color:#fff;">
			Copyright 2020.
		</td>
	</tr>
</table>

</body>
</html>
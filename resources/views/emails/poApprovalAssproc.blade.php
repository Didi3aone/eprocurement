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

			<h3 style="font-size: 14px; margin: 0;">Dear {{ $name }}
			</h3>

            <p style="font-size: 13px;">
                Berikut ini adalah informasi purchase order membutuhkan approval anda
			</p>
			<p style="font-size: 13px;">
                No Doc  : {{  $quotation->po_no }} <br>
                Terms of payment : {{  $quotation->getTerm['own_explanation'] ?? ''}} <br>
				Terms of payment Desc : {{ $quotation->notes ?? '' }}
			</p>

			<div style="border-top: 1px dashed #ddd; border-bottom:1px dashed #ddd">
				<table style="width: 100%; background:#f2f2f2;" border=1>
					<thead>
					<tr>
						<th style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								No 	
							</div>
						</th>
						<th style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								Item 	
							</div>
						</th>
                        <th style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								Qty 	
							</div>
						</th>
						<th style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								Unit 	
							</div>
						</th>
                        <th style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								Price 	
							</div>
						</th>
					</tr>
					</thead>
					<tbody>
					@foreach($quotation->detail as $key => $value)
					<tr>
						<td style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								{{ $key + 1 }} 	
							</div>
						</td>
						<td style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								{{ $value->material_id." - ".$value->description }} 	
							</div>
						</td>
                        <td style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								{{ $value->qty }} 	
							</div>
						</td>
						<td style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								{{ $value->unit }} 	
							</div>
						</td>
                        <td style="font-size: 13px; padding: 25px; line-height: 1.5; border-right:1px dashed #ddd; border-left:1px dashed #ddd">
                            <div>
								{{ $value->price }} 	
							</div>
						</td>
					</tr>
					@endforeach
					</tbody>
				</table>
			</div>
            <p style="font-size: 13px;">
                Untuk info detail <a href='https://employee.enesis.com'>link</a>
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
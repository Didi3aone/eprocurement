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
			<h1 style="font-size: 20px; margin: 0;">Purchase Request</h1>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="padding: 10px; line-height: 1.5;">

			<h3 style="font-size: 14px; margin: 0;">Dear {{ $name }}
			</h3>

            <p style="font-size: 13px;">
                Berikut ini adalah informasi purchase requesition telah disetujui
			</p>
			<p style="font-size: 13px;">
                Po Number : {{ $po->PO_NUMBER }} <br>
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
					</tr>
					</thead>
					<tbody>
					{{-- @foreach($pr->purchaseDetail as $key => $value) --}}
					{{-- <tr>
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
					</tr> --}}
					{{-- @endforeach --}}
					</tbody>
				</table>
			</div>
            <p style="font-size: 13px;">
                {{-- Untuk info detail <a href='https://employee.enesis.com'>link</a> --}}
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
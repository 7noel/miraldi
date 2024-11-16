<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PICKING: {{ $model->id }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	<!-- <link rel="stylesheet" href="./css/order_pdf.css"> -->
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&family=Roboto:wght@100&display=swap');
		@page {
			margin: 0 30px;
			font-family: 'Roboto Condensed', sans-serif;
		}
		body{
			font-size: 12px;
		}
		.header{
/*			font-family: 'Roboto', sans-serif;*/
		}
		.center{
			text-align: center;
		}
		.border{
			border: solid 1px black;
		}
	</style>
</head>
<body>
	<script type="text/php">
	if ( isset($pdf) ) {
		$pdf->page_script('
			$font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
			$pdf->text(270, 810, "Página $PAGE_NUM de $PAGE_COUNT", $font, 8);
		');
	}
	</script>
	<div class="header">
		<div>
			<div class="center">
				<h3 class="center" style="margin: 0;">
					PICKING: {{ $model->id }}<br><span style="font-size: 12px;">IMPORTACIONES MIRALDI S.A.C.</span>
				</h3>
			</div>
		</div>
	</div>
	<div>

		@php
			$_code = $model->CFNUMPED.'|';
			$details = json_decode($model->details);
		@endphp
		@foreach($details as $key => $detail)
			@php
				$_code = $_code."$detail->codigo $detail->quantity|";
			@endphp
		@endforeach
		@php $_code = substr($_code, 0, -1) @endphp

		<div>
			<div>
				<strong>Pedido: </strong><span>{{ $model->CFNUMPED }}</span>
			</div>
			<div>
				<strong>Fecha y Hora: </strong><span>{{ $model->created_at->format('d/m/Y h:i a') }}</span>
			</div>
			<div>
				<strong>Cliente: </strong><span>{{ $model->order->CFNOMBRE }}</span>
			</div>
			<div>
				<strong>Usuario: </strong><span>{{ $model->user->name }}</span>
			</div>
			<div>
				<strong>Items: </strong><span>{{ $model->items }}</span>
			</div>
			<div>
				<strong>PL: </strong><span>{{ $model->pl }}</span>
			</div>
			<div>
				<strong>ES: </strong><span>{{ $model->es }}</span>
			</div>
		</div>
		<br>
		<div class="center">
				<img src="data:image/png;base64, {!! base64_encode(QrCode::size(150)->generate($_code)) !!} ">
		</div>
	</div>
	<br>

	{{--<div class="container-items">
		<table class="table-items">
			<thead>
				<tr>
					<th class="th1 border center">ITEM</th>
					<th class="th1 border center">CORREC.</th>
					<th class="th3 border center">UND</th>
					<th class="th2 border center">DESCRIPCIÓN</th>
					<th class="th4 border center">BULTO</th>
				</tr>
			</thead>
			<tbody>
				@foreach($details as $key => $detail)
					<tr>
						<td class="border center">{{ $key + 1 }}</td>
						<td class="border center"></td>
						<td class="border center">{{ number_format($detail->DFCANTID, 2, '.', '').' '.$detail->DFUNIDAD }}</td>
						<td class="border">{{ $detail->DFDESCRI }}</td>
						<td class="border center"></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>--}}
</body>
</html>
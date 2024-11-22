<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PEDIDO: {{ $model->CFNUMPED }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="./css/order_pdf.css">
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
				<h2 class="center">
					ORDEN DE PEDIDO: {{ $model->CFNUMPED }} <span style="margin-left: 50px; font-size: 14px;">IMPORTACIONES MIRALDI S.A.C.</span>
				</h2>
			</div>
		</div>
	</div>
	<div>
		<div style="width:78%; display: inline-block; float: left;">
			<div>
				<strong class="label_2">{{ config('options.client_doc.'.$model->company->CTIPO_DOCUMENTO) }}:</strong><span class="data-header">{{ $model->company->CCODCLI }}</span>
			</div>
			<div>
				<strong class="label_2">Usuario:</strong><span class="data-header">Usuariox {{ date('d/m/Y h:i a') }}</span>
			</div>
			<div>
				<strong class="label_2">Señor(a):</strong><strong class="data-header" style="width: 68%">{{ $model->CFNOMBRE }}</strong>
			</div>
			<div>
				<strong class="label_2">Dirección:</strong><span class="data-header" style="width: 68%">{{ $model->company->CDIRCLI }}</span>
			</div>
			<div>
				<strong class="label_2">Lugar:</strong><strong class="data-header" style="width: 68%">{{ $model->company->ubigeo->distrito . ' - ' . $model->company->ubigeo->provincia . ' - ' . $model->company->ubigeo->departamento }}</strong>
			</div>
			<div>
				<strong class="label_2">Condiciones:</strong><span class="data-header">{{ $model->condition->DES_FP }}</span>
			</div>
			<div>
				<strong class="label_2">Vendedor:</strong><span class="data-header">{{ $model->seller->DES_VEN }}</span>
			</div>
			@if(isset($model->shipper->TRANOMBRE))
			<div>
				<strong class="label_2">Agencia:</strong><span class="data-header">{{$model->shipper->TRANOMBRE}}</span>
			</div>
			@endif
			<div>
				<strong class="label_2">Observaciones</strong><strong class="data-header" style="width: 68%">{{ $model->CFGLOSA }}</strong>
			</div>
		</div>
		<div style="width:20%; display: inline-block;">
			@php $_code=round($model->CFNUMPED).'|' @endphp
			@foreach($model->details as $key => $detail)
				@php
					$_code = $_code.$detail->DFCODIGO." ".round($detail->DFCANTID)."|";
				@endphp
			@endforeach
			@php $_code = substr($_code, 0, -1) @endphp
				<img src="data:image/png;base64, {!! base64_encode(QrCode::size(150)->generate($_code)) !!} ">
		</div>
	</div>
	<br><br><br>
	<div class="container-items">
		<table class="table-items">
			<thead>
				<tr>
					<th class="border center">#</th>
					<th class="border center">CORREC.</th>
					<th class="border center">CANT.</th>
					<th class="border center">UBI.</th>
					<th class="border center">DESCRIPCIÓN</th>
					<th class="border center">BULTO</th>
				</tr>
			</thead>
			<tbody>
				@php
					$i = 0;
					$model->details->load(['product.lockers']);
				@endphp
				@foreach($model->details->sortBy('DFCODIGO') as $key => $detail)
					<?php $ubicacion = (isset($detail->product->lockers[0])) ? $detail->product->lockers[0]->TCASILLERO : '' ; ?>
					<tr>
						<td class="border center">{{ ++$i }}</td>
						<td class="border center"></td>
						<td class="border center">{{ number_format($detail->DFCANTID, 2, '.', '').' '.$detail->DFUNIDAD }}</td>
						<td class="border center">{{ $ubicacion }}</td>
						<td class="border" style="padding: 4px 0;">{{ $detail->DFCODIGO }} {{ $detail->DFDESCRI }}</td>
						<td class="border center"></td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<br>
		<br>
		<br>
		<br>
		<table class="table-total">
			<tbody>
				<tr>
					<td class="center">________________________</td>
					<td class="center">________________________</td>
					<td class="center">________________________</td>
				</tr>
				<tr>
					<td class="center">EMBALADO POR:</td>
					<td class="center">VERIFICADO POR:</td>
					<td class="center">V° B° ALMACEN:</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
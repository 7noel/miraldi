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
				<strong class="label_2">Señor(a):</strong><span class="data-header" style="width: 68%">{{ $model->CFNOMBRE }}</span>
			</div>
			<div>
				<strong class="label_2">Dirección:</strong><span class="data-header" style="width: 68%">{{ $model->company->CDIRCLI . '-' . $model->company->CPROV . '-' . $model->company->CDEPT }}</span>
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
				<strong class="label_2">Observaciones</strong><span class="data-header" style="width: 68%">{{ $model->CFGLOSA }}</span>
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
	<br>
	<div class="container-items">
		<table class="table-items">
			<thead>
				<tr>
					<th class="th1 border center">ITEM</th>
					<th class="th1 border center">CORREC.</th>
					<th class="th3 border center">CANT.</th>
					<th class="th2 border center">DESCRIPCIÓN</th>
					<th class="th4 border center">BULTO</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 0 @endphp
				@foreach($model->details->sortBy('DFCODIGO') as $key => $detail)
					<tr>
						<td class="border center">{{ ++$i }}</td>
						<td class="border center"></td>
						<td class="border center">{{ number_format($detail->DFCANTID, 2, '.', '').' '.$detail->DFUNIDAD }}</td>
						<td class="border">{{ $detail->DFCODIGO }} {{ $detail->DFDESCRI }}</td>
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
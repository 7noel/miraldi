<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PEDIDO ORIGINAL: {{ $model->CFNUMPED }}</title>
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
					PEDIDO ORIGINAL: {{ $model->CFNUMPED }} <span style="margin-left: 50px; font-size: 14px;">IMPORTACIONES MIRALDI S.A.C.</span>
				</h2>
			</div>
		</div>
	</div>
	<div>
		<div>
			<strong class="label">{{ config('options.client_doc.'.$model->company->CTIPO_DOCUMENTO) }}:</strong><span class="data-header-1">{{ $model->company->CCODCLI }}</span>
			<strong class="label-2">Usuario:</strong><span class="data-header">{{ $model->original->content->CFUSER }} {{ $model->original->updated_at->format('d/m/Y h:i a') }}</span>
		</div>
		<div>
			<strong class="label">Señor(a):</strong><span class="data-header">{{ $model->CFNOMBRE }}</span>
		</div>
		<div>
			<strong class="label">Dirección:</strong><span class="data-header">{{ $model->company->CDIRCLI . '-' . $model->company->CPROV . '-' . $model->company->CDEPT }}</span>
		</div>
		<div>
			<strong class="label">Condiciones:</strong><span class="data-header-1">{{ $model->condition->DES_FP }}</span>
		</div>
		<div>
			<strong class="label">Vendedor:</strong><span class="data-header-1">{{ $model->seller->DES_VEN }}</span>
			@if(isset($model->shipper->TRANOMBRE))
			<strong class="label-2">Agencia:</strong><span class="data-header">{{$model->shipper->TRANOMBRE}}</span>
			@endif
		</div>
		<div>
			<strong class="label">Observaciones:</strong><span class="data-header">{{ $model->CFGLOSA }}</span>
		</div>
	</div>
	<br>
	<div class="container-items">
		<table class="table-items">
			<thead>
				<tr>
					<th class="th1 border center">ITEM</th>
					<th class="th2 border center">DESCRIPCIÓN</th>
					<th class="th3 border center">CANT.</th>
					<th class="th4 border center">P. UNIT.</th>
					<th class="th5 border center">DSCT.</th>
					<th class="th6 border center">TOTAL</th>
				</tr>
			</thead>
			<tbody>
				@php $_code=$model->CFNUMPED.'|' @endphp
				@php $i = 0 @endphp
				@foreach(collect($model->original->content->details)->sortBy('DFCODIGO') as $key => $detail)
					@php
						$_code = $_code."$detail->DFCODIGO $detail->DFCANTID|";
					@endphp
					<tr>
						<td class="border center">{{ ++$i }}</td>
						<td class="border">{{ $detail->DFCODIGO }} {{ $detail->DFDESCRI }}</td>
						<td class="border center">{{ number_format($detail->DFCANTID, 2, '.', '').' '.$detail->DFUNIDAD }}</td>
						<td class="border center">{{ number_format($detail->DFPREC_ORI, 2, '.', '') }}</td>
						<td class="border center">{{ intval($model->original->content->CFPORDESCL) }}% {{ intval($detail->DFPORDES) }}%</td>
						@if($model->original->content->CFCODMON)
						<td class="border center">{{ number_format($detail->DFIMPMN, 2, '.', '') }}</td>
						@else
						<td class="border center">{{ number_format($detail->DFIMPUS, 2, '.', '') }}</td>
						@endif
					</tr>
				@endforeach
				@php $_code = substr($_code, 0, -1) @endphp
			</tbody>
		</table>
		<br>
		<table class="table-total">
			<tbody>
				<tr>
					<td class="left">SUB TOTAL {{ config('options.table_sunat.moneda_symbol.'.$model->original->content->CFCODMON)." ".number_format(($model->original->content->CFIMPORTE - $model->original->content->CFIGV), 2, '.', '') }}</td>
					<td class="left">IGV (18%) {{ config('options.table_sunat.moneda_symbol.'.$model->original->content->CFCODMON)." ".number_format($model->original->content->CFIGV, 2, '.', '') }}</td>
					<td class="left">TOTAL {{ config('options.table_sunat.moneda_symbol.'.$model->original->content->CFCODMON)." ".number_format($model->original->content->CFIMPORTE, 2, '.', '') }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
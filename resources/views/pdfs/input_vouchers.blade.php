<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/jpeg" href="./img/logo_makim_01.jpg" />

	<title>Comprobante: {{ $model->sn }}</title>
	<link rel="stylesheet" href="./css/voucher_pdf.css">
</head>
<body>
	<script type="text/php">
	if ( isset($pdf) ) {
		$pdf->page_script('
			$font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
			$pdf->text(520, 810, "Página $PAGE_NUM de $PAGE_COUNT", $font, 8);
		');
	}
	</script>
	<table>
		<tr class="header">
			<td class="col_1">
				<div>
					<img src="./img/logo_makim_doc.jpg" alt="" class="img">
				</div>
				<div>
					<div class="company_name">{{ $model->mycompany->company_name }}</div>
				</div>
			</td>
			<td class="col_2 center">
					RUC: {{ $model->mycompany->doc }}<br>
					{{ $model->document_type->description }} {{ ($model->document_type_id == 7) ? '' : 'ELECTRÓNICA'}}<br>
					{{ $model->series.' - '.str_pad($model->number, 6, '0', STR_PAD_LEFT) }}
			</td>
		</tr>
	</table>
	<div class="datos_emisor">
		<div>{{ $model->mycompany->address}}</div>
		<div>{{ $model->mycompany->ubigeo->departamento.' - '.$model->mycompany->ubigeo->provincia.' - '.$model->mycompany->ubigeo->distrito }}</div>
	</div>
	<div class="data_doc border">
		<table class="">
			<tr>
				<td width="102px">Cliente:</td>
				<td width="350px">{{ $model->company->company_name }}</td>
				<td class="border" width="130px">Fecha de emisión:</td>
				<td class="border center" width="102px">{{ date('d/m/Y', strtotime($model->issued_at)) }}</td>
			</tr>
			<tr>
				<td>{{ config('options.client_doc.'.$model->company->id_type) }}:</td>
				<td>{{ $model->company->doc }}</td>
				<td class="border">Fecha de vencimiento:</td>
				<td class="border center">{{ date('d/m/Y', strtotime($model->expired_at)) }}</td>
			</tr>
			<tr>
				<td>Dirección:</td>
				<td colspan="3">{{ $model->company->address . ', ' . $model->company->ubigeo->departamento . '-' . $model->company->ubigeo->provincia . '-' . $model->company->ubigeo->distrito }}</td>
			</tr>
			<tr>
				<td>Condición de Pago:</td>
				<td>{{ config('options.payment_conditions.'.$model->payment_condition_id) }}</td>
			</tr>
		</table>
	</div>
	<div class="container-items">
		<table class="table-items">
			<thead>
				<tr>
					<th class="th1 border center" width="60px">ITEM</th>
					<th class="th2 border center">DESCRIPCION</th>
					<th class="th3 border center" width="70px">CANT.</th>
					<th class="th4 border center" width="70px">P. UNIT.</th>
					<th class="th5 border center" width="70px">TOTAL</th>
				</tr>
			</thead>
			<tbody>
				@php $cat=0 @endphp
				@foreach($model->details as $key => $detail)
				@if($detail->category_id != $cat)
					<tr><td class="border padding" colspan="5">{{ $detail->category->name }}</td></tr>
					@php $cat = $detail->category_id @endphp
				@endif
				<tr>
					<td class="border center">{{ $key + 1 }}</td>
					<td class="border">{{ $detail->product->name }}</td>
					<td class="border center">{{ $detail->quantity.' '.$detail->unit->symbol }}</td>
					<td class="border center">{{ $detail->price }}</td>
					<td class="border center">{{ $detail->price_item }}</td>
				</tr>
				@endforeach
			</tbody> 
		</table>
		@if(trim($model->comment)!="")
		<div>
			<strong class="label">Comentario:</strong><span class="data-header">{{$model->comment}}</span>
		</div>
		@endif

		<br>
		<table class="table-total">
		</table>
	</div>

	<div class="data_extra">
		<table>
			<tr>
				<td width="482px" class="">
					<div>Son: <strong>{{ numero_letras($model->total, 2, $model->currency_id) }}</strong></div>
				</td>
				<td width="217px" class="">
					<table class="totales">
						<tr>
							<td width="115px" class="">
								<div>OP. GRAVADAS :</div>
							</td>
							<td width="102px" class="">
								<div>{{ config('options.table_sunat.moneda_symbol.'.$model->currency_id)." ".$model->subtotal }}</div>
							</td>
						</tr>
						<tr>
							<td class="">
								<div>IGV 18% :</div>
							</td>
							<td class="">
								<div>{{ config('options.table_sunat.moneda_symbol.'.$model->currency_id)." ".$model->tax }}</div>
							</td>
						</tr>
						<tr class="">
							<td class="">
								<div>TOTAL A PAGAR :</div>
							</td>
							<td class="">
								<div>{{ config('options.table_sunat.moneda_symbol.'.$model->currency_id)." ".$model->total }}</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>



	<footer>
		<div><strong>Cuentas: </strong></div>
		@foreach($cuentas as $cta)
			<div>
				<strong>{{ config('options.tipo_banco.'.$cta->type) }}</strong>
				{{ $cta->name }} - N° {{ $cta->number }} - 
				<strong>CCI N°</strong>
				{{ $cta->cci }} - {{ config('options.table_sunat.moneda.'.$cta->currency_id) }}
			</div>
		@endforeach
	</footer>
</body>
</html>
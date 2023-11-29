<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cotización: {{ $model->sn }}-{{ $model->created_at->formatLocalized('%Y') }}</title>
	<link rel="stylesheet" href="./css/order_pdf.css">
</head>
<body>
	<div class="header">
		<div class="title">COTIZACIÓN: {{ str_pad($model->sn, 3, '0', STR_PAD_LEFT) }} - {{ $model->created_at->formatLocalized('%Y') }}</div>
		<div class="">{{ $model->mycompany->company_name }}</div>
		<div class="">{{ 'RUC: '.$model->mycompany->doc }}</div>
	</div>

	<div>
		<div>
			<strong class="label">Señor(a):</strong>{{ $model->company->company_name }}
		</div>
		<div>
			<strong class="label">{{ config('options.client_doc.'.$model->company->id_type) }}:</strong>{{ $model->company->doc }}
		</div>
		<div>
			<strong class="label">Dirección:</strong>{{ $model->company->address . ' ' . $model->company->ubigeo->departamento . '-' . $model->company->ubigeo->provincia . '-' . $model->company->ubigeo->distrito }}
		</div>
		<div>
			<strong class="label">Condiciones:</strong>{{ config('options.payment_conditions.'.$model->payment_condition_id) }}
		</div>
		<div>
			<strong class="label">Vendedor:</strong>{{ str_pad($model->seller_id, 3, '0', STR_PAD_LEFT).' '.$model->seller->company_name }}
		</div>
		@if(trim($model->comment)!="")
		<div>
			<strong class="label">Comentario:</strong>{{$model->comment}}
		</div>
		@endif
	</div>
	<br>
	<div class="container-items">
		<table class="table-items">
			<thead>
				<tr>
					<th class="th1 border center">ITEM</th>
					<th class="th2 border center">DESCRIPCION DEL PRODUCTO</th>
					<th class="th3 border center">UND</th>
					<th class="th4 border center">V. UNIT.</th>
					<th class="th5 border center">V. TOTAL</th>
				</tr>
			</thead>
			<tbody>
				@foreach($model->details as $key => $detail)
				<tr>
					<td class="border center">{{ $key + 1 }}</td>
					<td class="border">{{ $detail->product->intern_code.' '.$detail->product->name }}</td>
					<td class="border center">{{ $detail->quantity.' '.$detail->product->unit->symbol }}</td>
					<td class="border center">{{ $detail->value }}</td>
					<td class="border center">{{ $detail->total }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<br>
		<table class="table-total">
			<tbody>
				<tr>
					<td class="th1"></td>
					<td class="th2"></td>
					<td class="th3"></td>
					<th class="th4 border right">SubTot.:</th>
					<td class="th5 border right">{{ $model->subtotal }}</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<th class="border right">IGV:</th>
					<td class="border right">{{ $model->tax }}</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<th class="border right">Total:</th>
					<th class="border right">{{ $model->total }}</th>
				</tr>
			</tbody>
		</table>

	</div>
</body>
</html>
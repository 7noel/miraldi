<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pedido: {{ $model->id }}-{{ $model->created_at->formatLocalized('%Y') }}</title>
	<link rel="stylesheet" href="./css/order_pdf.css">
</head>
<body>
	<h1 class="center">ORDEN DE PEDIDO: {{ str_pad($model->id, 3, '0', STR_PAD_LEFT) }} - {{ $model->created_at->formatLocalized('%Y') }}</h1>
	<div>
		<div>
			<strong class="label">Señor(a):</strong>{{ $model->company->company_name }}
		</div>
		<div>
			<strong class="label">RUC:</strong>{{ $model->company->doc }}
		</div>
		<div>
			<strong class="label">Dirección:</strong>{{ $model->company->address . ' ' . $model->company->ubigeo->departamento . '-' . $model->company->ubigeo->provincia . '-' . $model->company->ubigeo->distrito }}
		</div>
		<div>
			<strong class="label">Condiciones:</strong>{{ $model->payment_condition->name }}
		</div>
		<div>
			<strong class="label">Vendedor:</strong>{{ $model->seller_id.' '.$model->seller->full_name }}
		</div>
		@if(trim($model->comment)!="")
		<div>
			<strong class="label">Comentario:</strong>{{$model->comment}}
		</div>
		@endif
	</div>
	<div class="container-items">
		<table class="table-items">
			<thead>
				<tr>
					<th class="th1 border center">ITEM</th>
					<th class="th2 border center">DESCRIPCION DEL PRODUCTO</th>
					<th class="th3 border center">UND</th>
					<th class="th4 border center">P. UNIT.</th>
					<th class="th5 border center">TOTAL</th>
				</tr>
			</thead>
			<tbody>
				@foreach($model->details as $key => $detail)
				<tr>
					<td class="border center">{{ $key + 1 }}</td>
					<td class="border">{{ $detail->product->intern_code.' '.$detail->product->name }}</td>
					<td class="border center">{{ $detail->quantity.' '.$detail->unit->symbol }}</td>
					<td class="border center">{{ $detail->value }}</td>
					<td class="border center">{{ $detail->total }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<table class="table-total">
			<tbody>
				<tr>
					<td class="th1"></td>
					<td class="th2"></td>
					<td class="th3"></td>
					<td class="th4 border right">SubTot.:</td>
					<td class="th5 border center">{{ $model->subtotal }}</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td class="border right">IGV:</td>
					<td class="border center">{{ $model->tax }}</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td class="border right">Total:</td>
					<td class="border center">{{ $model->total }}</td>
				</tr>
			</tbody>
		</table>

	</div>
</body>
</html>
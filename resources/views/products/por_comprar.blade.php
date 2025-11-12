@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}"> Productos Pendientes por Comprar
				</h5>
				<div class="card-body">
					<p>Muestra los productos que no tengan stock suficiente para atender los pedidos de los últimos 15 días que están en estado 'AUTORIZADO'.</p>
					{{-- 🔹 Leyenda de colores --}}
					<div class="mb-3">
						<span class="badge badge-danger p-2">&nbsp;&nbsp;</span> <small class="mr-3">Sin stock (en ambos almacenes)</small>
						<span class="badge badge-warning p-2">&nbsp;&nbsp;</span> <small>Por trasladar (stock disponible en almacén de Punta Hermosa)</small>
					</div>
					<table class="table table-sm table-hover">
						<thead class="">
							<tr>
								<th>Codigo</th>
								<th>Descripción</th>
								<th>Und</th>
								<th>Stock SJM</th>
								<th>Stock PH</th>
								<th>Demanda</th>
								<th>PorComprar</th>
								<th>Ordenes</th>
							</tr>
						</thead>
						<tbody style="font-size: 14px;">
							@foreach($models as $model)
								@php
								    $clase = '';
								    if ($model->stock_01 == 0 && $model->stock_03 == 0) {
								        $clase = 'table-danger'; // 🔴 comprar urgente
								    } elseif ($model->stock_01 < $model->total_cantidad && $model->stock_03 > 0) {
								        $clase = 'table-warning'; // 🟡 trasladar desde 03
								    }
								@endphp
							<tr class="{{ $clase }}">
								<td>{{ $model->ACODIGO }}</td>
								<td style="white-space: nowrap;">{{ $model->ADESCRI }}</td>
								<td>{{ $model->AUNIDAD }}</td>
								<td class="text-right">{{ number_format($model->stock_01, 2) }}</td>
								<td class="text-right">{{ number_format($model->stock_03, 2) }}</td>
								<td class="text-right">{{ number_format($model->total_cantidad,2) }}</td>
								<td class="text-right">{{ number_format($model->diferencia,2) }}</td>
								<td>{{ $model->numeros_pedidos }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


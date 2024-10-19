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
					<table class="table table-sm table-hover">
						<thead class="">
							<tr>
								<th>Codigo</th>
								<th>Descripción</th>
								<th>Und</th>
								<th>Stock</th>
								<th>Demanda</th>
								<th>PorComprar</th>
								<th>Ordenes</th>
							</tr>
						</thead>
						<tbody style="font-size: 14px;">
							@foreach($models as $model)
							<tr>
								<td>{{ $model->ACODIGO }}</td>
								<td style="white-space: nowrap;">{{ $model->ADESCRI }}</td>
								<td>{{ $model->AUNIDAD }}</td>
								<td>{{ number_format($model->STSKDIS,2) }}</td>
								<td>{{ number_format($model->total_cantidad,2) }}</td>
								<td>{{ number_format($model->diferencia,2) }}</td>
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


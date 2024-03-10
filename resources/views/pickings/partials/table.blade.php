<table class="{{ config('options.styles.table') }}">
	<thead class="{{ config('options.styles.thead') }}">
		<tr>
			<th>#</th>
			<th>Pedido</th>
			<th>Cliente</th>
			<th>Creación</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($models as $model)
		<tr data-id="{{ $model->id }}">
			<td>{{ $model->id }}</td>
			<td>{{ $model->CFNUMPED }}</td>
			<td>{{ $model->order->CFNOMBRE }}</td>
			<td>{{ $model->created_at->format('d/m/Y') }}</td>
			<td>
				<a href="{{ route($routes['show'], $model) }}" class="btn btn-outline-secondary btn-sm" title="Ver">{!! $icons['view'] !!}</a>
				<button type="button" onclick="printJS('{{ route( 'picking.print' , $model->id ) }}')" class="bt btn-sm btn-outline-success mb-3" title="Imprimir Picking">{!! $icons['printer'] !!}</button>
				{{-- <a href="#" class="btn-delete btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a> --}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
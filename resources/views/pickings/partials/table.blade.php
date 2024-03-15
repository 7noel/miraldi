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
				<button type="button" onclick="printJS('{{ route( 'pickings.print' , $model->id ) }}')" class="btn btn-sm btn-outline-success" title="Imprimir Picking">{!! $icons['printer'] !!}</button>
				<a href="{{ route( 'pickings.print' , $model->id ) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="PDF Picking">{!! $icons['pdf'] !!}</a>
				<a href="{{ route($routes['show'], $model) }}" class="btn btn-outline-secondary btn-sm" title="Ver Picking">{!! $icons['view'] !!}</a>
				{{-- <a href="#" class="btn-delete btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a> --}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
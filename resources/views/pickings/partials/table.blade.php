<div class="table-responsive">
<table class="{{ config('options.styles.table') }}">
	<thead class="{{ config('options.styles.thead') }}">
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">Pedido</th>
			<th style="min-width: 250px">Cliente</th>
			<th class="text-center" style="min-width: 100px">Creación</th>
			<th class="text-center">Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($models as $model)
		<tr data-id="{{ $model->id }}">
			<td>{{ $model->id }}</td>
			<td class="text-center">{{ $model->CFNUMPED }}</td>
			<td>{{ $model->order->CFNOMBRE }}</td>
			<td class="text-center">{{ $model->created_at->format('d/m/Y') }}</td>
			<td class="text-center" style="white-space: nowrap;">
				<button type="button" onclick="printJS('{{ route( 'pickings.print' , $model->id ) }}')" class="btn btn-sm btn-outline-success" title="Imprimir Picking">{!! $icons['printer'] !!}</button>
				<a href="{{ route( 'pickings.print' , $model->id ) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="PDF Picking">{!! $icons['pdf'] !!}</a>
				<a href="{{ route($routes['show'], $model) }}" class="btn btn-outline-secondary btn-sm" title="Ver Picking">{!! $icons['view'] !!}</a>
				{{-- <a href="#" class="btn-delete btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a> --}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
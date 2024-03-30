<div class="table-responsive">
<table class="{{ config('options.styles.table') }}">
	<thead class="{{ config('options.styles.thead') }}">
		<tr>
			<th style="min-width: 250px">Razón Social</th>
			<th class="text-center">DNI/RUC</th>
			<th class="text-center" style="min-width: 100px">Creación</th>
			<th class="text-center" style="min-width: 100px">Modificación</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($models as $model)
		<tr data-id="{{ $model->id }}">
			<td>{{ $model->CNOMCLI }}</td>
			<td class="text-center">{{ $model->CCODCLI }}</td>
			<td class="text-center">{{ $model->DFECINS }}</td>
			<td class="text-center">{{ $model->DFECMOD }}</td>
			<td style="white-space: nowrap;">
				<a href="{{ route($routes['show'], $model) }}" class="btn btn-outline-secondary btn-sm" title="Ver">{!! $icons['view'] !!}</a>
				<a href="{{ route( $routes['edit'] , $model) }}" class="btn btn-outline-primary btn-sm" title="Editar">{!! $icons['edit'] !!}</a>
				{{-- <a href="#" class="btn-delete btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a> --}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
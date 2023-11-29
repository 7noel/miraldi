<table class="{{ config('options.styles.table') }}">
	<thead class="{{ config('options.styles.thead') }}">
		<tr>
			<th>Razón Social</th>
			<th>DNI/RUC</th>
			<th>Creación</th>
			<th>Modificación</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($models as $model)
		<tr data-id="{{ $model->id }}">
			<td>{{ $model->CNOMCLI }}</td>
			<td>{{ $model->CCODCLI }}</td>
			<td>{{ $model->DFECINS }}</td>
			<td>{{ $model->DFECMOD }}</td>
			<td>
				<a href="{{ route($routes['show'], $model) }}" class="btn btn-outline-secondary btn-sm" title="Ver">{!! $icons['view'] !!}</a>
				<a href="{{ route( $routes['edit'] , $model) }}" class="btn btn-outline-primary btn-sm" title="Editar">{!! $icons['edit'] !!}</a>
				{{-- <a href="#" class="btn-delete btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a> --}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div class="table-responsive">
<table class="{{ config('options.styles.table') }}">
	<thead class="{{ config('options.styles.thead') }}">
		<tr>
			<th class="text-center">#</th>
			<th>Usuario</th>
			<th class="text-center">Email</th>
			<th class="text-center">Rol</th>
			<th class="text-center">Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($models as $model)
		<tr data-id="{{ $model->id }}">
			<td class="text-center">{{ $model->id }}</td>
			<td>{{ $model->name }} </td>
			<td class="text-center">{{ $model->email }} </td>
			<td align="center">{{ $model->role->name }}</td>
			<td class="text-center" style="white-space: nowrap;">
				<a href="{{ route( $routes['edit'] , $model) }}" class="btn btn-outline-primary btn-sm" title="Editar">{!! $icons['edit'] !!}</a>
				<a href="#" class="btn-delete btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
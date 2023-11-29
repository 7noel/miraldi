<table class="{{ config('options.styles.table') }}">
	<thead class="{{ config('options.styles.thead') }}">
		<tr>
			<th>Código</th>
			<th>Nombre</th>
			<th>Sub Categoría</th>
			<th>Unidad</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($models as $model)
		<tr data-id="{{ $model->id }}">
			<td>{{ $model->intern_code }}</td>
			<td>{{ $model->name }} </td>
			<td>{{ $model->sub_category->name }} </td>
			<td>{{ $model->unit->symbol }} </td>
			<td>
				<div class="btn-group">
					<button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{!! $icons['store'] !!}
					</button>
					@if(count($model->stocks) > 0)
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						@foreach($model->stocks as $key => $stock)
						<a class="dropdown-item" href="{{ route('kardex', $stock->id) }}">Almacén : {{ $stock->warehouse_id }}</a>
						@endforeach
					</div>
					@endif
				</div>
				<a href="{{ route( $routes['edit'] , $model) }}" class="btn btn-outline-primary btn-sm" title="Editar">{!! $icons['edit'] !!}</a>
				<a href="#" class="btn-delete btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
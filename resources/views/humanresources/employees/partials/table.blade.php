					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>#</th>
								<th>Empleado</th>
								<th>Documento</th>
								<th>Cargo</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($models as $model)
							<tr data-id="{{ $model->id }}">
								<td>{{ $model->id }}</td>
								<td>{{ $model->full_name }}</td>
								<td>{{ $model->id_type->symbol.' '.$model->doc }}</td>
								<td>{{ $model->job->name }}</td>
								<td>
									<a href="{{ route( $routes['edit'] , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!}</a>
									<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!}</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
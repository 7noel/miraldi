					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>#</th>
								<th>Fecha</th>
								<th>Moneda</th>
								<th>Venta</th>
								<th>Compra</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($models as $model)
							<tr data-id="{{ $model->id }}">
								<td>{{ $model->id }}</td>
								<td class='date'>{{ $model->date }}</td>
								<td>{{ $model->currency->symbol }}</td>
								<td>{{ $model->sales }}</td>
								<td>{{ $model->purchase }}</td>
								<td>
									<a href="{{ route($routes['edit'] , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!}</a>
									<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!}</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
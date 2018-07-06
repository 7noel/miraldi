					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Sub Categoría</th>
								<th>Unidad</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($models as $model)
							<tr data-id="{{ $model->id }}">
								<td>{{ $model->id }}</td>
								<td>{{ $model->name }} </td>
								<td>{{ $model->sub_category->name }} </td>
								<td>{{ $model->unit->symbol }} </td>
								<td>
									<div class="btn-group">
										<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="kardex">
											{!! config('options.icons.store') !!} <span class="caret"></span>
										</button>
										@if(count($model->stocks) > 0)
										<ul class="dropdown-menu">
											@foreach($model->stocks as $key => $stock)
											<li><a href="{{ route('kardex', $stock->id) }}">Almacén : {{ $stock->warehouse_id }}</a></li>
											@endforeach
										</ul>
										@endif
									</div>
									<a href="{{ route( $routes['edit'] , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!}</a>
									<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!}</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
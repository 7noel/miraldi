					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>#</th>
								<th>Empresa</th>
								<th>Documento</th>
								<th>Serie</th>
								<th>Numero</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($models as $model)
							<tr data-id="{{ $model->id }}">
								<td>{{ $model->id }}</td>
								<td>{{ $model->company->company_name }} </td>
								<td>{{ $model->document_type->name }} </td>
								<td>{{ $model->series }} </td>
								<td>{{ $model->number }} </td>
								<td>
									<a href="{{ route( $routes['edit'] , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!} </a>
									<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!} </a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
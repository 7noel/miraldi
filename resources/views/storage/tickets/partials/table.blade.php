					<table class="table table-hover table-condensed">
						<tr>
							<th>#</th>
							<th>Fecha</th>
							<th>Empresa</th>
							<th>Acciones</th>
						</tr>
						@foreach($models as $model)
						<tr data-id="{{ $model->id }}">
							<td>{{ $model->id }}</td>
							<td>{{ $model->created_at->formatLocalized('%d/%m/%Y') }}</td>
							<td>{{ $model->company->company_name }} </td>
							<td>
								<a href="{{ route( str_replace('index', 'edit', Request::route()->getAction()['as']) , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!}</a>
								<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!}</a>
							</td>
						</tr>
						@endforeach
					</table>
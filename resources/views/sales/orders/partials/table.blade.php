					<table class="table table-hover table-condensed">
						<tr>
							<th>#</th>
							<th>Fecha</th>
							<th>Empresa</th>
							<th>Estado</th>
							<th>Total</th>
							<th>Acciones</th>
						</tr>
						@foreach($models as $model)
						<tr data-id="{{ $model->id }}">
							<td>{{ $model->id }}</td>
							<td>{{ $model->created_at->formatLocalized('%d/%m/%Y') }}</td>
							<td>{{ $model->company->company_name }} </td>
							<td>{{ $model->status }}</td>
							<td>{{ $model->currency->symbol." ".$model->total}} </td>
							<td>
								@if(\Auth::user()->is_superuser)
								<a href="{{ route('audit', ['model' => $model->getMorphClass(), 'id' => $model->id]) }}" target="_blank" class="btn btn-default btn-xs" title="Histórico">{!! config('options.icons.history') !!}</a>
								@endif
								@if($model->checked_at)
								<a href="{{ route( 'print_order' , $model->id ) }}" target="_blank" class="btn btn-success btn-xs" title="Imprimir">{!! config('options.icons.printer') !!} </a>
								@else
								<a href="#" class="btn btn-success btn-xs" title="Imprimir" disabled="disabled">{!! config('options.icons.printer') !!}</a>
								@endif
								<a href="{{ route( str_replace('index', 'edit', Request::route()->getAction()['as']) , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!}</a>
								<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!}</a>
							</td>
						</tr>
						@endforeach
					</table>
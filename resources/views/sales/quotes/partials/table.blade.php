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
							<td>{{ config("options.quote_status.$model->status_id") }}</td>
							<td>{{ $model->currency->symbol." ".$model->total}} </td>
							<td>
								@if($model->order_id == 0)
								<a href="{{ route('orders.by_quote', $model->id) }}" class="btn btn-default btn-xs" title="Generar Pedido">{!! config('options.icons.invoice') !!}</a>
								@else
								<a href="{{ route('orders.show', $model->id) }}" class="btn btn-default btn-xs" title="Ver Pedido">{!! config('options.icons.invoice') !!}</a>
								@endif
								@if($model->checked_at)
								<a href="{{ route( 'print_order' , $model->id ) }}" target="_blank" class="btn btn-success btn-xs" title="Imprimir">{!! config('options.icons.printer') !!} </a>
								@else
								<a href="#" class="btn btn-success btn-xs" title="Imprimir" disabled="disabled">{!! config('options.icons.printer') !!}</a>
								@endif
								<a href="{{ route( 'quotes.edit' , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!}</a>
								<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!}</a>
							</td>
						</tr>
						@endforeach
					</table>
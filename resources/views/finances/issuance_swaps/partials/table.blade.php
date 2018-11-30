						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Fecha</th>
									<th>Documento</th>
									<th>Empresa</th>
									<th>Total</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach($models as $model)
								<tr data-id="{{ $model->id }}">
									<td>{{ $model->id }}</td>
									<td>{{ \Carbon::createFromFormat('Y-m-d', $model->issued_at)->formatLocalized('%d/%m/%Y') }} </td>
									<td>{{ $model->document_type->name." ".$model->sn }} </td>
									<td>{{ $model->company->company_name }} </td>
									<td>{{ $model->currency->symbol." ".$model->total}} </td>
									<td>
										@if($model->payment_condition_id == 3)
										<a href="{{ route( 'issuance_swaps.byProof' , $model->id) }}" class="btn btn-default btn-xs" title="Letras">{!! config('options.icons.invoice') !!}</a>
										@else
										<a href="{{ route( 'amortizations.byProof' , $model->id) }}" class="btn btn-default btn-xs" title="Pagos">{!! config('options.icons.pay') !!}</a>
										@endif
										<a href="{{ route( str_replace('index', 'edit', Request::route()->getAction()['as']) , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!}</a>
										<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!}</a>
									<a href="{{ ($model->response_sunat == '')? '#' : json_decode($model->response_sunat)->enlace_del_pdf }}">{!! config('options.icons.pdf') !!}</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
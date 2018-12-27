						<a href="#" id="btnAddProof" class="btn btn-success btn-sm" title="Agregar Producto">{!! config('options.icons.add') !!} Agregar Docs</a>
						@if(isset($model))
						<a href="#" id="btnAddLetter" class="btn btn-success btn-sm" title="Agregar Letra">{!! config('options.icons.add') !!} Agregar Letras</a>
						@else
						<a href="#" id="btnGenLetters" class="btn btn-default btn-sm" title="Generar Letras">{!! config('options.icons.add') !!} Generar Letras</a>
						@endif
						@php $i=0; @endphp
						
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-4">Documento</th>
									<th class="col-sm-2">Emisión</th>
									<th class="col-sm-2">Vencimiento</th>
									<th class="col-sm-1">Importe</th>
									<th class="col-sm-1">Acciones</th>
								</tr>
							</thead>
							<tbody id="tableItems">
							@if(isset($model->proofs))
							@foreach($model->proofs as $proof)
								<tr data-id="{{ $proof->id }}">
									{!! Form::hidden("proofs[$i][id]", $proof->id, ['class'=>'proofId','data-proofId'=>'']) !!}
									{!! Form::hidden("proofs[$i][swap_id]", $model->id, ['class'=>'swapId','data-swapId'=>'']) !!}
									<td>{!! Form::text("proofs[$i][txtProof]", $proof->document_type->name.' '.$proof->sn, ['class'=>'form-control input-sm txtProof', 'data-product'=>'', 'required'=>'required', 'disabled']); !!}</td>
									<td><p class="form-control-static txtEmision">{{ $proof->issued_at }}</p></td>
									<td><p class="form-control-static txtVencimiento">{{ $proof->expired_at }}</p></td>
									<td><p class="form-control-static txtImporte">{{ $proof->currency->symbol.' '.$proof->total }}</p></td>
									<td class="text-center form-inline">
										<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
										<input type="checkbox" name="proofs[{{$i}}][is_deleted]" data-isdeleted class="isdeleted hidden">
									</td>
								</tr>
								@php $i++; @endphp
							@endforeach
							@elseif($proof)
								<tr data-id="{{ $proof->id }}">
									{!! Form::hidden("proofs[$i][id]", $proof->id, ['class'=>'proofId','data-proofId'=>'']) !!}
									<td>{!! Form::text("proofs[$i][txtProof]", $proof->document_type->name.' '.$proof->sn, ['class'=>'form-control input-sm txtProof', 'data-proof'=>'', 'required'=>'required', 'disabled']); !!}</td>
									<td><p class="form-control-static txtEmision">{{ $proof->issued_at }}</p></td>
									<td><p class="form-control-static txtVencimiento">{{ $proof->expired_at }}</p></td>
									<td><p class="form-control-static txtImporte">{{ $proof->currency->symbol.' '.$proof->total }}</p></td>
									<td class="text-center form-inline">
										<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
										<input type="checkbox" name="proofs[{{$i}}][is_deleted]" data-isdeleted class="isdeleted hidden">
									</td>
								</tr>
								@php $i++; @endphp
							@endif
							</tbody>
						</table>
						{!! Form::hidden('items_d', $i, ['id'=>'items_d']) !!}

						<template id="template-row-proof">
							<tr>
								{!! Form::hidden('data1', null, ['class'=>'proofId','data-proofId'=>'']) !!}
								<td>{!! Form::text("data2", null, ['class'=>'form-control input-sm txtProof', 'data-proof'=>'', 'required'=>'required']); !!}</td>
								<td><p class="form-control-static txtEmision"></p></td>
								<td><p class="form-control-static txtVencimiento"></p></td>
								<td><p class="form-control-static txtImporte"></p></td>
								<td class="text-center form-inline">
									<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
									<input type="checkbox" name="data3" data-isdeleted class="isdeleted hidden">
								</td>
							</tr>
						</template>


						@php $i=0; @endphp
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-4">NroLetra</th>
									<th class="col-sm-2">Emisión</th>
									<th class="col-sm-2">Vencimiento</th>
									<th class="col-sm-1">Monto</th>
									<th class="col-sm-1">Interéses</th>
									<th class="col-sm-1">Acciones</th>
								</tr>
							</thead>
							<tbody id="tableLetters">
							@if(isset($model->letters))
							@foreach($model->letters as $letter)
								<tr data-id="{{ $letter->id }}">
									{!! Form::hidden("letters[$i][id]", $letter->id, ['class'=>'letterId','data-letterId'=>'']) !!}
									{!! Form::hidden("letters[$i][product_id]", $letter->product_id, ['class'=>'productId','data-productid'=>'']) !!}
									{!! Form::hidden("letters[$i][unit_id]", $letter->unit_id, ['class'=>'unitId','data-unitid'=>'']) !!}
									<td><span class='form-control input-sm intern_code text-right' data-labelid>{{ $letter->product->intern_code }}</span></td>
									<td>{!! Form::text("letters[$i][txtProduct]", $letter->product->name, ['class'=>'form-control input-sm txtProduct', 'data-product'=>'', 'required'=>'required', 'disabled']); !!}</td>
									<td>{!! Form::text("letters[$i][quantity]", $letter->quantity, ['class'=>'form-control input-sm txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
									<td class="withTax">{!! Form::text("letters[$i][price]", $letter->price, ['class'=>'form-control input-sm txtPrecio text-right', 'data-precio'=>'']) !!}</td>
									<td class="withoutTax">{!! Form::text("letters[$i][value]", $letter->value, ['class'=>'form-control input-sm txtValue text-right', 'data-value'=>'']) !!}</td>
									<td class="text-center form-inline">
										<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
										<input type="checkbox" name="letters[{{$i}}][is_deleted]" data-isdeleted class="isdeleted hidden">
									</td>
								</tr>
								@php $i++; @endphp
							@endforeach
							@endif
							</tbody>
						</table>
						{!! Form::hidden('items_l', $i, ['id'=>'items_l']) !!}

						<template id="template-row-letter">
							<tr>
								{!! Form::hidden('data1', null, ['class'=>'letterId','data-letterId'=>'']) !!}
								<td>{!! Form::text('data3', null, ['class'=>'form-control input-sm txtSn', 'data-sn'=>'', 'required']); !!}</td>
								<td>{!! Form::date('data4', null, ['class'=>'form-control input-sm txtEmision text-right', 'data-emision'=>'', 'required']) !!}</td>
								<td>{!! Form::date('data5', null, ['class'=>'form-control input-sm txtExpired text-right', 'data-expired'=>'', 'required']) !!}</td>
								<td>{!! Form::number('data6', null, ['class'=>'form-control input-sm txtTotal text-right', 'data-total'=>'', 'required']) !!}</td>
								<td>{!! Form::number('data7', null, ['class'=>'form-control input-sm txt text-right', 'data-interest'=>'']) !!}</td>
								<td>{!! Form::text('data8', null, ['class'=>'form-control input-sm txtDscto2 text-right', 'data-dscto2'=>'']) !!}</td>
								<td class="text-center form-inline">
									<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
									<input type="checkbox" name="data8" data-isdeleted class="isdeleted hidden">
								</td>
							</tr>
						</template>
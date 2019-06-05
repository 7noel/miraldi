						@php $i=0; @endphp
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-4">Comprobante</th>
									<th class="col-sm-2">Emisión</th>
									<th class="col-sm-2">Vencimiento</th>
									<th class="col-sm-1">Importe</th>
									<th class="col-sm-1">Acciones</th>
								</tr>
							</thead>
							<tbody id="tableItems">
							@if(isset($model))
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
							@elseif(isset($proof))
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
						<a href="#" id="btnAddProof" class="btn btn-success btn-sm" title="Agregar Producto">{!! config('options.icons.add') !!} Agregar Docs</a>

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

						<br><br>
						@php $i=0; @endphp
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-7">NroLetra</th>
									<th class="col-sm-1">Emisión</th>
									<th class="col-sm-1">Vencimiento</th>
									<th class="col-sm-1">Monto</th>
									<th class="col-sm-1">Interés</th>
									<th class="col-sm-1">Acciones</th>
								</tr>
							</thead>
							<tbody id="tableLetters">
							@if(isset($model))
							@foreach($model->letters as $letter)
								<tr data-id="{{ $letter->id }}">
									{!! Form::hidden("letters[$i][id]", $letter->id, ['class'=>'letterId','data-letterId'=>'']) !!}
									{!! Form::hidden("letters[$i][proof_type]", 3, ['class'=>'proof_type','data-proof_type'=>'']) !!}
									{!! Form::hidden("letters[$i][my_company]", session('my_company')->id, ['class'=>'my_company','data-my_company'=>'']) !!}
									<td>{!! Form::text("letters[$i][txtLetter]", $letter->sn, ['class'=>'form-control input-sm txtLetter', 'data-sn'=>'', 'required'=>'required', 'disabled']); !!}</td>
									<td>{!! Form::date("letters[$i][issued_at]", $letter->issued_at, ['class'=>'form-control input-sm issued_at text-right', 'data-issued_at'=>'']) !!}</td>
									<td>{!! Form::date("letters[$i][expired_at]", $letter->expired_at, ['class'=>'form-control input-sm expired_at text-right', 'data-expired_at'=>'']) !!}</td>
									<td>{!! Form::number("letters[$i][subtotal]", $letter->subtotal, ['class'=>'form-control input-sm subtotal text-right', 'data-subtotal'=>'', 'step' => 'any']) !!}</td>
									<td>{!! Form::number("letters[$i][interest]", $letter->interest, ['class'=>'form-control input-sm interest text-right', 'data-interest'=>'', 'step' => 'any']) !!}</td>
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
						<a href="#" id="btnAddLetter" class="btn btn-success btn-sm" title="Agregar Letra">{!! config('options.icons.add') !!} Agregar Letras</a>
						@php $i=0; @endphp

						<template id="template-row-letter">
							<tr>
								{!! Form::hidden('data1', 3, ['class'=>'proof_type','data-proof_type'=>'']) !!}
								{!! Form::hidden('data2', session('my_company')->id, ['class'=>'my_company','data-my_company'=>'']) !!}
								<td>{!! Form::text('data3', null, ['class'=>'form-control input-sm txtLetter', 'data-letter'=>'', 'required']); !!}</td>
								<td>{!! Form::date('data4', date('Y-m-d'), ['class'=>'form-control input-sm issued_at text-right', 'data-issued_at'=>'', 'required']) !!}</td>
								<td>{!! Form::date('data5', date('Y-m-d'), ['class'=>'form-control input-sm expired_at text-right', 'data-expired_at'=>'', 'required']) !!}</td>
								<td>{!! Form::number('data6', 0, ['class'=>'form-control input-sm subtotal text-right', 'data-subtotal'=>'', 'required', 'step' => 'any']) !!}</td>
								<td>{!! Form::number('data7', 0, ['class'=>'form-control input-sm interest text-right', 'data-interest'=>'', 'step' => 'any']) !!}</td>
								<td class="text-center form-inline">
									<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
									<input type="checkbox" name="data8" data-isdeleted class="isdeleted hidden">
								</td>
							</tr>
						</template>
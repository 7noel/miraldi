						<a href="#" id="btnAddProduct" class="btn btn-success btn-sm" title="Agregar Producto">{!! config('options.icons.add') !!} Agregar</a>
						@php $i=0; @endphp
						<div class="table-responsive">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-2">Código Int</th>
									<th class="col-xs-8 col-md-4 ">Descripción</th>
									<th class="col-sm-1">Cantidad</th>
									<th class="col-sm-1 withTax">Precio</th>
									<th class="col-sm-1 withoutTax">Valor Unit</th>
									<th class="col-sm-1">Dscto1(%)</th>
									<th class="col-sm-1">Dscto2(%)</th>
									<th class="col-sm-1">Acciones</th>
									<!-- <th class="col-sm-1">V.Total</th> -->
								</tr>
							</thead>
							<tbody id="tableItems">
							@if(isset($model->details))
							@foreach($model->details as $detail)
								@php $categories=[]; @endphp
								<tr data-id="{{ $detail->id }}">
									{!! Form::hidden("details[$i][id]", $detail->id, ['class'=>'detailId','data-detailId'=>'']) !!}
									{!! Form::hidden("details[$i][product_id]", $detail->product_id, ['class'=>'productId','data-productid'=>'']) !!}
									{!! Form::hidden("details[$i][unit_id]", $detail->unit_id, ['class'=>'unitId','data-unitid'=>'']) !!}
									<td><span class='form-control input-sm intern_code text-right' data-labelid>{{ $detail->product->intern_code }}</span></td>
									<td>{!! Form::text("details[$i][txtProduct]", $detail->product->name, ['class'=>'form-control input-sm txtProduct', 'data-product'=>'', 'required'=>'required', 'disabled']); !!}</td>
									<td>{!! Form::text("details[$i][quantity]", $detail->quantity, ['class'=>'form-control input-sm txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
									<td class="withTax">{!! Form::text("details[$i][price]", $detail->price, ['class'=>'form-control input-sm txtPrecio text-right', 'data-precio'=>'', 'readonly'=>'readonly']) !!}</td>
									<td class="withoutTax">{!! Form::text("details[$i][value]", $detail->value, ['class'=>'form-control input-sm txtValue text-right', 'data-value'=>'', 'readonly'=>'readonly']) !!}</td>
									<td>{!! Form::text("details[$i][d1]", $detail->d1, ['class'=>'form-control input-sm txtDscto text-right', 'data-dscto'=>'']) !!}</td>
									<td>{!! Form::text("details[$i][d2]", $detail->d2, ['class'=>'form-control input-sm txtDscto2 text-right', 'data-dscto'=>'']) !!}</td>
									<!-- <td> <span class='form-control input-sm txtTotal text-right' data-total>{{ $detail->total }}</span> </td> -->
									<td class="text-center form-inline">
										<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
										<input type="checkbox" name="details[{{$i}}][is_deleted]" data-isdeleted class="isdeleted hidden">
									</td>
								</tr>
								@php $i++; @endphp
							@endforeach
							@endif
							</tbody>
						</table>
						</div>
						<template id="template-row-item">
							<tr>
								{!! Form::hidden('data1', null, ['class'=>'productId','data-productid'=>'']) !!}
								{!! Form::hidden('data2', null, ['class'=>'unitId','data-unitid'=>'']) !!}
								<td><span class='form-control input-sm intern_code text-right' data-labelid></span></td>
								<td>{!! Form::text('data3', null, ['class'=>'col-sm-4 form-control input-sm txtProduct', 'data-product'=>'', 'required'=>'required']); !!}</td>
								<td>{!! Form::text('data4', null, ['class'=>'form-control input-sm txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
								<td class="withTax">{!! Form::text('data5', null, ['class'=>'form-control input-sm txtPrecio text-right', 'data-precio'=>'', 'readonly'=>'readonly']) !!}</td>
								<td class="withoutTax">{!! Form::text('data7', null, ['class'=>'form-control input-sm txtValue text-right', 'data-value'=>'', 'readonly'=>'readonly']) !!}</td>
								<td>{!! Form::text('data6', null, ['class'=>'form-control input-sm txtDscto text-right', 'data-dscto'=>'']) !!}</td>
								<td>{!! Form::text('data8', null, ['class'=>'form-control input-sm txtDscto2 text-right', 'data-dscto2'=>'']) !!}</td>
								<!-- <td> <span class='form-control input-sm txtTotal text-right' data-total></span> </td> -->
								<td class="text-center form-inline">
									<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
									<input type="checkbox" name="data8" data-isdeleted class="isdeleted hidden">
								</td>
							</tr>
						</template>
						{!! Form::hidden('items', $i, ['id'=>'items']) !!}
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="text-center">V.Bruto</th>
									<th class="text-center">Dscto</th>
									<th class="text-center">SubTotal</th>
									<th class="text-center">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center"><span id="mGrossValue">{{ (isset($model)) ? $model->gross_value : "0.00" }}</span></td>
									<td class="text-center"><span id="mDiscount">{{ (isset($model)) ? $model->discount_items : "0.00" }}</span></td>
									<td class="text-center"><span id="mSubTotal">{{ (isset($model)) ? $model->subtotal : "0.00" }}</span></td>
									<td class="text-center"><span id="mTotal">{{ (isset($model)) ? $model->total : "0.00" }}</span></td>
								</tr>
							</tbody>
						</table>

						<div class="form-group form-group-sm">
							<div class="col-sm-2">
								<a href="#" id="btnAddProduct" class="btn btn-success btn-sm pull-left" title="Agregar Producto">{!! config('options.icons.add') !!} Agregar</a>
							</div>
							{!! Form::label('currency_cost','Costo expresado en:', ['class'=>'col-sm-2 col-sm-offset-2 control-label isImport']) !!}
							<div class="col-sm-2">
								{!! Form::select('currency_cost',$currencies , ((isset($model)) ? $model->currency_id : 2), ['class'=>'form-control input-sm isImport', 'id'=>'currency_cost']) !!}
							</div>
							{!! Form::label('factor','Factor', ['class'=>'col-sm-2 control-label isImport']) !!}
							<div class="col-sm-2">
								{!! Form::number('factor', null, ['class'=>'form-control input-sm isImport', 'id'=>'factor', 'readonly'=>'readonly']) !!}
							</div>
						</div>
						@php $i=0; @endphp
						<div class="table-responsive">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-1">#</th>
									<th class="col-sm-5">Descripción</th>
									<th class="col-sm-1">Cantidad</th>
									<th class="col-sm-1 withTax">Precio</th>
									<th class="col-sm-1 withoutTax">Valor</th>
									<th class="col-sm-1 isImport">Costo</th>
									<th class="col-sm-1 import">V. Tot</th>
									<th class="col-sm-2">Acciones</th>
								</tr>
							</thead>
							<tbody id="tableItems">
							@if(isset($model->details))
							@foreach($model->details as $detail)
								<tr data-id="{{ $detail->id }}">
									{!! Form::hidden("details[$i][id]", $detail->id, ['class'=>'detailId','data-detailId'=>'']) !!}
									{!! Form::hidden("details[$i][product_id]", $detail->product_id, ['class'=>'productId','data-productid'=>'']) !!}
									{!! Form::hidden("details[$i][unit_id]", $detail->unit_id, ['class'=>'unitId','data-unitid'=>'']) !!}
									<td><span class='form-control input-sm intern_code text-right' data-labelid>{{ $detail->product->intern_code }}</span></td>
									<td>{!! Form::text("details[$i][txtProduct]", $detail->product->name, ['class'=>'form-control input-sm txtProduct', 'data-product'=>'', 'required'=>'required', 'disabled']); !!}</td>
									<td>{!! Form::text("details[$i][quantity]", $detail->quantity, ['class'=>'form-control input-sm txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
									<td class="withTax">{!! Form::text("details[$i][price]", $detail->price, ['class'=>'form-control input-sm txtPrecio text-right', 'data-precio'=>'']) !!}</td>
									<td class="withoutTax">{!! Form::text("details[$i][value]", $detail->value, ['class'=>'form-control input-sm txtValue text-right', 'data-value'=>'']) !!}</td>
									<td class="isImport">
										{!! Form::hidden("details[$i][cost]", $detail->cost, ['class'=>'form-control input-sm cost', 'data-cost'=>'']) !!}
										{!! Form::text("details[$i][text_cost]", $detail->cost, ['class'=>'form-control input-sm txtCost text-right', 'data-textcost'=>'', 'readonly'=>'readonly']) !!}
									</td>
									<td> <span class='form-control input-sm txtTotal text-right import' data-total>{{ $detail->total }}</span> </td>
									<td class="text-center form-inline">
										<div class="checkbox">
											<label><input type="checkbox" name="details[{{$i}}][is_deleted]" data-isdeleted class="isdeleted"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></label>
										</div>
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
								<td>{!! Form::text('data3', null, ['class'=>'form-control input-sm txtProduct', 'data-product'=>'', 'required'=>'required']); !!}</td>
								<td>{!! Form::text('data4', null, ['class'=>'form-control input-sm txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
								<td class="withTax">{!! Form::text('data5', null, ['class'=>'form-control input-sm txtPrecio text-right', 'data-precio'=>'']) !!}</td>
								<td class="withoutTax">{!! Form::text('data5', null, ['class'=>'form-control input-sm txtValue text-right', 'data-value'=>'']) !!}</td>
								<td class="isImport">
									{!! Form::hidden('data6', null, ['class'=>'form-control input-sm cost', 'data-cost'=>'', 'readonly'=>'readonly']) !!}
									{!! Form::text('data7', null, ['class'=>'form-control input-sm txtCost text-right', 'data-textcost'=>'', 'readonly'=>'readonly']) !!}
								</td>
								<td> <span class='form-control input-sm txtTotal text-right import' data-total></span> </td>
								<td class="text-center form-inline">
									<div class="checkbox">
										<label><input type="checkbox" name="data7" data-isdeleted class="isdeleted"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></label>
									</div>
								</td>
							</tr>
						</template>
						{!! Form::hidden('items', $i, ['id'=>'items']) !!}
						<table class="table table-condensed table-responsive">
							<thead>
								<tr>
									<th class="text-center isNotImport">V.Bruto</th>
									<th class="text-center isNotImport">SubTotal</th>
									<th class="text-center isNotImport">Total</th>
									<th class="text-center isImport">EXW</th>
									<th class="text-center isImport">FOB</th>
									<th class="text-center isImport">CIF</th>
									<th class="text-center isImport">TOTAL</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center isNotImport"><span id="mGrossValue">{{ (isset($model)) ? $model->gross_value : "0.00" }}</span></td>
									<td class="text-center isNotImport"><span id="mSubTotal">{{ (isset($model)) ? $model->subtotal : "0.00" }}</span></td>
									<td class="text-center isNotImport"><span id="mTotal">{{ (isset($model)) ? $model->total : "0.00" }}</span></td>
									<td class="text-center isImport"><span id="exw"></span></td>
									<td class="text-center isImport"><span id="fob"></span></td>
									<td class="text-center isImport"><span id="cif"></span></td>
									<td class="text-center isImport"><span id="tot"></span></td>
								</tr>
							</tbody>
						</table>
						<a href="#" id="btnAddProduct" class="btn btn-success btn-sm" title="Agregar Producto">{!! config('options.icons.add') !!} Agregar</a>
						@php $i=0; @endphp
						
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-1">#</th>
									<th class="col-sm-5">Descripción</th>
									<th class="col-sm-1">Cantidad</th>
									<th class="col-sm-1">Unidad</th>
									<th class="col-sm-2">Acciones</th>
								</tr>
							</thead>
							<tbody id="tableItems">
							@if(isset($model->details))
							@foreach($model->details as $detail)
								<tr data-id="{{ $detail->id }}">
									{!! Form::hidden("details[$i][id]", $detail->id, ['class'=>'detailId','data-detailId'=>'']) !!}
									{!! Form::hidden("details[$i][stock_id]", $detail->product_id, ['class'=>'productId','data-productid'=>'']) !!}
									{!! Form::hidden("details[$i][unit_id]", $detail->unit_id, ['class'=>'unitId','data-unitid'=>'']) !!}
									<td><span class='form-control input-sm intern_code text-right' data-labelid>{{ $detail->stock->product->intern_code }}</span></td>
									<td>{!! Form::text("details[$i][txtProduct]", $detail->stock->product->name, ['class'=>'form-control input-sm txtProduct', 'data-product'=>'', 'required'=>'required', 'disabled']); !!}</td>
									<td><span class='form-control input-sm txtUnit text-center' data-total> {{ $detail->stock->product->unit->symbol }} </span></td>
									<td>{!! Form::text("details[$i][quantity]", $detail->quantity, ['class'=>'form-control input-sm txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
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
						<template id="template-row-item">
							<tr>
								{!! Form::hidden('data1', null, ['class'=>'productId','data-productid'=>'']) !!}
								{!! Form::hidden('data2', null, ['class'=>'unitId','data-unitid'=>'']) !!}
								<td> <span class='form-control input-sm intern_code text-right' data-labelid></span> </td>
								<td>{!! Form::text('data3', null, ['class'=>'form-control input-sm txtProduct', 'data-product'=>'', 'required'=>'required']); !!}</td>
								<td>{!! Form::text('data4', null, ['class'=>'form-control input-sm txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
								<td> <span class='form-control input-sm txtUnit text-center' data-labelunit></span> </td>
								<td class="text-center form-inline">
									<div class="checkbox">
										<label><input type="checkbox" name="data7" data-isdeleted class="isdeleted"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></label>
									</div>
								</td>
							</tr>
						</template>
						{!! Form::hidden('items', $i, ['id'=>'items']) !!}

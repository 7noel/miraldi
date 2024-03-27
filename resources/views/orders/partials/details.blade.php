@php $i=0; @endphp
<div class="">
<table class="table table-sm table-responsive">
	<thead>
		<tr>
			<th width="100px">Código</th>
			<th width="300px">Descripción</th>
			<th width="100px">Cantidad</th>
			<th class="withTax" width="100px">Precio</th>
			<th class="withoutTax" width="100px">Valor</th>
			<th width="100px">Dscto1(%)</th>
			<th width="100px" class="">Dscto2(%)</th>
			<th class="withoutTax" width="100px">V.Total</th>
			<th class="withTax" width="100px">P.Total</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody id="tableItems">
	@if(isset($model->details))
	@foreach($model->details as $detail)
		@php $categories=[]; @endphp
		<tr data-id="{{ $detail->id }}">
			{!! Form::hidden("details[$i][DFSECUEN]", $detail->DFSECUEN, ['class'=>'detailId','data-detailId'=>'']) !!}
			{!! Form::hidden("details[$i][DFUNIDAD]", $detail->DFUNIDAD, ['class'=>'unitId','data-unitid'=>'']) !!}
			<td>{!! Form::text("details[$i][DFCODIGO]", $detail->DFCODIGO, ['class'=>'form-control-sm form-control-plaintext productId', 'data-productid'=>'', 'required'=>'required', 'readonly']); !!}</td>
			<td>{!! Form::text("details[$i][DFDESCRI]", $detail->DFDESCRI, ['class'=>'form-control-sm form-control-plaintext txtProduct', 'data-product'=>'', 'required'=>'required', 'readonly']); !!}</td>
			<td>{!! Form::text("details[$i][DFCANTID]", number_format($detail->DFCANTID, 2, '.', ''), ['class'=>'form-control-sm form-control-plaintext txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
			@if(config('options.cambiar_precios'))
				<td class="withTax">{!! Form::text("details[$i][value]", $detail->DFPREC_ORI*1.18, ['class'=>'form-control-sm form-control-plaintext txtPrecio text-right', 'data-precio'=>'']) !!}</td>
				<td class="withoutTax">{!! Form::text("details[$i][DFPREC_ORI]", ($detail->DFPREC_ORI), ['class'=>'form-control-sm form-control-plaintext txtValue text-right', 'data-value'=>'']) !!}</td>
			@else
				<td class="withTax">{!! Form::text("details[$i][value]", number_format($detail->DFPREC_ORI*1.18, 2, '.', ''), ['class'=>'form-control-sm form-control-plaintext txtPrecio text-right', 'data-precio'=>'', 'readonly'=>'readonly']) !!}</td>
				<td class="withoutTax">{!! Form::text("details[$i][DFPREC_ORI]", ($detail->DFPREC_ORI), ['class'=>'form-control-sm form-control-plaintext txtValue text-right', 'data-value'=>'', 'readonly'=>'readonly']) !!}</td>
			@endif
			<td>{!! Form::text("details[$i][CFPORDESCL]", number_format($model->CFPORDESCL, 0, '.',''), ['class'=>'form-control-plaintext form-control-sm txtDscto text-right', 'data-dscto'=>'', 'readonly']) !!}</td>
			<td>{!! Form::text("details[$i][DFPORDES]", number_format($detail->DFPORDES, 0, '.', ''), ['class'=>'form-control-sm form-control-plaintext txtDscto2 text-right', 'data-dscto'=>'']) !!}</td>
			<td class="withoutTax"> <span class='form-control-sm form-control-plaintext txtTotal text-right' data-total>{{ number_format($detail->DFIMPMN/1.18, 4, '.', '') }}</span> </td>
			<td class="withTax"> <span class='form-control-sm form-control-plaintext txtPriceItem text-right' data-price_item>{{ number_format($detail->DFIMPMN, 4, '.', '') }}</span> </td>
			<td class="text-center form-inline">
			<a href="#" class="btn btn-outline-primary btn-sm btn-edit-item" title="Editar">{!! $icons['edit'] !!}</a>
				<a href="#" class="btn btn-outline-danger btn-sm btn-delete-item" title="Eliminar">{!! $icons['remove'] !!}</a>
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
		{!! Form::hidden('data2', null, ['class'=>'unitId','data-unitid'=>'']) !!}
		<td width="100px">{!! Form::text('data1', null, ['class'=>'form-control-sm form-control-plaintext productId', 'data-productid'=>'', 'required'=>'required', 'readonly']); !!}</td>
		<td width="100px">{!! Form::text('data3', null, ['class'=>'form-control form-control-sm txtProduct', 'data-product'=>'', 'required'=>'required']); !!}</td>
		<td width="100px">{!! Form::text('data4', null, ['class'=>'form-control form-control-sm txtCantidad text-right', 'data-cantidad'=>'']) !!}</td>
		@if(config('options.cambiar_precios'))
			<td width="100px" class="withTax">{!! Form::text('data5', null, ['class'=>'form-control form-control-sm txtPrecio text-right', 'data-precio'=>'']) !!}</td>
			<td width="100px" class="withoutTax">{!! Form::text('data7', null, ['class'=>'form-control form-control-sm txtValue text-right', 'data-value'=>'']) !!}</td>
		@else
			<td width="100px" class="withTax">{!! Form::text('data5', null, ['class'=>'form-control form-control-sm txtPrecio text-right', 'data-precio'=>'', 'readonly'=>'readonly']) !!}</td>
			<td width="100px" class="withoutTax">{!! Form::text('data7', null, ['class'=>'form-control form-control-sm txtValue text-right', 'data-value'=>'', 'readonly'=>'readonly']) !!}</td>
		@endif
		<td width="100px">{!! Form::text('data6', null, ['class'=>'form-control-plaintext form-control-sm txtDscto text-right', 'data-dscto'=>'', 'readonly']) !!}</td>
		<td width="100px">{!! Form::text('data8', null, ['class'=>'form-control form-control-sm txtDscto2 text-right', 'data-dscto2'=>'']) !!}</td>
		<td width="100px" class="withoutTax"> <span class='form-control form-control-sm txtTotal text-right' data-total></span> </td>
		<td width="100px" class="withTax"> <span class='form-control form-control-sm txtPriceItem text-right' data-price_item></span> </td>
		<td width="100px" class="text-center form-inline">
			<a href="#" class="btn btn-outline-primary btn-sm btn-edit-item" title="Editar">{!! $icons['edit'] !!}</a>
			<a href="#" class="btn btn-outline-danger btn-sm btn-delete-item" title="Eliminar">{!! $icons['remove'] !!}</a>
		</td>
	</tr>
</template>
{!! Form::hidden('items', $i, ['id'=>'items']) !!}
<a href="#" id="btnAddProduct" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalx" title="Agregar Producto">{!! $icons['add'] !!} Agregar</a>

<!-- Modal -->
<div class="modal fade" id="exampleModalx" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Agregar Producto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body form-row">
				<div class="form-group col-sm-12">
					<label for="txtProducto">Producto</label>
					<small id="txtCodigo"></small>
					<input type="text" class="form-control form-control-sm" id="txtProducto">
					<input type="hidden" id="txtProduct">
					<input type="hidden" id="unitId">
				</div>
				<div class="form-group col-3 text-center">
					<label for="txtCantidad">Cantidad</label>
					<input type="number" class="form-control form-control-sm text-center" id="txtCantidad">
				</div>
				<div class="form-group col-3 text-center">
					<label for="txtValue">Valor</label>
					<input type="number" class="form-control form-control-sm text-center" id="txtValue">
				</div>
				<div class="form-group col-3 text-center">
					<label for="txtDscto2">Dscto2 (%)</label>
					<input type="number" class="form-control form-control-sm text-center" id="txtDscto2">
				</div>
				<div class="form-group col-3 text-center">
					<label for="txtTotal">Total</label>
					<input type="text" class="form-control-sm form-control-plaintext text-center" id="txtTotal" readonly>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="btn-add-product">Agregar</button>
			</div>
		</div>
	</div>
</div>

<table class="table table-condensed table-sm">
	<thead>
		<tr>
			<th class="text-center">Dscto Total</th>
			<th class="text-center">SubTotal</th>
			<th class="text-center">IGV</th>
			<th class="text-center">Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="text-center"><span id="mDiscount">{{ (isset($model)) ? number_format($model->CFDESVAL, 2, '.', '') : "0.00" }}</span></td>
			<td class="text-center"><span id="mSubTotal">{{ (isset($model)) ? number_format($model->CFIMPORTE-$model->CFIGV, 2, '.', '') : "0.00" }}</span></td>
			<td class="text-center"><span id="mIgv">{{ (isset($model)) ? number_format($model->CFIGV, 2, '.', '') : "0.00" }}</span></td>
			<td class="text-center"><span id="mTotal">{{ (isset($model)) ? number_format($model->CFIMPORTE,2,'.','') : "0.00" }}</span></td>
		</tr>
	</tbody>
</table>

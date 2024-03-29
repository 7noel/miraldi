@php $i=0; @endphp
<div class="table-responsive">
<table class="table table-sm table-hover">
	<thead>
		<tr>
			<th>Código</th>
			<th>Descripción</th>
			<th>Cantidad</th>
			<th class="withTax">Precio</th>
			<th class="withoutTax">Valor</th>
			<th class="">Dscto2(%)</th>
			<th class="withTax">V.Total</th>
			<th class="withoutTax">P.Total</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody id="tableItems">
	@if(isset($model->details))
	@foreach($model->details as $detail)
		@php $categories=[]; @endphp
		<tr>
			{!! Form::hidden("details[$i][DFSECUEN]", $detail->DFSECUEN, ['class'=>'detailId','data-detailId'=>'']) !!}
			{!! Form::hidden("details[$i][DFUNIDAD]", $detail->DFUNIDAD, ['class'=>'unitId','data-unitid'=>'']) !!}
			<td><span class='spanCodigo'>{{ $detail->DFCODIGO }}</span>{!! Form::hidden("details[$i][DFCODIGO]", $detail->DFCODIGO, ['class'=>'productId']); !!}</td>
			<td><span class='spanProduct'>{{ $detail->DFDESCRI }}</span>{!! Form::hidden("details[$i][DFDESCRI]", $detail->DFDESCRI, ['class'=>'txtProduct']); !!}</td>
			<td class="text-center"><span class='spanCantidad'>{{ $detail->DFCANTID + 0 }}</span>{!! Form::hidden("details[$i][DFCANTID]", $detail->DFCANTID + 0, ['class'=>'txtCantidad']) !!}</td>
			<td class="withTax text-right"><span class='spanPrecio'>{{ number_format(round($detail->DFPREC_ORI*1.18, 2), 2, '.', '') }}</span>{!! Form::hidden("details[$i][price]", $detail->DFPREC_ORI*1.18, ['class'=>'txtPrecio']) !!}</td>
			<td class="withoutTax text-right"><span class='spanValue'>{{ $detail->DFPREC_ORI + 0 }}</span>{!! Form::hidden("details[$i][DFPREC_ORI]", $detail->DFPREC_ORI + 0, ['class'=>'txtValue']) !!}</td>
			<td class="text-center"><span class='spanDscto2'>{{ $detail->DFPORDES + 0 }}</span>{!! Form::hidden("details[$i][DFPORDES]", $detail->DFPORDES + 0, ['class'=>'txtDscto2']) !!}</td>
			<td class="withTax text-right"> <span class='txtTotal'>{{ number_format($detail->DFIMPMN/1.18, 2, '.', '') + 0 }}</span> </td>
			<td class="withoutTax text-right"> <span class='txtPriceItem'>{{ number_format($detail->DFIMPMN, 2, '.', '') + 0 }}</span> </td>
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
					<label>Total</label>
					<span id="spanPriceItem" class="form-control-sm form-control-plaintext"></span>
					<input type="hidden" id="txtTotal">
					<input type="hidden" id="txtPriceItem">
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

{!! Form::hidden('category_id', '18') !!}
{!! Form::hidden('is_downloadable', '1') !!}
<div class="form-row mb-3">
	<div class="col-sm-2">
		<div class="custom-control custom-switch">
			{!! Form::checkbox('visible', '1', ((isset($model))? null : '1'), ['class'=>'custom-control-input', 'id'=>'is_visible']) !!}
			<label class="custom-control-label" for="is_visible">Visible</label>
		</div>
	</div>
	<div class="col-sm-2">
		<div class="custom-control custom-switch">
			{!! Form::checkbox('is_downloadable', '1', ((isset($model))? null : '1'), ['class'=>'custom-control-input', 'id'=>'is_downloadable']) !!}
			<label class="custom-control-label" for="is_downloadable">Descargable</label>
		</div>
	</div>
	<div class="col-sm-2 d-none">
		<div class="custom-control custom-switch">
			{!! Form::checkbox('is_variable', '1', null,['class'=>'custom-control-input', 'id'=>'is_variable']) !!}
			<label class="custom-control-label" for="is_variable">Variable</label>
		</div>
	</div>
</div>
<div class="form-row">
	<div class="col-sm-4">
		{!! Field::text('name', ['label' => 'Nombre', 'class'=>'form-control-sm text-uppercase', 'required']) !!}
	</div>
	<div class="col-sm-8">
		{!! Field::text('description', ['label' => 'Descripción', 'class'=>'form-control-sm']) !!}
	</div>
</div>
<div class="form-row">
	<div class="col-sm-2">
		{!! Field::text('intern_code', ['label' => 'Cod Interno', 'class'=>'form-control-sm text-uppercase', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::text('provider_code', ['label' => 'Cod Proveedor', 'class'=>'form-control-sm']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::text('manufacturer_code', ['label' => 'Cod Fabricante', 'class'=>'form-control-sm']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::select('sub_category_id', $sub_categories, ['empty'=>'Seleccionar', 'label'=>'SubCategoría', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::select('unit_id', $units, (isset($model) ? null : '8'), ['empty'=>'Seleccionar', 'label'=>'Unidad', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::select('brand', $brands, ['empty'=>'Seleccionar', 'label'=>'Marca', 'class'=>'form-control-sm']) !!}
	</div>
	@if(1==0)
	<div class="col-sm-2">
		{!! Field::select('country', config('countries'), (isset($model) ? null : 'PE'), ['empty'=>'Seleccionar', 'label'=>'País', 'class'=>'form-control-sm']) !!}
	</div>
	@else
		{!! Form::hidden('country', 'PE') !!}
	@endif
</div>
<div class="form-row">
	<div class="col-sm-2">
		{!! Field::select('currency_id', config('options.table_sunat.moneda'), (isset($model) ? null : '1'), ['empty'=>'Seleccionar', 'label'=>'Moneda', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::number('value_cost', ['label' => 'Valor Costo', 'class'=>'form-control-sm col', 'id'=>'p_value_cost', 'step'=>"0.01"]) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::number('price_cost', ['label' => 'Precio Costo', 'class'=>'form-control-sm col', 'id'=>'p_price_cost', 'step'=>"0.01"]) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::number('value', ['label' => 'Valor Venta', 'class'=>'form-control-sm col', 'id'=>'p_value', 'step'=>"0.01"]) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::number('price', ['label' => 'Precio Venta', 'class'=>'form-control-sm col', 'id'=>'p_price', 'step'=>"0.01"]) !!}
	</div>
</div>

@if(isset($model) or 1==1)
	@include('storage.products.partials.accordion')
@endif

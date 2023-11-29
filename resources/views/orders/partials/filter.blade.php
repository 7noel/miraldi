<div class="form-row">
	<div class="col-sm-2">
		{!! Field::number('sn', ['label'=>'Número Pedido','class'=>'form-control-sm']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::select('seller_id', $sellers, ['empty' => 'Seleccionar', 'label'=>'Vendedor','class'=>'form-control-sm']) !!}
	</div>
	<div class="col-sm-4">
		{!! Form::hidden('company_id', null, ['id'=>'company_id']) !!}
		{!! Field::text('txtCompany', ['label'=>'Cliente','class'=>'form-control-sm']) !!}
	</div>
</div>

<div class="form-row">
	<div class="col-sm-2">
		{!! Field::number('sn', ['label'=>'Número Pedido','class'=>'form-control-sm']) !!}
	</div>
	<div class="col-sm-2">
		<div class="form-group">
			{!! Form::label('seller_id', 'Vendedor', ['class' => 'awesome']) !!}
			{!! Form::select('seller_id', $sellers, null, ['class'=>'form-control form-control-sm']) !!}
		</div>
	</div>
	<div class="col-sm-2">
		<div class="form-group">
			{!! Form::label('status', 'Estado', ['class' => 'awesome']) !!}
			{!! Form::select('status', config('options.order_status'), null, ['class'=>'form-control form-control-sm']) !!}
		</div>
	</div>
	<div class="col-sm-4">
		{!! Form::hidden('company_id', null, ['id'=>'company_id']) !!}
		{!! Field::text('txtCompany', ['label'=>'Cliente','class'=>'form-control-sm']) !!}
	</div>
	<div class="col-sm-2">
		<br>
		{!! Form::checkboxes('por_aprobar', ['1'=>'Solo Pedidos por Aprobar'], ['class'=>'form-control-sm']) !!}
	</div>
</div>

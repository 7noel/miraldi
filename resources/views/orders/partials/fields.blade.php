{!! Form::hidden('with_tax', 0, ['id'=>'with_tax']) !!}
{!! Form::hidden('CFCODCLI', null, ['id'=>'company_id']) !!}
{!! Form::hidden('CFRUC', null, ['id'=>'doc']) !!}
{!! Form::hidden('CFDIRECC', null, ['id'=>'address']) !!}
@if(isset($cambio))
	{!! Form::hidden('CFTIPCAM', $cambio->VENTA) !!}
@else
	{!! Form::hidden('CFTIPCAM', null) !!}
@endif

<div class="form-row">
	<div class="col-md-1 col-sm-2">
		{!! Form::label('sn', 'PD') !!}
		{!! Form::text('CFNUMPED', null,['class'=>'form-control-sm form-control-plaintext text-center', 'readonly']) !!}
	</div>
	<div class="col-sm-4">
		@if(isset($client->id))
		{!! Field::text('CFNOMBRE', $client->company_name, ['label' => 'Cliente', 'class'=>'form-control-sm text-uppercase', 'id'=>'txtCompany', 'required']) !!}
		@else
		{!! Field::text('CFNOMBRE', ((isset($model->company_id)) ? $model->company->company_name : null), ['label' => 'Cliente', 'class'=>'form-control-sm text-uppercase', 'id'=>'txtCompany', 'required', 'autofocus']) !!}
		@endif
	</div>
	<div class="col-sm-1">
		{!! Field::select('CFCODMON', config('options.table_sunat.moneda'), (isset($model) ? null : 'MN'), ['label'=>'Moneda', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-md-2 col-sm-4">
		{!! Field::select('CFVENDE', $sellers, ['empty'=>'Seleccionar', 'label'=>'Vendedor', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-md-2 col-sm-4">
		{!! Field::select('CFFORVEN', $conditions, (isset($model) ? null : '00'), ['empty'=>'Seleccionar', 'label'=>'Condición', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	{{--<div class="col-md-2 col-sm-4">
		{!! Field::number('CFORDCOM', ['label' => 'Nota Venta', 'class'=>'form-control-sm text-uppercase']) !!}
	</div>--}}
	<div class="col-md-1 col-sm-4">
		{!! Field::number('CFPORDESCL', ['label' => 'Descuento', 'class'=>'form-control-sm text-uppercase']) !!}
	</div>
	<div class="col-md-4 col-sm-6">
		{!! Field::text('CFGLOSA', ['label' => 'Comentarios', 'class'=>'form-control-sm text-uppercase']) !!}
	</div>
</div>

@include('orders.partials.details')
	

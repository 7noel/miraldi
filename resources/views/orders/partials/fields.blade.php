{!! Form::hidden('with_tax', 0, ['id'=>'with_tax']) !!}
{!! Form::hidden('CFCODCLI', null, ['id'=>'company_id']) !!}
{!! Form::hidden('COD_TRANSPORTISTA', null, ['id'=>'shipper_id']) !!}
{!! Form::hidden('CFRUC', null, ['id'=>'doc']) !!}
{!! Form::hidden('CFDIRECC', null, ['id'=>'address']) !!}
{!! Form::hidden('CFCOTIZA', null, ['id'=>'CFCOTIZA']) !!}
@if(isset($bloquea_original))
	{!! Form::hidden('bloquea_original', $bloquea_original, ['id'=>'bloquea_original']) !!}
@endif
@if(isset($graba_original))
	{!! Form::hidden('graba_original', $graba_original, ['id'=>'graba_original']) !!}
@endif
@if(isset($cambio))
	{!! Form::hidden('CFTIPCAM', $cambio->VENTA) !!}
@else
	{!! Form::hidden('CFTIPCAM', null) !!}
@endif

@if(isset($model))
	@if(isset($model->original))
		@if($model->original->activated_at)
			<!-- si está activado -->
			<button type="button" class="btn btn-primary btn-sm" title="Pedido Activo" disabled>{!! $icons['check'] !!} Activar</button>
		@else
			<!-- si no está activado -->
			<button type="button" onclick="activarPedido('{{ $model->CFNUMPED }}')" class="btn btn-primary btn-sm" title="Activar Pedido" id="btnActivarPedido">{!! $icons['check'] !!} Activar</button>
		@endif
	@else
		<!-- No se puede activar pedido porque no existe un resgistro en la tabla "original" en mysql -->
		<button type="button" class="btn btn-primary btn-sm" title="Activar Pedido" disabled>{!! $icons['check'] !!} Activarx</button>
	@endif
	<button type="button" onclick="printJS('{{ route( 'orders.print' , $model->CFNUMPED ) }}')" class="btn btn-outline-success btn-sm" title="Imprimir Pedido Almacén">{!! $icons['printer'] !!} Almacén</button>
	<a href="{{ route( 'orders.print_note' , $model->CFNUMPED ) }}" target="_blank" class="btn btn-outline-danger btn-sm" title="PDF Pedidos">{!! $icons['pdf'] !!} Pedido</a>
	@if($model->original)
	<a href="{{ route( 'orders.print_original' , $model->CFNUMPED ) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="PDF Nota Original">{!! $icons['pdf'] !!} Original</a>
	@else
	<a href="#" class="btn btn-outline-info btn-sm" title="PDF Nota Original">{!! $icons['pdf'] !!} Original</a>
	@endif
	<a href="{{ route('orders.create') }}" class="btn btn-outline-primary btn-sm">{!! $icons['add'] !!} Nuevo</a>
	<a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">{!! $icons['list'] !!} Listado</a>
	<br><br>
@endif

<div class="form-row">
	<div class="col-md-1 col-sm-2">
		{!! Form::label('sn', 'PD') !!}
		{!! Form::text('CFNUMPED', null,['class'=>'form-control-sm form-control-plaintext', 'readonly', 'id'=>'CFNUMPED']) !!}
	</div>
	<div class="col-sm-4">
		@if(isset($client->id))
		{!! Field::text('CFNOMBRE', $client->company_name, ['label' => 'Cliente', 'class'=>'form-control-sm text-uppercase', 'id'=>'txtCompany', 'required']) !!}
		@else
		{!! Field::text('CFNOMBRE', null, ['label' => 'Cliente', 'class'=>'form-control-sm text-uppercase', 'id'=>'txtCompany', 'required', 'autofocus']) !!}
		@endif
	</div>
	<div class="col-md-2 col-sm-4">
		<div class="form-group">
			{!! Form::label('CFVENDE', 'Vendedor', ['class' => 'awesome']) !!}
			{!! Form::select('CFVENDE', $sellers, null, ['class'=>'form-control form-control-sm', 'required']) !!}
		</div>
	</div>
	<div class="col-md-2 col-sm-4">
		{!! Field::select('CFFORVEN', $conditions, (isset($model) ? null : '00'), ['empty'=>'Seleccionar', 'label'=>'Condición', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-sm-3">
		{!! Field::text('NOM_TRANSPORTISTA', ((isset($model->COD_TRANSPORTISTA) and $model->COD_TRANSPORTISTA>0) ? $model->shipper->TRANOMBRE : null), ['label' => 'Transportista', 'class'=>'form-control-sm text-uppercase', 'id'=>'txtShipper']) !!}
	</div>
	{{--<div class="col-md-2 col-sm-4">
		{!! Field::number('CFORDCOM', ['label' => 'Nota Venta', 'class'=>'form-control-sm text-uppercase']) !!}
	</div>--}}
	<div class="col-6 col-sm-1">
		{!! Field::select('CFCODMON', config('options.table_sunat.moneda'), (isset($model) ? null : 'MN'), ['label'=>'Moneda', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-6 col-md-1 col-sm-3">
		{!! Field::number('CFPORDESCL', ['label' => 'Descuento 1', 'class'=>'form-control-sm text-uppercase']) !!}
	</div>
	<div class="col-6 col-md-1 col-sm-3">
		<div id="field_discount_2" class="form-group">
			<label for="discount_2">Descuento 2</label>
			<input class="form-control form-control-sm text-uppercase" id="discount_2" name="discount_2" type="number" value="{{ (isset($model->original)) ? $model->original->discount_2 : '0' }}">
		</div>
	</div>
	<div class="col-md-4 col-sm-6">
		<div id="field_comments" class="form-group">
			{!! Field::text('CFGLOSA', ['label' => 'Comentarios', 'class'=>'form-control-sm text-uppercase']) !!}
			{{-- <label for="comments">Comentarios</label>
			<input class="form-control form-control-sm" id="comments" name="comments" type="text" value="{{ (isset($model->original)) ? $model->original->comments : (isset($model) ? $model->CFGLOSA : '') }}"> --}}
		</div>
	</div>
</div>
@if(isset($model))
	@include('orders.partials.details')
@endif

<button type="button" onclick="printJS('{{ route( 'picking.print' , $model->id ) }}')" class="btn btn-sm btn-outline-success mb-3" title="Imprimir Picking">{!! $icons['printer'] !!} Imprimir</button>
<a href="{{ route( 'picking.print' , $model->id ) }}" target="_blank" class="btn btn-sm btn-outline-danger mb-3" title="PDF Picking">{!! $icons['pdf'] !!} PDF</a>
<a href="{{ route('pickings.create') }}" class="btn btn-outline-primary btn-sm mb-3">{!! $icons['add'] !!} Nuevo</a>
<a href="{{ route('pickings.index') }}" class="btn btn-outline-secondary btn-sm mb-3">{!! $icons['list'] !!} Listado</a>
<div class="form-row">
	<div class="col-md-2 col-sm-6">
		{!! Form::label('id', 'id') !!}
		{!! Form::text('id', null, ['class'=>'form-control-sm form-control-plaintext', 'readonly']) !!}
	</div>
	<div class="col-md-2 col-sm-6">
		{!! Form::label('CFNUMPED', 'Pedido') !!}
		{!! Form::text('CFNUMPED', null, ['class'=>'form-control-sm form-control-plaintext', 'readonly']) !!}
	</div>
	<div class="col-md-4 col-sm-12">
		{!! Form::label('cliente', 'Cliente') !!}
		<input type="text" id="cliente" class='form-control-sm form-control-plaintext' value="{{ $model->order->CFNOMBRE }}" readonly>
	</div>
	<div class="col-md-2 col-sm-6">
		{!! Form::label('fecha', 'Fecha y Hora') !!}
		<input type="text" id="fecha" class='form-control-sm form-control-plaintext' value="{{ $model->created_at->format('d/m/Y h:i: a') }}" readonly>
	</div>
	<div class="col-md-2 col-sm-6">
		{!! Form::label('user', 'Usuario') !!}
		<input type="text" id="user" class='form-control-sm form-control-plaintext' value="{{ $model->user->name }}" readonly>
	</div>
</div>

@include('pickings.partials.details')
	

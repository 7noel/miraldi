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

<?php 
$activo = (optional($model->original)->activated_at) ? 1 : 0 ;
$has_original = ($model->original) ? 1 : 0 ;
if ($model->CFCOTIZA=='AUTORIZADO') {
	$clase = 'badge badge-primary';
} elseif ($model->CFCOTIZA=='ATENDIDO') {
	$clase = 'badge badge-success';
} elseif ($model->CFCOTIZA=='ANULADO') {
	$clase = 'badge badge-danger';
} elseif ($model->CFCOTIZA=='RECHAZADO') {
	$clase = 'badge badge-warning';
} elseif ($activo) {
	$clase = 'badge badge-info';
} else {
	$clase = 'badge badge-secondary';
}
 ?>

<div class="form-row">
<div class="col-sm-8 mb-3">
@if(isset($model))


	@if($activo)
	<!-- si está activado -->
	<button type="button" class="btn btn-primary btn-sm" title="Pedido Activo" disabled>{!! $icons['check'] !!} Activar</button>
	@else
		@if($has_original and $action == 'edit')
		<!-- si no está activado -->
		<button type="button" onclick="activarPedido('{{ $model->CFNUMPED }}')" class="btn btn-primary btn-sm" title="Activar Pedido" id="btnActivarPedido">{!! $icons['check'] !!} Activar</button>
		@else
		<!-- No se puede activar pedido porque no existe un resgistro en la tabla "original" en mysql -->
		<button type="button" class="btn btn-primary btn-sm" title="Activar Pedido" disabled>{!! $icons['check'] !!} Activarx</button>
		@endif
	@endif

	<a href="{{ route( 'orders.print' , $model->CFNUMPED ) }}" target="_blank" class="btn btn-outline-success btn-sm" title="Imprimir Pedido Almacén">{!! $icons['printer'] !!} Almacén</a>
	<!-- <button type="button" onclick="printJS('{{ route( 'orders.print' , $model->CFNUMPED ) }}')" class="btn btn-outline-success btn-sm" title="Imprimir Pedido Almacén">{!! $icons['printer'] !!} Almacén</button> -->
	<a href="{{ route( 'orders.print_note' , $model->CFNUMPED ) }}" target="_blank" class="btn btn-outline-danger btn-sm" title="PDF Pedidos">{!! $icons['pdf'] !!} Pedido</a>
	@if($model->original)
	<a href="{{ route( 'orders.print_original' , $model->CFNUMPED ) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="PDF Nota Original">{!! $icons['pdf'] !!} Original</a>
	@else
	<a href="#" class="btn btn-outline-info btn-sm" title="PDF Nota Original">{!! $icons['pdf'] !!} Original</a>
	@endif
	<a href="{{ route('orders.create') }}" class="btn btn-outline-primary btn-sm">{!! $icons['add'] !!} Nuevo</a>
	<a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">{!! $icons['list'] !!} Listado</a>
	<button type="button" class="btn btn-sm btn-link" data-toggle="modal" data-target="#modalHistorial"><i class="fas fa-history mr-1"></i> Historial</button>
@endif
	
</div>
<div class="col-sm-4 mb-3">
	@if($activo)
	<!-- Cambiar de estado cuando el pedido está activo -->
	    <strong>Estado:</strong>
	    <span class="{{ $clase }}" id="estado-badge">
	        {{ $model->CFCOTIZA }}
	    </span>
	    @if($model->CFCOTIZA == 'EMITIDO')
	        <button type="button" class="btn btn-outline-success btn-sm ml-2 btn-estado" data-estado="AUTORIZADO" data-id="{{ $model->CFNUMPED }}">
	            <i class="fas fa-check-circle"></i> AUTORIZAR
	        </button>
	        <button type="button" class="btn btn-outline-danger btn-sm btn-estado" data-estado="RECHAZADO" data-id="{{ $model->CFNUMPED }}">
	            <i class="fas fa-times-circle"></i> RECHAZAR
	        </button>
    	@endif
	@endif
</div>
</div>

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

<!-- Modal Historial -->
<div class="modal fade" id="modalHistorial" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header py-2">
                <h5 class="modal-title">
                    <i class="fas fa-history mr-1"></i>
                    Historial del Pedido
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body p-2">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover mb-0">

                        <thead class="thead-light">
                            <tr>
                                <th style="width: 35%">Evento</th>
                                <th style="width: 35%">Fecha</th>
                                <th style="width: 30%">Usuario</th>
                            </tr>
                        </thead>

                        <tbody>
							{{-- EMITIDO --}}
							@if($model->original->created_at)
							<tr>
							    <td>
							        <span class="badge badge-secondary"><i class="fas fa-file-alt mr-1"></i> EMITIDO </span>
							    </td>
							    <td>
							        {{ \Carbon\Carbon::parse($model->original->created_at)->format('d/m/Y h:i a') }}
							    </td>
							    <td>
							        {{ optional($model->original->createdUser)->name ?? '-' }}
							    </td>
							</tr>
							@endif

                            {{-- ACTIVADO --}}
                            @if($model->original->activated_at)
                            <tr>
                                <td>
                                    <span class="badge badge-info"><i class="fas fa-play mr-1"></i> ACTIVADO </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($model->original->activated_at)->format('d/m/Y h:i a') }}
                                </td>
                                <td>
                                    {{ optional($model->original->activatedUser)->name ?? '-' }}
                                </td>
                            </tr>
                            @endif

							{{-- RECHAZADO --}}
							@if($model->original->rejected_at)
							<tr>
							    <td>
							        <span class="badge badge-warning"><i class="fas fa-times mr-1"></i> RECHAZADO </span>
							    </td>
							    <td>
							        {{ \Carbon\Carbon::parse($model->original->rejected_at)->format('d/m/Y h:i a') }}
							    </td>
							    <td>
							        {{ optional($model->original->rejectedUser)->name ?? '-' }}
							    </td>
							</tr>
							@endif

                            {{-- AUTORIZADO --}}
                            @if($model->original->approved_at)
                            <tr>
                                <td>
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i> AUTORIZADO</span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($model->original->approved_at)->format('d/m/Y h:i a') }}
                                </td>
                                <td>
                                    {{ optional($model->original->approvedUser)->name ?? '-' }}
                                </td>
                            </tr>
                            @endif

                            {{-- IMPRESO --}}
                            @if($model->original->printed_at)
                            <tr>
                                <td>
                                    <span class="badge badge-primary"><i class="fas fa-print mr-1"></i> IMPRESO </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($model->original->printed_at)->format('d/m/Y h:i a') }}
                                </td>
                                <td>
                                    {{ optional($model->original->printedUser)->name ?? '-' }}
                                </td>
                            </tr>
                            @endif

                        </tbody>

                    </table>
                </div>

            </div>

            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

@if(isset($model))
	@include('orders.partials.details')
@endif

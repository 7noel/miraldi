<div class="form-row">
	<div class="col-sm-2 form-group">
		<label for="codigox">Codigo</label>
		<span class="form-control form-control-sm form-control-plaintext" id="codigox">{{ $model->ACODIGO }}</span>
	</div>
	<div class="col-sm-3 form-group">
		<label for="family">Familia</label>
		<span class="form-control form-control-sm form-control-plaintext" id="family">{{ $model->family->FAM_NOMBRE }}</span>
	</div>
	<div class="col-sm-7 form-group">
		<label for="name">Descripción</label>
		<span class="form-control form-control-sm form-control-plaintext" id="name">{{ $model->ADESCRI }}</span>
	</div>
</div>
@if( in_array(\Auth::user()->role_id, [1, 4]) )
<div class="form-row">
	<div class="col-sm-2 form-group">
		<label for="codigox">Moneda</label>
		@php $mnd = (isset($model->price)) ? $model->price->MON_PRE : 'MN' @endphp
		<input type="hidden" value="{{ $mnd }}" name="MON_PRE">
		<span class="form-control form-control-sm form-control-plaintext">{{ $mnd }}</span>
	</div>
	<div class="col-sm-2 form-group">
		<label for="codigox">Costo</label>
		<input class="form-control form-control-sm" id="precio_base" step="0.01" name="PRECIO_BASE" type="number" value="{{ (isset($model->price)) ? round($model->price->PRECIO_BASE,2) : '0' }}">
	</div>
	<div class="col-sm-2 form-group">
		<label for="codigox">Gastos Admin</label>
		<input class="form-control form-control-sm" id="gastos_admin" name="POR_GASTOS_ADMINISTRATIVOS" type="number" value="{{ (isset($model->price)) ? round($model->price->POR_GASTOS_ADMINISTRATIVOS,2) : '30' }}">
		{{-- <span class="form-control form-control-sm form-control-plaintext" id="gastos_admin">{{ round($model->price->POR_GASTOS_ADMINISTRATIVOS) }}</span> --}}
	</div>
	<div class="col-sm-2 form-group">
		<label for="codigox">Utilidad</label>
		<input class="form-control form-control-sm" id="utilidad" name="POR_UTILIDAD" type="number" value="{{ (isset($model->price)) ? round($model->price->POR_UTILIDAD, 2) : '18' }}">
	</div>
	<div class="col-sm-2 form-group">
		<label for="codigox">Precio (sin igv)</label>
		<span class="form-control form-control-sm form-control-plaintext" id="precio">{{ (isset($model->price)) ? round($model->price->PRE_ACT, 2) : '0' }}</span>
	</div>
</div>
@endif
<div class="form-row">
	<div class="col-sm-2">
		{!! Field::text('ACODIGO2', ['label' => 'Código Fabricante', 'class'=>'form-control-sm text-uppercase']) !!}
	</div>
	@if(isset($model->stock))
	<div class="col-sm-1 form-group">
		<label for="codigox">Stock 01</label>
		<span class="form-control form-control-sm form-control-plaintext" id="codigox">{{ (isset($model->stock)) ? round($model->stock->STSKDIS, 2) : 0 }}</span>
	</div>
	<div class="col-sm-9">
		{!! Field::text('TCASILLERO', ['label' => 'Ubicación 01', 'class'=>'form-control-sm text-uppercase']) !!}
	</div>
	@else
	<div class="col-sm-10">
		<label for="codigox">Stock y Ubicación</label>
		<h5><span class="badge badge-danger">Necesita agregar Stock en el STARSOFT</span></h5>
	</div>
	@endif
</div>
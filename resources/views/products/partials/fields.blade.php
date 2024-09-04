<div class="form-row">
	<div class="col-sm-2 form-group">
		<label for="codigox">Codigo</label>
		<span class="form-control form-control-sm form-control-plaintext" id="codigox">{{ $model->ACODIGO }}</span>
	</div>
	<div class="col-sm-2 form-group">
		<label for="family">Familia</label>
		<span class="form-control form-control-sm form-control-plaintext" id="family">{{ $model->family->FAM_NOMBRE }}</span>
	</div>
	<div class="col-sm-8 form-group">
		<label for="name">Descripción</label>
		<span class="form-control form-control-sm form-control-plaintext" id="name">{{ $model->ADESCRI }}</span>
	</div>
</div>
<div class="form-row">
	<div class="col-sm-2 form-group">
		<label for="codigox">Moneda</label>
		<span class="form-control form-control-sm form-control-plaintext">{{ $model->price->MON_PRE }}</span>
	</div>
	<div class="col-sm-2 form-group">
		<label for="codigox">Costo</label>
		<input class="form-control form-control-sm" id="precio_base" name="PRECIO_BASE" type="number" value="{{ round($model->price->PRECIO_BASE,2) }}">
	</div>
	<div class="col-sm-2 form-group">
		<label for="codigox">Gastos Admin</label>
		<span class="form-control form-control-sm form-control-plaintext" id="gastos_admin">{{ round($model->price->POR_GASTOS_ADMINISTRATIVOS) }}</span>
	</div>
	<div class="col-sm-2 form-group">
		<label for="codigox">Utilidad</label>
		<input class="form-control form-control-sm" id="utilidad" name="POR_UTILIDAD" type="number" value="{{ round($model->price->POR_UTILIDAD, 2) }}">
	</div>
	<div class="col-sm-2 form-group">
		<label for="codigox">Precio (sin igv)</label>
		<span class="form-control form-control-sm form-control-plaintext">{{ $model->price->PRE_ACT }}</span>
	</div>
</div>
<div class="form-row">
	<div class="col-sm-2">
		{!! Field::text('ACODIGO2', ['label' => 'Código Fabricante', 'class'=>'form-control-sm text-uppercase']) !!}
	</div>
</div>
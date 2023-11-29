<div class="form-row">
	<div class="col-sm-2">
		{!! Field::select('CTIPO_DOCUMENTO', config('options.client_doc'), ['empty'=>'Seleccionar', 'label' => 'Tipo', 'class'=>'form-control-sm', 'id'=>'id_type', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::text('CCODCLI', ['label' => 'Número doc', 'class'=>'form-control-sm text-uppercase', 'id'=>'doc', 'required']) !!}
	</div>
	<div class="col-sm-4">
		{!! Field::text('CNOMCLI', ['label' => 'Razón Social', 'class'=>'form-control-sm text-uppercase', 'id'=>'company_name', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::text('CAPELLIDO_PATERNO', ['label' => 'Ap Paterno', 'class'=>'form-control-sm text-uppercase', 'id'=>'paternal_surname', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::text('CAPELLIDO_MATERNO', ['label' => 'Ap Materno', 'class'=>'form-control-sm text-uppercase', 'id'=>'maternal_surname']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::text('CPRIMER_NOMBRE', ['label' => 'Nombre', 'class'=>'form-control-sm text-uppercase', 'id'=>'name', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::select('DEPARTAMENTO', $ubigeo['departamento'], $ubigeo['value']['departamento'], ['empty'=>'Seleccionar', 'label'=>'Departamento', 'class'=>'form-control-sm', 'id'=>'departamento', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::select('PROVINCIA', $ubigeo['provincia'], $ubigeo['value']['provincia'], ['empty'=>'Seleccionar', 'label'=>'Provincia', 'class'=>'form-control-sm', 'id'=>'provincia', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::select('UBIGEO', $ubigeo['distrito'], $ubigeo['value']['distrito'], ['empty'=>'Seleccionar', 'label'=>'Distrito', 'class'=>'form-control-sm', 'id'=>'ubigeo_code', 'required']) !!}
	</div>
	<div class="col-sm-4">
		{!! Field::text('CDIRCLI', ['label' => 'Dirección', 'class'=>'form-control-sm text-uppercase', 'id'=>'address', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::text('CTELEFO', ['label' => 'Celular', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::email('CEMAIL', ['label' => 'Email', 'class'=>'form-control-sm']) !!}
	</div>
</div>

<div class="form-row">
	<div class="col-sm-4">
		{!! Field::text('name', ['label' => 'Nombre', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-sm-8">
		{!! Field::text('address', ['label' => 'Dirección', 'class'=>'form-control-sm', 'required']) !!}
	</div>
</div>
<div class="form-row">
	<div class="col-sm-4">
		{!! Field::select('departamento', $ubigeo['departamento'], $ubigeo['value']['departamento'], ['empty'=>'Seleccionar', 'label'=>'Departamento', 'class'=>'form-control-sm', 'required' ,'id'=>'lstDepartamento']) !!}
		
	</div>
	<div class="col-sm-4">
		{!! Field::select('provincia', $ubigeo['provincia'], $ubigeo['value']['provincia'], ['empty'=>'Seleccionar', 'label'=>'Provincia', 'class'=>'form-control-sm', 'required' ,'id'=>'lstProvincia']) !!}
		
	</div>
	<div class="col-sm-4">
		{!! Field::select('ubigeo_code', $ubigeo['distrito'], $ubigeo['value']['distrito'], ['empty'=>'Seleccionar', 'label'=>'Distrito', 'class'=>'form-control-sm', 'required' ,'id'=>'lstDistrito']) !!}
		
	</div>
</div>
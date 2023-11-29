<div class="form-row">
	<div class="col-sm-6">
		{!! Field::text('name', ['label' => 'Nombre', 'class'=>'form-control-sm', 'required'=>'required']) !!}
	</div>
	<div class="col-sm-3">
		{!! Field::select('permission_group_id', $groups, ['label' => 'Grupo', 'class'=>'form-control-sm', 'required'=>'required']) !!}
	</div>
	<div class="col-sm-3">
		{!! Field::text('action', ['label' => 'Acción', 'class'=>'form-control-sm', 'required'=>'required']) !!}
	</div>
</div>
<div class="form-row">
</div>
<div class="form-row">
	<div class="col-sm-6">
		{!! Field::text('description', ['label' => 'Descripción', 'class'=>'form-control-sm']) !!}
	</div>
	<div class="col-sm-6">
		<label class='col-sm-2 control-label'> .</label>
		<div class="checkbox">
			<label>
				{!! Form::checkbox('generate', null); !!}
				Generar Permisos para Listar, Ver, Crear, Editar y Eliminar
			</label>
		</div>
	</div>
</div>
<div class="form-row">
</div>
<div class="form-row">
</div>
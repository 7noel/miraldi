<div class="form-row">
	<div class="col-sm-4">
		{!! Field::text('name', ['label' => 'Nombre', 'class'=>'form-control-sm text-uppercase', 'required'=>'required']) !!}
	</div>
	<div class="col-sm-4">
		{!! Field::email('email', ['label' => 'Correo Electrónico', 'class'=>'form-control-sm', 'required'=>'required']) !!}
	</div>
	<div class="col-sm-4">
		{!! Field::password('password', ['label' => 'Contraseña', 'class'=>'form-control-sm']) !!}
	</div>
	<div class="col-md-2 col-sm-4">
		{!! Field::select('role_id', $roles, ['empty'=>'Seleccionar', 'label'=>'Rol', 'class'=>'form-control-sm', 'required']) !!}
	</div>
	<div class="col-md-2 col-sm-4">
		{!! Field::select('user_code', $users, ['empty'=>'Seleccionar', 'label'=>'Usuario Starsoft', 'class'=>'form-control-sm', 'required']) !!}
	</div>
</div>
<div class="form-row">
	<div class="col-sm-6">
		{!! Field::text('name', ['label' => 'Nombre', 'class'=>'form-control-sm', 'required'=>'required']) !!}
	</div>
	<div class="col-sm-6">
		{!! Field::text('description', ['label' => 'Descripción', 'class'=>'form-control-sm']) !!}
	</div>
</div>

<div class="form-row">
	<label>Seleccionar los permisos</label>
</div>
<div class="form-row">
	@php $mps = \Auth()->user()->getMyPermissions()->pluck('id')->all(); @endphp

	@foreach($groups as $group)
	<div class="col-sm-2 group_{{ $group->id }}">
		<h6>{{ $group->name }}</h6>
		{!! Form::checkboxes('permissions', $group->permissions->pluck('name','id'), $mps) !!}
	</div>
	@endforeach
</div>

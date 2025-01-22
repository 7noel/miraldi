{!! Form::hidden('TRATIPO_DOCUMENTO', 6, ['id'=>'id_type']) !!}
<div class="form-row">
	<div class="col-sm-2">
		{!! Field::text('TRACODIGO', ['label' => 'RUC', 'class'=>'form-control-sm text-uppercase', 'id'=>'doc', 'required']) !!}
	</div>
	<div class="col-sm-4">
		{!! Field::text('TRARAZEMP', ['label' => 'Razón Social', 'class'=>'form-control-sm text-uppercase', 'id'=>'company_name', 'maxlength'=>'50', 'required']) !!}
	</div>
	<div class="col-sm-4">
		{!! Field::text('TRADIREMP', ['label' => 'Dirección', 'class'=>'form-control-sm text-uppercase', 'id'=>'address', 'maxlength'=>'100', 'required']) !!}
	</div>
	<div class="col-sm-2">
		{!! Field::text('TRATELEMP', ['label' => 'Celular', 'class'=>'form-control-sm']) !!}
	</div>
</div>

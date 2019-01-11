					<div class="form-group form-group-sm">
						{!! Form::label('doc','Documento', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							<div class="form-inline">
							{!! Form::select('id_type_id',$id_types , null, ['class'=>'form-control col-sm-1', 'id'=>'listDoc', 'required']) !!}
							{!! Form::text('doc', null, ['class'=>'form-control uppercase', 'id'=>'doc', 'required']) !!}
							</div>
						</div>
						{!! Form::label('country_id','País', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::select('country_id', $countries, (isset($model) ? $model->country_id: 1465), ['class'=>'form-control', 'id'=>'lstCountry', 'required'=>'required']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm div_ruc">
						{!! Form::label('company_name','Razón Social', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::text('company_name', null, ['id'=>'company_name', 'class'=>'form-control uppercase']) !!}
						</div>
						{!! Form::label('brand_name','Nombre Comercial', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::text('brand_name', null, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm div_dni">
						{!! Form::label('name','Nombre Completo', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::text('paternal_surname', null, ['class'=>'form-control uppercase', 'placeholder'=>'Apellido Paterno']) !!}
						</div>
						<div class="col-sm-3">
							{!! Form::text('maternal_surname', null, ['class'=>'form-control uppercase', 'placeholder'=>'Apellido Materno']) !!}
						</div>
						<div class="col-sm-3">
							{!! Form::text('name', null, ['class'=>'form-control uppercase', 'placeholder'=>'Nombre']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm" id="div-ubigeo">
						{!! Form::label('ubigeo_id','Distrito', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
								{!! Form::select('departamento',$ubigeo['departamento'],$ubigeo['value']['departamento'],['class'=>'form-control','id'=>'lstDepartamento','required'=>'required']) !!}
						</div>
						<div class="col-sm-3">
								{!! Form::select('provincia',$ubigeo['provincia'],$ubigeo['value']['provincia'],['class'=>'form-control','id'=>'lstProvincia','required'=>'required']) !!}
						</div>
						<div class="col-sm-3">
								{!! Form::select('ubigeo_id',$ubigeo['distrito'],$ubigeo['value']['distrito'],['class'=>'form-control','id'=>'lstDistrito','required'=>'required']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('address','Direccion', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-10">
						{!! Form::text('address', null, ['id'=>'address', 'class'=>'form-control uppercase', 'required']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('phone','Telefono Fijo', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
						{!! Form::text('phone', null, ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('mobilephone','Celulares', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
						{!! Form::text('mobilephone', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('email','Email', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
						{!! Form::text('email', null, ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('birth','Nacimiento', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
						{!! Form::date('birth', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('bank_bcp','Cuenta BCP', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
						{!! Form::text('bank_bcp', null, ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('bank_other','Otra Cuenta', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
						{!! Form::text('bank_other', null, ['class'=>'form-control']) !!}
						</div>
					</div>

						<a href="#" id="btnAddBranch" class="btn btn-success btn-sm" title="Agregar Sucursal">{!! config('options.icons.add') !!} Agregar Sucursal</a>
						@php $i=0; @endphp
						<div class="table-responsive">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-2">Sucursal</th>
									<th class="col-sm-3">Dirección</th>
									<th class="col-sm-3">Distrito</th>
									<th class="col-sm-2">Celular</th>
									<th class="col-sm-2">Contacto</th>
									<th class="col-sm-1">Acciones</th>
								</tr>
							</thead>
							<tbody id="tableItems">
							@if(isset($model->branches))
							@foreach($model->branches as $branch)
								<tr data-id="{{ $branch->id }}">
									{!! Form::hidden("branches[$i][id]", $branch->id, ['class'=>'branchId','data-branchId'=>'']) !!}
									{!! Form::hidden("branches[$i][ubigeo_id]", $branch->ubigeo_id, ['class'=>'ubigeoId','data-ubigeoId'=>'']) !!}

<td>{!! Form::text("branches[$i][name]", null, ['class'=>'form-control input-sm txtName uppercase', 'data-name'=>'', 'required'=>'required']) !!}</td>
<td>{!! Form::text("branches[$i][address]", null, ['class'=>'form-control input-sm txtAddress uppercase', 'data-address'=>'']) !!}</td>
<td>{!! Form::text("branches[$i][ubigeo]", $branch->ubigeo->departamento.'-'.$branch->ubigeo->provincia.'-'.$branch->ubigeo->distrito, ['class'=>'form-control input-sm txtUbigeo', 'data-ubigeo'=>'']) !!}</td>
<td>{!! Form::text("branches[$i][mobile]", null, ['class'=>'form-control input-sm txtMobile', 'data-mobile'=>'']) !!}</td>
<td>{!! Form::text("branches[$i][contact]", null, ['class'=>'form-control input-sm txtContact uppercase', 'data-contact'=>'']) !!}</td>
									<td class="text-center form-inline">
										<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
										<input type="checkbox" name="branches[{{$i}}][is_deleted]" data-isdeleted class="isdeleted hidden">
									</td>
								</tr>
								@php $i++; @endphp
							@endforeach
							@endif
							</tbody>
						</table>
						</div>
						<template id="template-row-item">
							<tr>
								{!! Form::hidden('data1', null, ['class'=>'branchId','data-branchId'=>'']) !!}
								{!! Form::hidden('data2', null, ['class'=>'ubigeoId','data-ubigeoId'=>'']) !!}
								<td>{!! Form::text('data3', null, ['class'=>'form-control input-sm txtName uppercase', 'data-name'=>'', 'required'=>'required']) !!}</td>
								<td>{!! Form::text('data4', null, ['class'=>'form-control input-sm txtAddress uppercase', 'data-address'=>'']) !!}</td>
								<td>{!! Form::text('data5', null, ['class'=>'form-control input-sm txtUbigeo', 'data-ubigeo'=>'']) !!}</td>
								<td>{!! Form::text('data7', null, ['class'=>'form-control input-sm txtMobile', 'data-mobile'=>'']) !!}</td>
								<td>{!! Form::text('data6', null, ['class'=>'form-control input-sm txtContact uppercase', 'data-contact'=>'']) !!}</td>
								<td class="text-center form-inline">
									<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
									<input type="checkbox" name="data8" data-isdeleted class="isdeleted hidden">
								</td>
							</tr>
						</template>
						{!! Form::hidden('items', $i, ['id'=>'items']) !!}
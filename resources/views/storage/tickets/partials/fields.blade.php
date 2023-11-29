					<div class="form-group form-group-sm">
						{!! Form::label('txtcompany','Compañía:', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							@if(isset($company))
								{!! Form::hidden('company_id', $company->id, ['id'=>'company_id']) !!}
								{!! Form::text('company', $company->company_name, ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@else
								{!! Form::hidden('company_id', null, ['id'=>'company_id']) !!}
								{!! Form::text('company', ((isset($model->company_id)) ? $model->company->company_name : null), ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@endif
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('warehouse_id','Almacén', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('warehouse_id', $warehouses, null, ['class'=>'form-control', 'id'=>'lstWarehouse']); !!}
						</div>
						{!! Form::label('type_op','Tipo de Operación', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('type_op', $types, null, ['class'=>'form-control', 'id'=>'lstTypeOp']); !!}
						</div>
						{!! Form::label('mov','Tipo de Movimiento', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('mov', config('options.mov'), null, ['class'=>'form-control', 'id'=>'lstMov']); !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('description','Descripción', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-10">
						{!! Form::text('description', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					@include('storage.tickets.partials.details')
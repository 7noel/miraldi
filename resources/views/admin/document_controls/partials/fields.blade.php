					<div class="form-group  form-group-sm">
						{!! Form::label('company_id','Empresa', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::select('company_id', $myCompanies, ((isset($model)) ? $model->company_id : null),['class'=>'form-control', 'id'=>'lstCompany']); !!}
						</div>
					</div>
					<div class="form-group  form-group-sm">
						{!! Form::label('document_type_id','Documento', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('document_type_id', $documents, ((isset($model)) ? $model->document_type_id : null),['class'=>'form-control', 'id'=>'lstCompany']); !!}
						</div>
						{!! Form::label('series','Serie', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-1">
						{!! Form::text('series', null, ['class'=>'form-control uppercase']) !!}
						</div>
						{!! Form::label('number','Número', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('number', null, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
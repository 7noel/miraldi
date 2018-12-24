					{!! Form::hidden('is_output', 1, ['id'=>'proof_type']) !!}

					<div class="form-group form-group-sm">
						<div class="col-sm-2">
							{!! Form::label('my_company','Mi Empresa:', ['class'=>'control-label']) !!}
							@if(!isset($proof))
							{!! Form::select('my_company', $my_companies, $proof->my_company, ['class'=>'form-control']) !!}
							@else
							{!! Form::select('my_company', $my_companies, (isset($model->my_company) ? $model->my_company : session('my_company')->id), ['class'=>'form-control']) !!}
							@endif
						</div>
						<div class="col-sm-4">
							{!! Form::label('txtcompany','Compañía:', ['class'=>'control-label']) !!}
							@if(isset($company))
								{!! Form::hidden('company_id', $company->id, ['id'=>'company_id']) !!}
								{!! Form::text('company', $company->company_name, ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@else
								{!! Form::hidden('company_id', ((isset($model->company_id)) ? $model->company_id : null), ['id'=>'company_id']) !!}
								{!! Form::text('company', ((isset($model->company_id)) ? $model->company->company_name : null), ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@endif
						</div>
						<div class="col-sm-2">
							{!! Form::label('currency_id','Moneda', ['class'=>'control-label']) !!}
							@if(isset($proof))
							{!! Form::select('currency_id', $currencies, $proof->currency_id, ['class'=>'form-control']) !!}
							@else
							{!! Form::select('currency_id', $currencies, ((isset($model)) ? $model->currency_id : '1'), ['class'=>'form-control']) !!}
							@endif
						</div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-sm-2">
							{!! Form::label('items','Cantidad de Letras', ['class'=>'control-label']) !!}
							{!! Form::number('items', null, ['class'=>'form-control col-sm-2']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('amount_proofs','Monto Doc', ['class'=>'control-label']) !!}
							{!! Form::number('amount_proofs', null, ['class'=>'form-control col-sm-2']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('amount_letters','Monto Let', ['class'=>'control-label']) !!}
							{!! Form::number('amount_letters', null, ['class'=>'form-control col-sm-2']) !!}
						</div>
					</div>

					@include('finances.issuance_swaps.partials.details')
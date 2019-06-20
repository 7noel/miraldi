					{!! Form::hidden('proof_type', $proof_type, ['id'=>'proof_type']) !!}
					{!! Form::hidden('sunat_transaction', $sunat_transaction, ['class'=>'form-control']) !!}
					{!! Form::hidden('igv_code', 1, ['class'=>'form-control']) !!}
					<?php //dd($order_id); ?>
					@if(isset($order_id))
					{!! Form::hidden('order_id', $order_id, ['class'=>'form-control']) !!}
					@endif

					<div class="form-group form-group-sm">
						<div class="col-sm-4">
						{!! Form::label('txtcompany','Compañía:', ['class'=>'control-label']) !!}
							@if(isset($company))
								{!! Form::hidden('with_tax', 0, ['id'=>'with_tax']) !!}
								{!! Form::hidden('company_id', $company->id, ['id'=>'company_id']) !!}
								{!! Form::hidden('company_doc', $company->id_type_id, ['id'=>'company_doc']) !!}
								{!! Form::hidden('is_import', 0, ['id'=>'is_import']) !!}
								{!! Form::text('company', $company->company_name, ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@else
								{!! Form::hidden('with_tax', ((isset($model->with_tax)) ? $model->with_tax : null), ['id'=>'with_tax']) !!}
								{!! Form::hidden('company_id', ((isset($model->company_id)) ? $model->company_id : null), ['id'=>'company_id']) !!}
								{!! Form::hidden('company_doc', (isset($model) ? $model->company->id_type_id : null), ['id'=>'company_doc']) !!}
								{!! Form::hidden('is_import', null, ['id'=>'is_import']) !!}
								{!! Form::text('company', ((isset($model->company_id)) ? $model->company->company_name : null), ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@endif
						</div>
						<div class="col-sm-2">
							{!! Form::label('seller_id','Vendedor:', ['class'=>'control-label']) !!}
							{!! Form::select('seller_id', $sellers , ((isset($model->seller_id)) ? $model->seller_id : null), ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('currency_id','Moneda', ['class'=>'control-label']) !!}
							{!! Form::select('currency_id',$currencies , ((isset($model)) ? $model->currency_id : '1'), ['class'=>'form-control', (isset($model)) ? 'disabled' : '']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('exchange','Cambio (US$)', ['class'=>'control-label']) !!}
							{!! Form::text('exchange', ((isset($model)) ? $model->exchange : '2'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-sm-2">
							{!! Form::label('issued_at','Fecha', ['class'=>'control-label']) !!}
							{!! Form::date('issued_at', ((isset($model)) ? $model->issued_at : date('Y-m-d')), ['class'=>'form-control col-sm-2']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('document_type_id','Documento', ['class'=>'control-label']) !!}
							{!! Form::select('document_type_id',$document_types , null, ['class'=>'form-control col-sm-1']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('sn','Numero', ['class'=>'control-label']) !!}
							{!! Form::text('sn', null, ['class'=>'form-control uppercase', 'placeholder'=>'Número', 'readonly'=>'readonly']) !!}
						</div>
						{!! Form::hidden('reference_id', null) !!}
						<div class="col-sm-2">
							{!! Form::label('reference_number','Referencia', ['class'=>'control-label']) !!}
							{!! Form::text('reference_number', ((isset($model->reference)) ? $model->reference->number : ''), ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('note_type_id','Motivo de Nota', ['class'=>'control-label']) !!}
							{!! Form::select('note_type_id', config('options.table_sunat.tipo_de_nota_de_credito') , ((isset($model->note_type_id)) ? $model->note_type_id : ''), ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2 isImport">
						{!! Form::label('dispatch_note_date','Fecha Guía', ['class'=>'control-label']) !!}
							{!! Form::date('dispatch_note_date', null, ['class'=>'form-control col-sm-2']) !!}
						</div>
						<div class="col-sm-2 isImport">
						{!! Form::label('dispatch_note_number','Numero Guía', ['class'=>'control-label']) !!}
							{!! Form::text('dispatch_note_number', null, ['class'=>'form-control uppercase', 'placeholder'=>'Número Guía']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-sm-2">
							{!! Form::label('payment_condition_id', 'Condición de Pago', ['class'=>'control-label']) !!}
							{!! Form::select('payment_condition_id', $payment_conditions , ((isset($model)) ? $model->payment_condition_id : '1'), ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2 due_date">
							{!! Form::label('due_date', 'Vencimiento', ['class'=>'control-label due_date']) !!}
							{!! Form::date('due_date', ((isset($model)) ? $model->due_date : null), ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('my_company','Mi Empresa:', ['class'=>'control-label']) !!}
							{!! Form::select('my_company', $my_companies, (isset($model->my_company) ? $model->my_company : session('my_company')->id), ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2">
							<label class="checkbox-inline">
								{!! Form::checkbox('send_sunat', '1', null,['class'=>'checkbox']) !!} Enviar a SUNAT
							</label>
						</div>
					</div>
					@include('finances.issuance_vouchers.partials.details')
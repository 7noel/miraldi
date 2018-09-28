					{!! Form::hidden('is_proof', $is_proof, ['id'=>'is_proof']) !!}
					{!! Form::hidden('is_issuance', $is_issuance, ['id'=>'is_issuance']) !!}
					{!! Form::hidden('sunat_transaction', $sunat_transaction, ['class'=>'form-control']) !!}
					{!! Form::hidden('igv_code', 1, ['class'=>'form-control']) !!}

					<div class="form-group form-group-sm">
						<div class="col-sm-2">
							{!! Form::label('my_company','Mi Empresa:', ['class'=>'control-label']) !!}
							{!! Form::select('my_company', $my_companies, null, ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2">
							<label class="checkbox-inline">
								{!! Form::checkbox('send_sunat', '1', null,['class'=>'checkbox']) !!} Enviar a SUNAT
							</label>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-sm-4">
						{!! Form::label('txtcompany','Compañía:', ['class'=>'control-label']) !!}
							@if(isset($company))
								{!! Form::hidden('with_tax', 0, ['id'=>'with_tax']) !!}
								{!! Form::hidden('company_id', $company->id, ['id'=>'company_id']) !!}
								@if($is_issuance == 0 and $is_proof == 1)
								{!! Form::hidden('is_import', (($company->country_id==1465) ? 0 : 1), ['id'=>'is_import']) !!}
								else
								{!! Form::hidden('is_import', null, ['id'=>'is_import']) !!}
								@endif
								{!! Form::text('company', $company->company_name, ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@else
								{!! Form::hidden('with_tax', null, ['id'=>'with_tax']) !!}
								{!! Form::hidden('company_id', null, ['id'=>'company_id']) !!}
								{!! Form::hidden('is_import', null, ['id'=>'is_import']) !!}
								{!! Form::text('company', ((isset($model->company_id)) ? $model->company->company_name : null), ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@endif
						</div>
						<div class="col-sm-2">
						{!! Form::label('seller_id','Vendedor:', ['class'=>'control-label']) !!}
						{!! Form::label('dam','DAM:', ['class'=>'col-sm-2 control-label isImport']) !!}
							{!! Form::text('dam', null, ['class'=>'form-control uppercase isImport', 'placeholder'=>'DAM']) !!}
							{!! Form::select('seller_id',$sellers , null, ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2">
						{!! Form::label('currency_id','Moneda', ['class'=>'control-label']) !!}
							{!! Form::select('currency_id',$currencies , ((isset($model)) ? $model->currency_id : '2'), ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2">
						{!! Form::label('exchange','Cambio (US$)', ['class'=>'control-label']) !!}
							{!! Form::text('exchange', null, ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('exchange2','Tipo de Cambio (€)', ['class'=>'col-sm-2 control-label isImport']) !!}
						<div class="col-sm-2">
							{!! Form::text('exchange2', null, ['class'=>'form-control col-sm-2 isImport']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-sm-2">
						{!! Form::label('date','Fecha', ['class'=>'control-label']) !!}
							{!! Form::date('date', null, ['class'=>'form-control col-sm-2']) !!}
						</div>
						<div class="col-sm-2">
						{!! Form::label('document_type_id','Documento', ['class'=>'control-label']) !!}
							{!! Form::select('document_type_id',$document_types , null, ['class'=>'form-control col-sm-1']) !!}
						</div>
						<div class="col-sm-2">
						{!! Form::label('number','Numero', ['class'=>'control-label']) !!}
							{!! Form::text('number', null, ['class'=>'form-control uppercase', 'placeholder'=>'Número']) !!}
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
					</div>
					<div class="form-group form-group-sm isImport">
						{!! Form::label('dispatch_note_date','Fecha Guía', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::date('dispatch_note_date', null, ['class'=>'form-control col-sm-2']) !!}
						</div>
						{!! Form::label('dispatch_note_number','Numero Guía', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::text('dispatch_note_number', null, ['class'=>'form-control uppercase', 'placeholder'=>'Número Guía']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-sm-2">
						{!! Form::label('payment_condition_id','Condición de Pago', ['class'=>'control-label']) !!}
							{!! Form::select('payment_condition_id',$payment_conditions , 1, ['class'=>'form-control']) !!}
						</div>
						<div class="col-sm-2 due_date">
						{!! Form::label('due_date','Vencimiento', ['class'=>'control-label due_date']) !!}
							{!! Form::date('due_date', null, ['class'=>'form-control']) !!}
						</div>
					</div>


					<div class="expenses isImport">
					</div>
					<template id="expenses">
						<div class="form-group form-group-sm">
							{!! Form::label('expenses[0][value]','Gastos FOB', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
								<div class="input-group">
									{!! Form::hidden('expenses[0][id]', ((isset($model->expenses[0])) ? $model->expenses[0]['id'] : '')) !!}
									{!! Form::hidden('expenses[0][name]', 'fob') !!}
									{!! Form::hidden('expenses[0][currency_id]', ((isset($model->expenses[0]['currency_id'])) ? $model->expenses[0]['currency_id'] : '2'), ['class' => 'currency', 'id'=>'c1']) !!}
									<a href="#" class="input-group-addon btn labelCurrency">{{ ((isset($model->expenses[0]['currency_id'])) ? $model->expenses[0]['value'] : '$') }}</a>
									{!! Form::text('expenses[0][value]', ((isset($model->expenses[0]['value'])) ? $model->expenses[0]['value'] : 0.00), ['class'=>'form-control expense text-right', 'id'=>'e1']) !!}
								</div>
							</div>
							{!! Form::label('expenses[1][value]','Flete', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
								<div class="input-group">
									{!! Form::hidden('expenses[1][id]', ((isset($model->expenses[1])) ? $model->expenses[1]['id'] : '')) !!}
									{!! Form::hidden('expenses[1][name]', 'flete') !!}
									{!! Form::hidden('expenses[1][currency_id]', ((isset($model->expenses[1]['currency_id'])) ? $model->expenses[1]['currency_id'] : '2'), ['class' => 'currency', 'id'=>'c2']) !!}
									<a href="#" class="input-group-addon btn labelCurrency">{{ ((isset($model->expenses[1]['currency_id'])) ? $model->expenses[1]['value'] : '$') }}</a>
									{!! Form::text('expenses[1][value]', ((isset($model->expenses[1]['value'])) ? $model->expenses[1]['value'] : 0.00), ['class'=>'form-control expense text-right', 'id'=>'e2']) !!}
								</div>
							</div>
							{!! Form::label('expenses[2][value]','Seguro', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
								<div class="input-group">
									{!! Form::hidden('expenses[2][id]', ((isset($model->expenses[2])) ? $model->expenses[2]['id'] : '')) !!}
									{!! Form::hidden('expenses[2][name]', 'seguro') !!}
									{!! Form::hidden('expenses[2][currency_id]', ((isset($model->expenses[2]['currency_id'])) ? $model->expenses[2]['currency_id'] : '2'), ['class' => 'currency', 'id'=>'c3']) !!}
									<a href="#" class="input-group-addon btn labelCurrency">{{ ((isset($model->expenses[2]['currency_id'])) ? $model->expenses[2]['value'] : '$') }}</a>
									{!! Form::text('expenses[2][value]', ((isset($model->expenses[2]['value'])) ? $model->expenses[2]['value'] : 0.00), ['class'=>'form-control expense text-right', 'id'=>'e3']) !!}
								</div>
							</div>
						</div>
						<div class="form-group form-group-sm">
							{!! Form::label('expenses[3][value]','Ad Valorem', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
								<div class="input-group">
									{!! Form::hidden('expenses[3][id]', ((isset($model->expenses[3])) ? $model->expenses[3]['id'] : '')) !!}
									{!! Form::hidden('expenses[3][name]', 'advalorem') !!}
									{!! Form::hidden('expenses[3][currency_id]', ((isset($model->expenses[3]['currency_id'])) ? $model->expenses[3]['currency_id'] : '2'), ['class' => 'currency', 'id'=>'c4']) !!}
									<a href="#" class="input-group-addon btn labelCurrency">{{ ((isset($model->expenses[3]['currency_id'])) ? $model->expenses[3]['value'] : '$') }}</a>
									{!! Form::text('expenses[3][value]', ((isset($model->expenses[3]['value'])) ? $model->expenses[3]['value'] : 0.00), ['class'=>'form-control expense text-right', 'id'=>'e4']) !!}
								</div>
							</div>
							{!! Form::label('expenses[4][value]','Handling', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
								<div class="input-group">
									{!! Form::hidden('expenses[4][id]', ((isset($model->expenses[4])) ? $model->expenses[4]['id'] : '')) !!}
									{!! Form::hidden('expenses[4][name]', 'handling') !!}
									{!! Form::hidden('expenses[4][currency_id]', ((isset($model->expenses[4]['currency_id'])) ? $model->expenses[4]['currency_id'] : '2'), ['class' => 'currency', 'id'=>'c5']) !!}
									<a href="#" class="input-group-addon btn labelCurrency">{{ ((isset($model->expenses[4]['currency_id'])) ? $model->expenses[4]['value'] : '$') }}</a>
									{!! Form::text('expenses[4][value]', ((isset($model->expenses[4]['value'])) ? $model->expenses[4]['value'] : 0.00), ['class'=>'form-control expense text-right', 'id'=>'e5']) !!}
								</div>
							</div>
							{!! Form::label('expenses[5][value]','Almacen', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
								<div class="input-group">
									{!! Form::hidden('expenses[5][id]', ((isset($model->expenses[5])) ? $model->expenses[5]['id'] : '')) !!}
									{!! Form::hidden('expenses[5][name]', 'almacen') !!}
									{!! Form::hidden('expenses[5][currency_id]', ((isset($model->expenses[5]['currency_id'])) ? $model->expenses[5]['currency_id'] : '2'), ['class' => 'currency', 'id'=>'c6']) !!}
									<a href="#" class="input-group-addon btn labelCurrency">{{ ((isset($model->expenses[5]['currency_id'])) ? $model->expenses[5]['value'] : '$') }}</a>
									{!! Form::text('expenses[5][value]', ((isset($model->expenses[5]['value'])) ? $model->expenses[5]['value'] : 0.00), ['class'=>'form-control expense text-right', 'id'=>'e6']) !!}
								</div>
							</div>
						</div>
						<div class="form-group form-group-sm">
							{!! Form::label('expenses[6][value]','Transporte local', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
								<div class="input-group">
									{!! Form::hidden('expenses[6][id]', ((isset($model->expenses[6])) ? $model->expenses[6]['id'] : '')) !!}
									{!! Form::hidden('expenses[6][name]', 'transporte') !!}
									{!! Form::hidden('expenses[6][currency_id]', ((isset($model->expenses[6]['currency_id'])) ? $model->expenses[6]['currency_id'] : '2'), ['class' => 'currency', 'id'=>'c7']) !!}
									<a href="#" class="input-group-addon btn labelCurrency">{{ ((isset($model->expenses[6]['currency_id'])) ? $model->expenses[6]['value'] : '$') }}</a>
									{!! Form::text('expenses[6][value]', ((isset($model->expenses[6]['value'])) ? $model->expenses[6]['value'] : 0.00), ['class'=>'form-control expense text-right', 'id'=>'e7']) !!}
								</div>
							</div>
							{!! Form::label('expenses[7][value]','Agencia de Aduanas', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
								<div class="input-group">
									{!! Form::hidden('expenses[7][id]', ((isset($model->expenses[7])) ? $model->expenses[7]['id'] : '')) !!}
									{!! Form::hidden('expenses[7][name]', 'aduana') !!}
									{!! Form::hidden('expenses[7][currency_id]', ((isset($model->expenses[7]['currency_id'])) ? $model->expenses[7]['currency_id'] : '2'), ['class' => 'currency', 'id'=>'c8']) !!}
									<a href="#" class="input-group-addon btn labelCurrency">{{ ((isset($model->expenses[7]['currency_id'])) ? $model->expenses[7]['value'] : '$') }}</a>
									{!! Form::text('expenses[7][value]', ((isset($model->expenses[7]['value'])) ? $model->expenses[7]['value'] : 0.00), ['class'=>'form-control expense text-right', 'id'=>'e8']) !!}
								</div>
							</div>
						</div>
					</template>
					

					@include('finances.proofs.partials.details')
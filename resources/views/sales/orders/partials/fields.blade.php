					<div class="form-group form-group-sm">
						{!! Form::hidden('with_tax', 1, ['id'=>'with_tax']) !!}
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
						{!! Form::label('txtSeller','Vendedor', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							@if(\Auth::user()->employee->job_id == 6)
							{!! Form::select('seller_id', [\Auth::user()->employee->id => \Auth::user()->employee->full_name], \Auth::user()->employee->id, ['class'=>'form-control', 'id'=>'lstSeller']); !!}
							@else
							{!! Form::select('seller_id', $sellers, ((isset($model->seller_id)) ? $model->seller_id : null),['class'=>'form-control', 'id'=>'lstSeller']); !!}
							@endif
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('attention','Atención', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::text('attention', null, ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('matter','Asunto', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::text('matter', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('currency_id','Moneda', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('currency_id', $currencies, ((isset($model->currency_id)) ? $model->currency_id : 1),['class'=>'form-control', 'id'=>'lstCurrency']); !!}
						</div>
						{!! Form::label('payment_condition_id','Condición de Pago', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('payment_condition_id', $payment_conditions, ((isset($model->payment_condition_id)) ? $model->payment_condition_id : 1),['class'=>'form-control', 'id'=>'lstPaymentCondition']); !!}
						</div>
						{!! Form::label('offer_period','Plazo Ofertado', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('offer_period', null, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('delivery_period','Plazo de Entrega', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('delivery_period', '30 días (Previa confirmación de la transferencia)', ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('delivery_place','Lugar de Entrega', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('delivery_place', 'Lima', ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('installation_period','Plazo de instalación', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('installation_period', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('comment','Comentarios', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-10">
						{!! Form::text('comment', null, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('status','Status:', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8 status-checked">
							@if(\Auth::user()->is_superuser)
							<label class="checkbox-inline" title="Verificado por Administración">
								{!! Form::checkbox('checked_at', (isset($model)) ? $model->checked_at : "on") !!} Verificado
							</label>
							@endif
							<label class="checkbox-inline" title="Aprobado por el Cliente">
								{!! Form::checkbox('approved_at', (isset($model)) ? $model->approved_at : "on") !!} Aprobado
							</label>
							@if(\Auth::user()->is_superuser)
							<label class="checkbox-inline" title="Facturado al Cliente">
								{!! Form::checkbox('invoiced_at', (isset($model)) ? $model->invoiced_at : "on") !!} Facturado
							</label>
							<label class="checkbox-inline" title="Productos fueron enviados al Cliente">
								{!! Form::checkbox('sent_at', (isset($model)) ? $model->sent_at : "on") !!} Enviado
							</label>
							<label class="checkbox-inline" title="Documento Cancelado">
								{!! Form::checkbox('canceled_at', (isset($model)) ? $model->canceled_at : "on") !!} Cancelado
							</label>
							@endif
						</div>
					</div>
					@include('sales.orders.partials.details')
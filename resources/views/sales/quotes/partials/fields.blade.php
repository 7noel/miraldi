					{!! Form::hidden('order_type', 2) !!}
					{!! Form::hidden('my_company', session('my_company')->id) !!}
					<div class="form-group form-group-sm">
						{!! Form::label('sn','Pedido Nº', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('sn', null, ['class'=>'form-control text-center', 'readonly']) !!}
						</div>
						{!! Form::label('txtSeller','Vendedor', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							@if(\Auth::user()->employee->job_id == 8 or \Auth::user()->id==3)
							{!! Form::select('seller_id', [\Auth::user()->employee->id => \Auth::user()->employee->full_name], \Auth::user()->employee->id, ['class'=>'form-control', 'id'=>'lstSeller']); !!}
							@else
							{!! Form::select('seller_id', $sellers, ((isset($model->seller_id)) ? $model->seller_id : null),['class'=>'form-control', 'id'=>'lstSeller']); !!}
							@endif
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::hidden('with_tax', 0, ['id'=>'with_tax']) !!}
						{!! Form::label('txtcompany','Cliente:', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							@if(isset($company))
								{!! Form::hidden('company_id', $company->id, ['id'=>'company_id']) !!}
								{!! Form::text('company', $company->company_name, ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@else
								{!! Form::hidden('company_id', null, ['id'=>'company_id']) !!}
								{!! Form::text('company', ((isset($model->company_id)) ? $model->company->company_name : null), ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
							@endif
						</div>
						{!! Form::label('attention','Atención', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::text('attention', null, ['class'=>'form-control']) !!}
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
						<div class="col-sm-2">
						{!! Form::text('condition', null, ['class'=>'form-control', 'id'=>'condition']); !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('comment','Comentarios', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-10">
						{!! Form::text('comment', null, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('status','Status:', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-7 status-checked">
							@if(1==1)
							<label class="checkbox-inline" title="Verificado por Administración">
								{!! Form::checkbox('checked_at', (isset($model)) ? $model->checked_at : "on") !!} Verificado
							</label>
							@endif
							@if(1==0)
							<label class="checkbox-inline" title="Aprobado por el Cliente">
								{!! Form::checkbox('approved_at', (isset($model)) ? $model->approved_at : "on") !!} Aprobado
							</label>
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
					{!! Form::hidden('order_type', 3) !!}
					{!! Form::hidden('sn', null) !!}
					{!! Form::hidden('my_company', session('my_company')->id) !!}
					<div class="form-group form-group-sm">
						{!! Form::hidden('with_tax', 0, ['id'=>'with_tax']) !!}
						{!! Form::label('txtCompany','Cliente:', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::hidden('company_id', null, ['id'=>'company_id']) !!}
							{!! Form::text('txtCompany', ((isset($model->company_id)) ? $model->company->company_name : null), ['class'=>'form-control', 'id'=>'txtCompany', 'required']) !!}
						</div>
						{!! Form::label('branch_id','Sucursal', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('branch_id', $bs, ((isset($model->branch_id)) ? $model->branch_id : 1),['class'=>'form-control', 'id'=>'lstBranch']); !!}
						</div>
						{!! Form::label('txtSeller','Vendedor', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-2">
							@if(\Auth::user()->employee->job_id == 8 or \Auth::user()->id==3)
							{!! Form::select('seller_id', [\Auth::user()->employee->id => \Auth::user()->employee->full_name], \Auth::user()->employee->id, ['class'=>'form-control', 'id'=>'lstSeller']); !!}
							@else
							{!! Form::select('seller_id', $sellers, ((isset($model->seller_id)) ? $model->seller_id : null),['class'=>'form-control', 'id'=>'lstSeller']); !!}
							@endif
						</div>
						{!! Form::label('currency_id','Moneda', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-1">
						{!! Form::select('currency_id', $currencies, ((isset($model->currency_id)) ? $model->currency_id : 1),['class'=>'form-control', 'id'=>'lstCurrency']); !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('txtShipper','Transportista:', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::hidden('shipper_id', null, ['id'=>'shipper_id']) !!}
							{!! Form::text('txtShipper', ((isset($model->shipper_id) and $model->shipper_id > 0) ? $model->shipper->company_name : null), ['class'=>'form-control', 'id'=>'txtShipper', 'required']) !!}
						</div>
						{!! Form::label('branch_shipper_id','Agencia', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('branch_shipper_id', $bs_shipper, ((isset($model->branch_shipper_id)) ? $model->branch_shipper_id : 1),['class'=>'form-control', 'id'=>'lstBranchShipper']); !!}
						</div>
						{!! Form::label('payment_condition_id','Cond pago', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('payment_condition_id', $payment_conditions, ((isset($model->payment_condition_id)) ? $model->payment_condition_id : 1),['class'=>'form-control', 'id'=>'lstPaymentCondition']); !!}
						</div>
						<div class="col-sm-2">
						{!! Form::text('condition', null, ['class'=>'form-control', 'id'=>'condition']); !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('attention','Atención', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-3">
						{!! Form::text('attention', null, ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('comment','Comentarios', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-7">
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
					@include('sales.purchases_orders.partials.details')
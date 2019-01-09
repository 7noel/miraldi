						<div class="form-group form-group-sm">
							{!! Form::label('f1','Desde', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::date('f1', null, ['class'=>'form-control', 'id'=>'f1']); !!}
							</div>
							{!! Form::label('f2','Hasta', ['class'=>'col-sm-1 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::date('f2', null, ['class'=>'form-control', 'id'=>'f2']); !!}
							</div>
						</div>

						<div class="form-group form-group-sm">
							{!! Form::label('seller_id','Vendedor', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::select('seller_id', $sellers, null, ['class'=>'form-control', 'id'=>'seller_id']); !!}
							</div>
							{!! Form::label('status','Status', ['class'=>'col-sm-1 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::select('status', ['' => 'Seleccionar'] + config('options.order_status'), null, ['class'=>'form-control', 'id'=>'status']); !!}
							</div>
							{!! Form::label('sn','Numero', ['class'=>'col-sm-1 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::text('sn', null, ['class'=>'form-control', 'id'=>'sn']); !!}
							</div>
						</div>

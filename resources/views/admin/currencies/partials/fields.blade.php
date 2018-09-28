					<div class="form-group  form-group-sm">
						{!! Form::label('name','Nombre', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::text('name', null, ['class'=>'form-control uppercase']) !!}
						</div>
						{!! Form::label('code','Código', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::select('code', config('options.table_sunat.moneda'), null, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
					<div class="form-group  form-group-sm">
						{!! Form::label('symbol','Símbolo', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-5">
						{!! Form::text('symbol', null, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
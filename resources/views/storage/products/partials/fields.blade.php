					<div class="form-group form-group-sm">
						{!! Form::label('name','Nombre', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-10">
						{!! Form::text('name', null, ['class'=>'form-control uppercase', 'required'=>'required']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('sub_category_id','SubCategoría', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('sub_category_id', $sub_categories, ((isset($model->sub_category_id)) ? $model->sub_category_id : null),['class'=>'form-control', 'id'=>'lstSubCategories', 'required'=>'required']); !!}
						</div>
						{!! Form::label('unit_id','Unidad', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('unit_id', $units, ((isset($model->unit_id)) ? $model->unit_id : 1),['class'=>'form-control', 'id'=>'lstUnit', 'required'=>'required']) !!}
						</div>
						{!! Form::label('status','Status', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::select('status', config('options.product_status'), ((isset($model->status)) ? $model->status : 1),['class'=>'form-control', 'id'=>'lstUnit', 'required'=>'required']); !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('brand_id','Descargable', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::select('is_downloadable', ['1' => 'SI', '0' => 'NO'], null, ['class'=>'form-control']); !!}
						</div>
						{!! Form::label('brand','Marca', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::text('brand', null, ['class'=>'form-control uppercase']) !!}
						</div>
						{!! Form::label('country_id','País', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::select('country_id', $countries, null, ['class'=>'form-control']); !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('intern_code','Codigo Interno', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('intern_code', null, ['class'=>'form-control uppercase']) !!}
						</div>
						{!! Form::label('provider_code','Codigo de Proveedor', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('provider_code', null, ['class'=>'form-control uppercase']) !!}
						</div>
						{!! Form::label('manufacturer_code','Codigo de Fabricante', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
						{!! Form::text('manufacturer_code', null, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('currency_id','Moneda', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::select('currency_id', $currencies, null, ['class'=>'form-control', 'required'=>'required']); !!}
						</div>
						{!! Form::label('last_purchase','Costo', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::number('last_purchase', 0.00, ['class'=>'form-control']) !!}
						</div>
						{!! Form::label('admin_expense','Gastos (%)', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-1">
							{!! Form::number('admin_expense', 30.00, ['class'=>'form-control', 'min' => '30.00']) !!}
						</div>
						{!! Form::label('profit_margin','Utilid. (%)', ['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-1">
							{!! Form::number('profit_margin', 18.00, ['class'=>'form-control', 'min' => '18.00']) !!}
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('value','Precio', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
								<div class="input-group">
									<span class="input-group-addon">
										{!! Form::checkbox('use_set_value', '1', null, ['id'=>'useSetValue']) !!}
									</span>
									{!! Form::text('value', null, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
								</div>
						</div>
					</div>
					<div class="form-group form-group-sm">
						{!! Form::label('description','Descripción', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-10">
						{!! Form::textarea('description', null, ['class'=>'form-control', 'rows' => 3]) !!}
						</div>
					</div>

					@if(isset($model) or 1==1)
						@include('storage.products.partials.accordion')
					@endif

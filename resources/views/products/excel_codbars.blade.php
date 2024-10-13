@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}">Código de barras - Preparación de etiquetas</h5>
				<div class="card-body">
					<form action="#" id="form-oc" autocomplete='off'>
						<div class="form-group row">
	                        <label for="ocompra" class="col-sm-2 col-form-label">O.Compra</label>
							<div class="col-sm-3">
	                            <input class="form-control form-control-sm" placeholder="Orden de compra" name="ocompra" type="text" value="" id="ocompra">
	                        </div>
	                        <div class="col-sm-2">
	                            <button type="submit" class="btn btn-sm btn-outline-secondary">{!! $icons['search'] !!} Buscar</button>
	                            <!-- <button type="submit" class="btn btn-outline-secondary" onclick="get_oc()">{!! $icons['search'] !!} Buscar</button> -->
	                        </div>
	                    </div>
                    </form>
					<div class="form-group row">
                        <label for="search" class="col-sm-2 col-form-label">Filtro</label>
						<div class="col-sm-8">
                            <input class="form-control form-control-sm" onkeyup="filtro_tabla('table-report')" placeholder="Buscar por Codigo o Descripción" name="search" type="text" value="" id="search">
                        </div>
                    </div>
					<div class="form-group row">
                        <div class="col-sm-2">
                        	{!! Form::open(['route'=> ['products.codbars_save'], 'method'=>'POST', 'id'=>"form-codbar-save"]) !!}
                            <button type="submit" class="btn btn-sm btn-outline-primary" id="btn-codbar-save">{!! $icons['db'] !!} Guardar</button>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-sm-2">
                        	{!! Form::open(['route'=> ['products.excel_codbars_download'], 'method'=>'POST', 'id'=>"form-excel-codbar"]) !!}
                            <button type="submit" class="btn btn-sm btn-outline-success" id="btn-excel-codbar">{!! $icons['excel'] !!} Descargar</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

					<table class="table table-hover table-sm">
					    <thead>
					        <tr>
					        	<th>Cantidad</th>
					            <th class="text-center">Código</th>
					            <th>Descripcion</th>
					            <th class="text-center">Unidad</th>
					            <th class="text-center">PRES</th>
					        </tr>
					    </thead>
					    <tbody id="table-report">
							@foreach($models as $model)
							<tr style="display: none;">
								<td>
									<input type="number" class="form-control form-control-sm text-cantidad-codbar">
								</td>
					            <td class="text-center text-codigo">{{ $model->ACODIGO }}</td>
					            <td class="text-description">{{ $model->ADESCRI }}</td>
								<td class="text-center text-unidad">{{ $model->AUNIDAD }}</td>
								<td class="text-center text-unidad">{{ (($model->APESO>1) ? round($model->APESO) : 1) }}</td>
							</tr>
							@endforeach
					    </tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection
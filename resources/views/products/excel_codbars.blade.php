@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}"> Buscar Productos
				</h5>
				<div class="card-body">
					<div class="form-group row">
                        <label for="search" class="col-sm-1 col-form-label">Filtro</label>
						<div class="col-sm-8">
                            <input class="form-control" onkeyup="filtro_tabla('table-report')" placeholder="Buscar por Codigo o Descripción" name="search" type="text" value="" id="search">
                        </div>
                        <div class="col-sm-2">
                        	{!! Form::open(['route'=> ['products.excel_codbars_download'], 'method'=>'POST', 'id'=>"form-excel-codbar"]) !!}
                            <button type="submit" class="btn btn-success" onclick="excel_codbar()"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Descargar</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

					<table class="table table-hover table-sm">
					    <thead>
					        <tr>
					        	{{-- <th>#</th> --}}
					        	<th>Cantidad</th>
					            <th class="text-center">Código</th>
					            <th>Descripcion</th>
					            <th class="text-center">Unidad</th>
					        </tr>
					    </thead>
					    <tbody id="table-report">
							@foreach($models as $model)
							<tr style="display: none;">
								{{-- <td>
									<div class="form-check">
										<input type="checkbox" class="form-check-input">
									</div>
								</td> --}}
								<td>
									<input type="number" class="form-control form-control-sm text-cantidad-codbar">
								</td>
					            <td class="text-center text-codigo">{{ $model->ACODIGO }}</td>
					            <td class="text-description">{{ $model->ADESCRI }}</td>
								<td class="text-center text-unidad">{{ $model->AUNIDAD }}</td>
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
@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}">Productos</h5>
				<div class="card-body">
					<div class="form-group row">
                        <label for="search" class="col-sm-1 col-form-label">Filtro</label>
						<div class="col-sm-11">
                            <input class="form-control form-control-sm" onkeyup="filtro_tabla('table-report')" placeholder="Buscar por Codigo o Descripción" name="search" type="text" value="" id="search">
                        </div>
                    </div>

					<table class="table table-hover table-sm">
					    <thead>
					        <tr>
					            <th class="text-center">Código</th>
					            <th class="text-center">C_Fabricante</th>
					            <th>Descripcion</th>
					            <th class="text-center">Unidad</th>
					            <th class="text-center">PRES</th>
					            <th>Acciones</th>
					        </tr>
					    </thead>
					    <tbody id="table-report">
							@foreach($models as $model)
							<tr style="display: none;">
					            <td class="text-center text-codigo">{{ $model->ACODIGO }}</td>
					            <td class="text-center text-codigo">{{ $model->ACODIGO2 }}</td>
					            <td class="text-description">{{ $model->ADESCRI }}</td>
								<td class="text-center text-unidad">{{ $model->AUNIDAD }}</td>
								<td class="text-center text-unidad">{{ (($model->APESO>1) ? round($model->APESO) : 1) }}</td>
								<td class="text-center" style="white-space: nowrap;">
									<a href="{{ route($routes['show'], $model) }}" class="btn btn-outline-secondary btn-sm" title="Ver">{!! $icons['view'] !!}</a>
									<a href="{{ route( $routes['edit'] , $model) }}" class="btn btn-outline-primary btn-sm" title="Editar">{!! $icons['edit'] !!}</a>
									{{-- <a href="#" class="btn-delete btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a> --}}
								</td>
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
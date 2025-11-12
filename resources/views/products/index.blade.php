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
                            <input class="form-control form-control-sm" id="inputBusqueda" placeholder="Buscar por Codigo o Descripción" name="search" type="text" value="" id="search">
                        </div>
                    </div>

					<table class="table table-hover table-sm">
					    <thead>
					        <tr>
					            <th class="text-center">Código</th>
					            <th class="text-center">C_Fabricante</th>
					            <th>Descripcion</th>
					            <th class="text-center no-almacen">Precio</th>
					            <th class="text-center">Unidad</th>
					            <th class="text-center">PRES</th>
					            <th class="text-center">Ubicación</th>
					            <th class="text-center">Acciones</th>
					        </tr>
					    </thead>
					    <tbody id="table-products">
					    </tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>


@include('products.movimientos')

@if(Auth::user()->role_id == 3)
<style>
	.no-almacen{
		display: none;
	}
</style>
@endif
@endsection
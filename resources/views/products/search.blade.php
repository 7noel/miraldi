@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}"> Buscar Producto
				</h5>
				<div class="card-body">
					{!! Form::open(['route'=> ['products.get_product', 'ID'], 'method'=>'GET', 'class'=>'mb-5', 'id'=>"form-buscar-codigo", 'autocomplete'=>'off']) !!}
						<div class="form-group row">
							<label for="codigo" class="col-sm-1 col-form-label">Código</label>
							<div class="col-sm-2">
								<input type="text" class="form-control form-control-sm" id="codigo" value="" autofocus>
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-sm btn-outline-success" id="submit">{!! $icons['search'] !!} Buscar</button>
							</div>
						</div>

					{!! Form::close() !!}
					<div id="product-details" class="d-none">
						<div class="form-row">
							<div class="col-md-2 mb-3">
								<label for="codigox">Codigo</label>
								<span class="form-control form-control-sm form-control-plaintext" id="codigox"></span>
							</div>
							<div class="col-md-2 mb-3">
								<label for="cod_fab">Cod Fabricante</label>
								<span class="form-control form-control-sm form-control-plaintext" id="cod_fab"></span>
							</div>
							<div class="col-md-4 mb-3">
								<label for="name">Descripción</label>
								<span class="form-control form-control-sm form-control-plaintext" id="name"></span>
							</div>
							<div class="col-md-4 mb-3">
								<label for="family">Familia</label>
								<span class="form-control form-control-sm form-control-plaintext" id="family"></span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-3">
								<label for="currency">Moneda</label>
								<span class="form-control form-control-sm form-control-plaintext" id="currency"></span>
							</div>
							<div class="col-md-2 mb-3">
								<label for="price">Precio</label>
								<span class="form-control form-control-sm form-control-plaintext" id="price"></span>
							</div>
							<div class="col-md-2 mb-3">
								<label for="stock">Stock</label>
								<span class="form-control form-control-sm form-control-plaintext" id="stock"></span>
							</div>
							<div class="col-md-4 mb-3">
								<label for="locker">Ubicación</label>
								<span class="form-control form-control-sm form-control-plaintext" id="locker"></span>
							</div>
					  	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


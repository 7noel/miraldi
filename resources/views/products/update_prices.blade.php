@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}"> Buscar Producto
				</h5>
				<div class="card-body">
					{!! Form::open(['route'=> ['products.update_prices2'], 'method'=>'POST', 'class'=>'mb-5']) !!}
						<div class="form-group row">
							<label for="codigo" class="col-sm-1 col-form-label">Fecha</label>
							<div class="col-sm-2">
								<input type="date" class="form-control form-control-sm" name="fecha" value="" required autofocus>
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-sm btn-outline-primary" id="submit">{!! $icons['db'] !!} Buscar</button>
							</div>
						</div>

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


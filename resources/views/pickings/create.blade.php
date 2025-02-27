@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}"> Picking
				</h5>
				<div class="card-body">
					<form action="#" class="qr" id="form-picking-qr">
						<div class="form-group">
							<input class="form-control form-control-sm" id="picking_qr" placeholder="Leer código QR" autofocus>
							<!-- <textarea class="form-control" id="picking_qr">0000005|50100010 2.000000|50100050 2.000000</textarea> -->
						</div>
						<div class="form-group">
							<button type="submit" id="btn-pk" class="btn btn-outline-info btn-sm" title="picking">{!! $icons['add'] !!} Agregar Productos</button>
						</div>
					</form>
					<div class="picking d-none">
						<form id="form-add-picking">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="check-cantidad-pk">
								<label class="custom-control-label" for="check-cantidad-pk">Ingresar la cantidad a descontar</label>
							</div>
							<div class="form-group pk-div-cantidad d-none">
								<input class="form-control form-control-sm" type="number" placeholder="CANTIDAD" id="cantidad" value="1">
							</div>
							<div class="form-group">
								<input class="form-control form-control-sm" type="text" placeholder="CODIGO" id="codigo" autocomplete="off">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-sm" id="btn-add-pk">{!! $icons['add'] !!} Agregar</button>
								<a href="" class="btn btn-sm btn-outline-danger">{!! $icons['refresh'] !!} Refrescar</a>
							</div>
						</form>

						{!! Form::open(['route'=> 'pickings.store' , 'method'=>'POST', 'id'=>'form-picking-create', 'autocomplete'=>'off']) !!}
							<input type="hidden" id="CFNUMPED" name="CFNUMPED">
							<input type="hidden" id="items" name="items" value="0">
							<input type="hidden" id="pl" name="pl" value="0">
							<input type="hidden" id="es" name="es" value="0">
							<div class="table-responsive">
								<table class="{{ config('options.styles.table') }}">
									<thead class="{{ config('options.styles.thead') }}">
										<tr>
											<th>Código</th>
											<th>Cod Fabr</th>
											<th>Descripción</th>
											<th class="text-center">PL</th>
											<th class="text-center">ES</th>
											<th class="text-center">PRES</th>
											<th class="text-center">STK</th>
											<th class="text-center">UBI</th>
										</tr>
									</thead>
									<tbody id="table-picking">
									</tbody>
								</table>
							</div>
							<button type="submit" class="btn btn-sm btn-outline-info click-form">{!! $icons['save'] !!} Guardar</button>
						{!! Form::close() !!}
						
					</div>
					<audio id="audio-error" controls class="d-none">
						<source type="audio/mpeg" src="/audio/error.mp3">
					</audio>
					<audio id="audio-success" controls class="d-none">
						<source type="audio/mpeg" src="/audio/ss_1.mp3">
					</audio>
					<audio id="audio-success_2" controls class="d-none">
						<source type="audio/mpeg" src="/audio/ss_2.mp3">
					</audio>
					<audio id="audio-success_3" controls class="d-none">
						<source type="audio/mpeg" src="/audio/success_3.mp3">
					</audio>
				</div>
			</div>
		</div>
	</div>
</div>

@include('products.movimientos')

@endsection

@section('scripts')



@endsection
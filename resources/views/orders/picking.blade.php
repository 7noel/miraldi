@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}"> Picking
				</h5>
				<div class="card-body">
					<form action="#" class="qr">
						<div class="form-group">
							<textarea class="form-control" id="picking_qr" rows="3">0000005|50100010 2.000000|50100050 2.000000</textarea>
						</div>
						<div class="form-group">
							<button type="button" id="btn-pk" class="btn btn-outline-info btn-sm" title="picking" onclick="get_picking()">Agregar Productos {!! $icons['add'] !!}</button>
						</div>
					</form>
					<div class="picking d-none">
						<form id="form-add-picking">
							<div class="form-group">
								<input class="form-control form-control-sm" type="text" placeholder="CODIGO" id="codigo">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-sm" id="btn-add-pk">Agregar {!! $icons['add'] !!}</button>
							</div>
						</form>
						<table class="{{ config('options.styles.table') }}">
							<thead class="{{ config('options.styles.thead') }}">
								<tr>
									<th>Código</th>
									<th>Descripción</th>
									<th>PL</th>
									<th>ES</th>
								</tr>
							</thead>
							<tbody id="table-picking">
							</tbody>
						</table>
						
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

@endsection

@section('scripts')



@endsection
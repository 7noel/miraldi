@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}">Cambiar contraseña
				</h5>
				<div class="card-body">
					{!! Form::open(['route'=> 'update_password' , 'method'=>'POST', 'class'=>'']) !!}
						<div class="col-sm-4">
							{!! Field::password('current_password', ['label' => 'Contraseña Actual', 'class'=>'form-control-sm', 'required']) !!}
						</div>
						<div class="col-sm-4">
							{!! Field::password('password', ['label' => 'Nueva Contraseña', 'class'=>'form-control-sm', 'required']) !!}
						</div>
						<div class="col-sm-4">
							{!! Field::password('password_confirmation', ['label' => 'Confirmar Contraseña', 'class'=>'form-control-sm', 'required']) !!}
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-outline-success" id="submit">{!! $icons['save'] !!} Cambiar Contraseña</button>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

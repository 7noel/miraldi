@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-custom">Seleccione su empresa</div>

				<div class="panel-body">
					
					{!! Form::open(['route'=> 'change_company' , 'method'=>'POST', 'class'=>'form-horizontal']) !!}

					@if(Request::url() != URL::previous())
					<input type="hidden" name="last_page" value="{{ URL::previous() }}">
					@endif
					
					<div class="form-group  form-group-sm">
						{!! Form::label('company','Empresa', ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
						{!! Form::select('company', $companies, session('my_company')->id, ['class'=>'form-control uppercase']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">Cambiar Empresa</button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

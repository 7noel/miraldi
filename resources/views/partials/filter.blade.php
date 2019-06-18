@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-custom">CONSULTAR {{ strtoupper(config($labels['index'] .'.panel')) }}</div>
					<div class="panel-body">
						{!! Form::model($filter, ['route'=>$routes['filter'], 'method'=>'GET', 'class'=>'form-horizontal']) !!}

						@include( $views['filter'] )

						<div class="form-group form-group-sm">
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-2">
								<button type="submit" class="btn btn-primary">{!! config('options.icons.search') !!} Buscar</button>
							</div>
							<div class="col-sm-offset-1 col-sm-2">
								<a class="btn btn-info" href="{{ route( $routes['create'] ) }}" role="button">{!! config('options.icons.add') !!} {{ config($labels['index'].'.create') }}</a>
							</div>
						</div>

						{!! Form::close() !!}
						@include( $views['table'] )
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')


@endsection
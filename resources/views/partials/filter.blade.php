@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="{{ config('options.styles.card_header') }}">CONSULTAR {{ strtoupper($labels['index']) }}
				</div>
				<div class="card-body">
					{!! Form::model($filter, ['route'=>$routes['index'], 'method'=>'GET', 'class'=>'form-horizontal']) !!}
					<div class="">
						@include( $views['filter'] )
						<div class="form-row mb-3">
							<div class="col-sm-2 offset-sm-1">
								<button type="submit" class="btn btn-outline-success btn-sm">{!! $icons['search'] !!} Buscar</button>
							</div>
							<div class="col-sm-2">
								<a class="btn btn-outline-primary btn-sm" href="{{ route( $routes['create'] ) }}" role="button">{!! $icons['add'] !!} {{ $labels['index.create'] }}</a>
							</div>
						</div>
					</div>

					{!! Form::close() !!}
					@include( $views['table'] )
					{!! $models->appends(\Request::only(['name']))->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>

{!! Form::open(['route'=> [$routes['delete'], ':_ID'], 'method'=>'DELETE', 'id'=>'form-delete']) !!}
{!! Form::close() !!}

@endsection

@section('scripts')


@endsection
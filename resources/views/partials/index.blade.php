@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				@if(Session::has('message'))
					<p class="alert alert-success">{{ Session::get('message') }}</p>
				@endif
				<h5 class="{{ config('options.styles.card_header') }}">
					{{ $labels['index'] }}
				</h5>
				<div class="card-body">
					<div class="row justify-content-between mr-1 ml-1 mb-3">
						<div class="">
							<a class="btn btn-outline-primary btn-sm" href="{{ route($routes['create']) }}" role="button">
								{!! $icons['add'] !!} {{ $labels['index.create'] }}
							</a>
						</div>
						@include('partials.search')
					</div>
					@include($views['table'])
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
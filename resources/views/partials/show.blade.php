@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}"> {{ $labels['show'] }} </h5>
				<div class="card-body">
					{!! Form::model($model, ['route' => $routes['store'], 'class'=>'']) !!}
					@include($views['fields'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')



@endsection
@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-custom">{{ config('options.' . Request::route()->getAction()['as'] .'.panel') . $model->name }}</div>
				<div class="panel-body">
					@include('partials.messages')
					{!! Form::model($model, ['route'=>[ 'proofs.update' , $model], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}
					@if(Request::url() != URL::previous())
					<input type="hidden" name="last_page" value="{{ URL::previous() }}">
					@endif

					@include('finances.proofs.partials.fields')
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">{{ config('options.' . Request::route()->getAction()['as'] .'.update') }}</button>
						</div>
					</div>
					
					{!! Form::close() !!}
				</div>
			</div>
			@include('partials.delete')
		</div>
	</div>
</div>
@endsection

@section('scripts')

@include('finances.proofs.scripts')

@endsection
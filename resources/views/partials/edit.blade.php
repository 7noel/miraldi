@extends('app')

@section('content')
<div class="container">
<?php 
if (isset($model->sn) and is_numeric($model->sn)) {
	$model->name = str_pad($model->sn, 6, "0", STR_PAD_LEFT);
} elseif (isset($model->sn)) {
	$model->name = $model->sn;
} else {
	# code...
}

 ?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-custom">{!! config($labels['edit'] .'.panel') . "<strong>" . $model->name . "</strong>" !!}</div>

				<div class="panel-body">
					@include('partials.messages')

					{!! Form::model($model, ['route'=>[ $routes['update'] , $model], 'method'=>'PUT', 'class'=>'form-horizontal', 'enctype'=>"multipart/form-data"]) !!}

					@if(Request::url() != URL::previous())
					<input type="hidden" name="last_page" value="{{ URL::previous() }}">
					@endif
					
					@include( $views['fields'] )
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">{!! config('options.icons.save') !!} {{ config($labels['edit'] .'.update') }}</button>
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

@include( $views['scripts'] )

@endsection
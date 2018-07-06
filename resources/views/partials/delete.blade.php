{!! Form::open(['route'=>[ $routes['delete'] , $model], 'method'=>'DELETE']) !!}
	<button type="submit" class="btn btn-danger delete">{!! config('options.icons.remove') !!} {{ config($labels['edit'] .'.delete') }}</button>
{!! Form::close() !!}

						{!! Form::model(Request::all() ,['route'=>$routes['index'], 'method'=>'GET', 'class'=>'form-inline', 'role'=>'search']) !!}
								{!! Form::text('name', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'']) !!}
								<button type="submit" class="btn btn-outline-success btn-sm">{!! $icons['search'] !!} Buscar</button>
						{!! Form::close() !!}

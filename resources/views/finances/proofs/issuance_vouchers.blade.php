@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-custom">{{ config($labels['index'] .'.panel') }}</div>
				@if(Session::has('message'))
					<p class="alert alert-success">{{ Session::get('message') }}</p>
				@endif
				<div class="panel-body">
					@include('partials.search')
					<p><a class="btn btn-info" href="{{ route( $routes['create'] ) }}" role="button">{!! config('options.icons.add') !!} {{ config($labels['index'].'.create') }}</a></p>
					<br>
					<div class="">

						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Fecha</th>
									<th>Documento</th>
									<th>Empresa</th>
									<th>Total</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach($models as $model)
								<tr data-id="{{ $model->id }}">
									<td>{{ $model->id }}</td>
									<td>{{ \Carbon::createFromFormat('Y-m-d', $model->issued_at)->formatLocalized('%d/%m/%Y') }} </td>
									<td>{{ $model->document_type->name." ".$model->series." ".$model->number }} </td>
									<td>{{ $model->company->company_name }} </td>
									<td>{{ $model->total }} </td>
									<td>
										<a href="{{ route( str_replace('index', 'edit', Request::route()->getAction()['as']) , $model) }}" class="btn btn-primary btn-xs" title="Editar">{!! config('options.icons.edit') !!}</a>
										<a href="#" class="btn-delete btn btn-danger btn-xs" title="Eliminar">{!! config('options.icons.remove') !!}</a>
									<a href="{{ ($model->response_sunat == '')? '#' : json_decode($model->response_sunat)->enlace_del_pdf }}">{!! config('options.icons.pdf') !!}</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>

					</div>
					{!! $models->appends(\Request::only(['name']))->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>

{!! Form::open(['route'=>[$routes['delete'], ':_ID'], 'method'=>'DELETE', 'id'=>'form-delete']) !!}
{!! Form::close() !!}

@endsection

@section('scripts')

@include('finances.proofs.scripts')

@endsection
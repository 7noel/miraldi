@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-custom">Kardex</div>
				<div class="panel-body">
					<div class="">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Fecha</th>
									<th>Tipo</th>
									<th>Numero</th>
									<th>Tipo OP</th>
									<th>Entradas</th>
									<th>Salidas</th>
									<th>Saldo Final</th>
								</tr>
							</thead>
							<tbody>
								@foreach($models as $model)
								<tr data-id="{{ $model->id }}">
									<td>{{ $model->id }}</td>
									<td>{{ $model->created_at->formatLocalized('%d-%m-%Y') }} </td>
									<td>{{ $model->move->parent->document_type->name }}</td>
									<td>{{ $model->move->parent->number }} </td>
									<td>{{ $model->type_op }} </td>
									<td>{{ $model->input }} </td>
									<td>{{ $model->output }} </td>
									<td>{{ $model->stock }} </td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection

@section('scripts')

@endsection
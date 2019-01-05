@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-custom">CONSULTAR PEDIDOS</div>
					<div class="panel-body">
						{!! Form::model($filter, ['route'=>'orders.filter', 'method'=>'POST', 'class'=>'form-horizontal']) !!}
						<div class="form-group form-group-sm">
							{!! Form::label('my_company','Empresa', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::select('my_company', $my_companies, null, ['class'=>'form-control', 'id'=>'my_company']); !!}
							</div>
							{!! Form::label('f1','Desde', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::date('f1', null, ['class'=>'form-control', 'id'=>'f1']); !!}
							</div>
							{!! Form::label('f2','Hasta', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::date('f2', null, ['class'=>'form-control', 'id'=>'f2']); !!}
							</div>
						</div>

						<div class="form-group form-group-sm">
							{!! Form::label('seller_id','Vendedor', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::select('seller_id', $sellers, null, ['class'=>'form-control', 'id'=>'seller_id']); !!}
							</div>
							{!! Form::label('status','Status', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::select('status', $status, null, ['class'=>'form-control', 'id'=>'status']); !!}
							</div>
							{!! Form::label('id','Numero', ['class'=>'col-sm-2 control-label']) !!}
							<div class="col-sm-2">
							{!! Form::text('id', null, ['class'=>'form-control', 'id'=>'id']); !!}
							</div>
						</div>

						<div class="form-group form-group-sm">
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary">Buscar</button>
							</div>
						</div>
						{!! Form::close() !!}
						@include('sales.orders.partials.table')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')


@endsection
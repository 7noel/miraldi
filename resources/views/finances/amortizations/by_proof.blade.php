@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-custom">PAGO DE UN COMPROBANTE DE PAGO</div>
				<div class="panel-body">
					@include('partials.messages')
					{!! Form::model($model, ['route'=>[ 'amortizations.update' , $model], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}
					@if(Request::url() != URL::previous())
					<input type="hidden" name="last_page" value="{{ URL::previous() }}">
					@endif

					{!! Form::hidden('my_company', null, ['id'=>'my_company']) !!}
					{!! Form::hidden('currency_id', null, ['id'=>'currency_id']) !!}

					<div class="form-group form-group-sm">
						<div class="col-sm-4">
							{!! Form::label('my_company','Mi Empresa:', ['class'=>'control-label']) !!}
							<p class="form-control-static">{{ $model->mycompany->company_name }}</p>
						</div>
						<div class="col-sm-4">
							{!! Form::label('company_id','Cliente:', ['class'=>'control-label']) !!}
							<p class="form-control-static">{{ $model->company->company_name }}</p>
						</div>
						<div class="col-sm-2">
							{!! Form::label('total','Total('.$model->currency->symbol.'):', ['class'=>'control-label']) !!}
							{!! Form::text('total', null, ['id'=>'total', 'class'=>'form-control input-sm', 'readonly']) !!}
						</div>
						<div class="col-sm-2">
							{!! Form::label('amortization','Amortización:', ['class'=>'control-label']) !!}
							{!! Form::text('amortization', null, ['id'=>'amortization', 'class'=>'form-control input-sm', 'readonly']) !!}
						</div>
					</div>
					
						@php $i=0; @endphp
						
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="col-sm-2">Cuenta</th>
									<th class="col-sm-2">Fecha</th>
									<th class="col-sm-2">Numero OP</th>
									<th class="col-sm-1">Moneda</th>
									<th class="col-sm-1">Monto</th>
									<th class="col-sm-1">Cambio</th>
									<th class="col-sm-1">Acciones</th>
									<!-- <th class="col-sm-1">V.Total</th> -->
								</tr>
							</thead>
							<tbody id="tableItems">
							@if(isset($model->amortizations))
							@foreach($model->amortizations as $amortization)
								<tr data-id="{{ $amortization->id }}">
									{!! Form::hidden("amortizations[$i][id]", $amortization->id, ['class'=>'amortizationId','data-amortizationId'=>'']) !!}
									{!! Form::hidden("amortizations[$i][proof_id]", $amortization->proof_id, ['class'=>'proofId','data-proofId'=>'']) !!}
									{!! Form::hidden("payments[$i][id]", $amortization->payment_id, ['class'=>'paymentId','data-paymentId'=>'']) !!}
									{!! Form::hidden("payments[$i][bank_id]", $amortization->payment->bank_id, ['class'=>'bank_id','data-bankId'=>'']) !!}
									{!! Form::hidden("amortizations[$i][value_proof]", $amortization->value_proof, ['class'=>'valueProof','data-valueProof'=>'']) !!}
									{!! Form::hidden("amortizations[$i][value_payment]", $amortization->value_payment, ['class'=>'valuePayment','data-valuePayment'=>'']) !!}

									<td>{{ $amortization->payment->bank->label }}</span></td>
									<td>{!! Form::date("payments[$i][issued_at]", $amortization->payment->issued_at, ['class'=>'form-control input-sm txtFecha', 'data-fecha'=>'', 'required'=>'required', 'disabled']); !!}</td>
									<td>{!! Form::text("payments[$i][number]", $amortization->payment->number, ['class'=>'form-control input-sm txtNumber text-right', 'data-number'=>'']) !!}</td>
									<td>{!! Form::text("payments[$i][currency_id]", $amortization->payment->currency_id, ['class'=>'form-control input-sm txtCurrency text-right', 'data-currency'=>'']) !!}</td>
									<td>{!! Form::text("payments[$i][value]", $amortization->payment->value, ['class'=>'form-control input-sm txtValue text-right', 'data-value'=>'']) !!}</td>
									<td>{!! Form::text("payments[$i][exchange]", $amortization->payment->exchange, ['class'=>'form-control input-sm txtExchange text-right', 'data-exchange'=>'']) !!}</td>

									<!-- <td> <span class='form-control input-sm txtTotal text-right' data-total>{{ $amortization->total }}</span> </td> -->
									<td class="text-center form-inline">
										<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
										<input type="checkbox" name="amortizations[{{$i}}][is_deleted]" data-isdeleted class="isdeleted hidden">
									</td>
								</tr>
								@php $i++; @endphp
							@endforeach
							@endif
							</tbody>
						</table>
						<template id="template-row-item">
							<tr>
								{!! Form::hidden("data10", $model->id, ['class'=>'proofId','data-proofId'=>'']) !!}
								{!! Form::hidden('data11', null, ['class'=>'valueProof', 'data-valueProof'=>'']) !!}
								{!! Form::hidden('data9', null, ['class'=>'valuePayment', 'data-valuePayment'=>'']) !!}

								<td>{!! Form::select('data8', $banks, null, ['class'=>'form-control input-sm bank_id', 'data-bankId'=>'', 'required'=>'required']) !!}</td>
								<td>{!! Form::date('data3', date('Y-m-d'), ['class'=>'form-control input-sm txtFecha', 'data-fecha'=>'', 'required'=>'required']) !!}</td>
								<td>{!! Form::text('data4', null, ['class'=>'form-control input-sm txtNumber text-right', 'data-number'=>'']) !!}</td>
								<td>{!! Form::select('data5', $currencies, $model->currency_id, ['class'=>'form-control input-sm txtCurrency text-right', 'data-currency'=>'']) !!}</td>
								<td>{!! Form::text('data6', null, ['class'=>'form-control input-sm txtValue text-right', 'data-value'=>'']) !!}</td>
								<td>{!! Form::text('data7', null, ['class'=>'form-control input-sm txtExchange text-right', 'data-exchange'=>'']) !!}</td>
								<!-- <td> <span class='form-control input-sm txtTotal text-right' data-total></span> </td> -->
								<td class="text-center form-inline">
									<a href="#" class="btn btn-danger btn-xs btn-delete-item" title="Eliminar">{!! config('options.icons.remove') !!}</a>
									<input type="checkbox" name="data8" data-isdeleted class="isdeleted hidden">
								</td>
							</tr>
						</template>
						{!! Form::hidden('items', $i, ['id'=>'items']) !!}
						<a href="#" id="btnAddPay" class="btn btn-success btn-sm" title="Agregar Pago">{!! config('options.icons.add') !!} Agregar</a>



					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">Grabar Amortizaciones</button>
						</div>
					</div>
					
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

@include('finances.amortizations.scripts')

@endsection
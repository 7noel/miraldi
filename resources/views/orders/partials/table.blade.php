<div class="table-responsive">
<table class="{{ config('options.styles.table') }}">
	<thead class="{{ config('options.styles.thead') }}">
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">Fecha</th>
			<th style="min-width: 250px">Cliente</th>
			<th style="min-width: 200px">Vendedor</th>
			<th class="text-center">Mnd</th>
			<th class="text-center">Total</th>
			<th class="text-center">Estado</th>
			<th class="text-center">Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($models as $model)
		@php
		if ($model->CFCOTIZA=='AUTORIZADO') {
			$clase = 'badge badge-primary';
		} elseif ($model->CFCOTIZA=='ATENDIDO') {
			$clase = 'badge badge-success';
		} elseif ($model->CFCOTIZA=='ANUL') {
			$clase = 'badge badge-danger';
		} else {
			$clase = 'badge badge-info';
		}
		@endphp
		<tr data-id="{{ $model->id }}" data-tipo="OT">
			<td>{{ $model->CFNUMPED }}</td>
			<td class="text-center">{{ date('d/m/Y', strtotime($model->CFFECDOC)) }}</td>
			<td>{{ $model->CFNOMBRE }} </td>
			<td>{{ $model->seller->DES_VEN }}</td>
			<td class="text-center">{{ $model->CFCODMON }}</td>
			<td class="text-right">{{ number_format($model->CFIMPORTE, 2, '.', '') }}</td>
			<td class="text-center status"><span class="{{ $clase }}">{{ $model->CFCOTIZA }}</span></td>
			<td class="text-center" style="white-space: nowrap;">
				<a href="{{ route( 'orders.print_note' , $model->CFNUMPED ) }}" target="_blank" class="btn btn-outline-info btn-sm" title="PDF Nota">{!! $icons['pdf'] !!}</a>
				<button type="button" onclick="printJS('{{ route( 'orders.print' , $model->CFNUMPED ) }}')" class="btn btn-outline-success btn-sm" title="Imprimir Pedido Almacén">{!! $icons['printer'] !!}</button>
				@if($model->original)
				<a href="{{ route( 'orders.print_original' , $model->CFNUMPED ) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="PDF Nota Original">{!! $icons['pdf'] !!}</a>
				@else
				<a href="#" class="btn btn-outline-secondary btn-sm" title="PDF Nota Original">{!! $icons['pdf'] !!}</a>
				@endif
				<!-- Permite editar pedido en estado emitido a todos y en estado autorizado solo al administrador y al facturador -->
				@if($model->CFCOTIZA=='EMITIDO' or ($model->CFCOTIZA=='AUTORIZADO' and in_array(\Auth::user()->role_id, [1, 4])))
				<a href="{{ route( 'orders.edit' , $model) }}" class="btn btn-outline-primary btn-sm" title="Editar">{!! $icons['edit'] !!}</a>
				{{--<a href="#" class="btn-anular btn btn-outline-danger btn-sm" title="Eliminar">{!! $icons['remove'] !!}</a>--}}
				@else
				<a href="{{ route('orders.show', $model->CFNUMPED) }}" class="btn btn-outline-secondary btn-sm" title="Ver OT">{!! $icons['view'] !!}</a>
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
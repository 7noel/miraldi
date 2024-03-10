<table class="{{ config('options.styles.table') }}">
	<thead class="{{ config('options.styles.thead') }}">
		<tr>
			<th>#</th>
			<th>Fecha</th>
			<th>Cliente</th>
			<th>Vendedor</th>
			<th>Mnd</th>
			<th>Total</th>
			<th>Estado</th>
			<th>Acciones</th>
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
			<td>{{ date('d/m/Y', strtotime($model->CFFECDOC)) }}</td>
			<td>{{ $model->CFNOMBRE }} </td>
			<td>{{ $model->seller->DES_VEN }}</td>
			<td>{{ $model->CFCODMON }}</td>
			<td class="text-right">{{ number_format($model->CFIMPORTE, 2, '.', '') }}</td>
			<td class="text-center status"><span class="{{ $clase }}">{{ $model->CFCOTIZA }}</span></td>
			<td style="white-space: nowrap;">
				<a href="{{ route( 'print_note' , $model->CFNUMPED ) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Imprimir Nota">{!! $icons['pdf'] !!}</a>
				<button type="button" onclick="printJS('{{ route( 'print_order' , $model->CFNUMPED ) }}')" class="btn btn-outline-success btn-sm" title="Imprimir Pedido">{!! $icons['printer'] !!}</button>
				@if($model->CFCOTIZA=='EMITIDO')
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
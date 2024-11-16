@php $i=0; @endphp
<div class="">
<table class="table table-sm">
	<thead>
		<tr>
			<th>Código</th>
			<th>Cod Fabr</th>
			<th>Descripción</th>
			<th>PL</th>
			<th>ES</th>
		</tr>
	</thead>
	<tbody id="tableItems">
	@php $details = json_decode($model->details); @endphp
	@foreach($details as $detail)
		<tr>
			<td>{{ $detail->codigo }}</td>
			<td>{{ isset($detail->codigo2) ? $detail->codigo2 : '' }}</td>
			<td>{{ $detail->name }}</td>
			<td>{{ $detail->quantity }}</td>
			<td>{{ $detail->quantity_ordered }}</td>
		</tr>
		@php $i++; @endphp
	@endforeach
	</tbody>
</table>

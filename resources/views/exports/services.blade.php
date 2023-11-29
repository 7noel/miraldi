<table>
	<thead>
		<tr>
			<th>Código</th>
			<th>Nombre</th>
			<th>Categoría</th>
			<th>Sub Categoría</th>
			<th>Unidad</th>
			<th>Moneda</th>
			<th>Valor</th>
			<th>Precio</th>
		</tr>
	</thead>
	<tbody>
		@foreach($services as $service)
		<tr>
			<td>{{ $service->intern_code }}</td>
			<td>{{ $service->name }}</td>
			<td>{{ $service->category->name }}</td>
			<td>{{ $service->sub_category->name }}</td>
			<td>{{ $service->unit->name }}</td>
			<td>{{ config('options.table_sunat.moneda_symbol.'.$service->currency_id) }}</td>
			<td>{{ $service->value }}</td>
			<td>{{ $service->price }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
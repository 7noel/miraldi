<table>
	<thead>
		<tr>
			<th>Almacén</th>
			<th>Código</th>
			<th>Nombre</th>
			<th>Categoría</th>
			<th>Sub Categoría</th>
			<th>Unidad</th>
			<th>Moneda</th>
			<th>Valor</th>
			<th>Precio</th>
			<th>ValorCosto</th>
			<th>PrecioCosto</th>
			<th>Stock Actual</th>
			<th>Stock Mínimo</th>
		</tr>
	</thead>
	<tbody>
		@foreach($stocks as $stock)
		<tr>
			<td>{{ $stock->warehouse_id }}</td>
			<td>{{ $stock->product->intern_code }}</td>
			<td>{{ $stock->product->name }}</td>
			<td>{{ $stock->product->category->name }}</td>
			<td>{{ $stock->product->sub_category->name }}</td>
			<td>{{ $stock->product->unit->name }}</td>
			<td>{{ config('options.table_sunat.moneda_symbol.'.$stock->product->currency_id) }}</td>
			<td>{{ $stock->product->value }}</td>
			<td>{{ $stock->product->price }}</td>
			<td>{{ $stock->product->value_cost }}</td>
			<td>{{ $stock->product->price_cost }}</td>
			<td>{{ $stock->stock }}</td>
			<td>{{ $stock->stock_min }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
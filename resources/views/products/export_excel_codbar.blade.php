<table class="table table-hover table-condensed">
    <thead>
        <tr>
            <th>Código</th>
            <th>Descripcion</th>
        </tr>
    </thead>
    <tbody id="table-report">
		@foreach($models as $model)
        	@for ($i = 0; $i < $model['cantidad']; $i++)
			<tr>
	            <td class="text-center">{{ $model['codigo'] }}</td>
	            <td>{{ $model['descripcion'] }}</td>
			</tr>
			@endfor
		@endforeach
    </tbody>
</table>
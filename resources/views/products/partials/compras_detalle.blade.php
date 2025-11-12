@if(empty($compras))
    <div class="py-3 text-muted">No se encontraron compras recientes.</div>
@else
    <table class="table table-sm table-bordered mb-0">
        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Factura</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">P_Unit</th>
                <th class="text-right">P_Total</th>
                <th>Mnd</th>
                <th>Proveedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $c)
                @php
                    $esImportacion = strpos($c->Tipo, 'IMP') === 0;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($c->Fecha)->format('Y-m-d') }}</td>
                    <td class="{{ $esImportacion ? 'table-info' : '' }}" title="{{ $esImportacion ? 'IMPORTACION' : '' }}">{{ $c->Factura }}</td>
                    <td class="text-right">{{ number_format($c->Cantidad, 2) }}</td>
                    <td class="text-right">{{ number_format($c->P_Unit, 4) }}</td>
                    <td class="text-right">{{ number_format($c->P_Total, 2) }}</td>
                    <td>{{ $c->Mnd }}</td>
                    <td>{{ $c->Proveedor }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

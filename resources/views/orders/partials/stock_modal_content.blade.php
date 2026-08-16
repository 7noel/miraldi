@if(isset($stockInfo) && $stockInfo->count())
<div class="mb-2 small text-muted">
    <span class="badge badge-danger p-1">&nbsp;</span> Comprar &nbsp;
    <span class="badge badge-warning p-1 ml-1">&nbsp;</span> Rotación alta &nbsp;
    <span class="badge badge-success p-1 ml-1">&nbsp;</span> OK
</div>
<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover mb-0">
        <thead class="thead-light">
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th class="text-center">Ctd</th>
                <th class="text-right">Stock SJM</th>
                <th class="text-right">Demanda</th>
                <th class="text-right">Libre</th>
                <th class="text-right">Faltante</th>
                <th>Otros Pedidos</th>
                <th class="text-right">Rot/Mes</th>
                <th class="text-center">Situación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockInfo as $item)
                @php
                    $codigoClass = $item->estado == 'comprar' ? 'table-danger'
                        : ($item->estado == 'atencion' ? 'table-warning' : 'table-success');
                    $badge = $item->estado == 'comprar'
                        ? '<span class="badge badge-danger">Comprar</span>'
                        : ($item->estado == 'atencion'
                            ? '<span class="badge badge-warning">Rotación</span>'
                            : '<span class="badge badge-success">OK</span>');
                    $primeros = array_slice($item->otros_pedidos, 0, 3);
                    $restantes = array_slice($item->otros_pedidos, 3);
                @endphp
                <tr>
                    <td class="{{ $codigoClass }}">{{ $item->codigo }}</td>
                    <td style="white-space: nowrap;">{{ $item->descripcion }}</td>
                    <td class="text-center">{{ number_format($item->cantidad, 2) }} {{ $item->unidad }}</td>
                    <td class="text-right">{{ number_format($item->stock_sjm, 2) }}</td>
                    <td class="text-right">{{ number_format($item->demanda_total, 2) }}</td>
                    <td class="text-right">{{ number_format($item->stock_libre, 2) }}</td>
                    <td class="text-right">
                        @if($item->faltante > 0)
                            <strong class="text-danger">{{ number_format($item->faltante, 2) }}</strong>
                        @else
                            <span class="text-muted">0.00</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        @forelse($primeros as $pedido)
                            <a href="{{ route('orders.edit', $pedido) }}" class="badge badge-info mr-1" target="_blank">{{ $pedido }}</a>
                        @empty
                            <span class="text-muted">—</span>
                        @endforelse
                        @if(count($restantes) > 0)
                            <a href="#" class="badge badge-secondary btn-expand-pedidos">+{{ count($restantes) }} más</a>
                            <span class="pedidos-extra d-none">
                                @foreach($restantes as $pedido)
                                    <a href="{{ route('orders.edit', $pedido) }}" class="badge badge-info mr-1" target="_blank">{{ $pedido }}</a>
                                @endforeach
                                <a href="#" class="badge badge-light border btn-collapse-pedidos">− Ver menos</a>
                            </span>
                        @endif
                    </td>
                    <td class="text-right">
                        {{ number_format($item->rotacion_mes, 2) }}
                        @if($item->estado == 'atencion')
                            <i class="fa fa-exclamation-triangle text-warning ml-1"></i>
                        @endif
                    </td>
                    <td class="text-center">{!! $badge !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<small class="text-muted d-block mt-2">
    <i class="fas fa-info-circle"></i>
    Demanda = AUTORIZADOS (15 días). Rotación = prom. mensual (90 días).
</small>
@else
<div class="alert alert-success mb-0"><i class="fa fa-check-circle"></i> Todo cubierto. No se requiere comprar.</div>
@endif
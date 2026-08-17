@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h4><i class="fa fa-ship text-primary"></i> Ventas de Productos Importados</h4>
        <a href="{{ route('reporte.importados.excel', ['desde' => $desdeInput, 'hasta' => $hastaInput]) }}" class="btn btn-success btn-sm">
            <i class="fa fa-file-excel"></i> Descargar Excel
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body py-2">
            <form class="form-inline" method="GET">
                <label class="mr-2 text-muted">Desde:</label>
                <input type="date" name="desde" value="{{ $desdeInput }}" class="form-control form-control-sm mr-3" style="width:160px;">
                <label class="mr-2 text-muted">Hasta:</label>
                <input type="date" name="hasta" value="{{ $hastaInput }}" class="form-control form-control-sm mr-3" style="width:160px;">
                <button class="btn btn-outline-primary btn-sm"><i class="fa fa-search"></i> Consultar</button>
                <small class="text-muted ml-3">({{ $models->count() }} productos vendidos importados)</small>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th colspan="5" class="text-center">IDENTIFICACIÓN</th>
                    <th colspan="11" class="text-center">COSTOS DE IMPORTACIÓN (USD)</th>
                    <th colspan="4" class="text-center">CONVERSIÓN / INGRESO</th>
                    <th colspan="4" class="text-center">VENTA (S/)</th>
                    <th colspan="3" class="text-center">RESULTADOS (S/)</th>
                </tr>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Importación</th>
                    <th>Und</th>
                    <th>FOB<br>Global</th>
                    <th>FOB<br>Unit</th>
                    <th>Flete</th>
                    <th>Seguro</th>
                    <th>VPE</th>
                    <th>Agente</th>
                    <th>Aduana</th>
                    <th>Ad Val</th>
                    <th>Transp.</th>
                    <th>G. Banc</th>
                    <th>Costo Unit<br>Aterrizado</th>
                    <th>T.C.</th>
                    <th>Costo Unit<br>Aterr. (S/)</th>
                    <th>Fec.<br>Ingreso</th>
                    <th>Cant.<br>Importada</th>
                    <th>Ctd<br>Vendida</th>
                    <th>Precio<br>Lista</th>
                    <th>Precio<br>Venta</th>
                    <th>Importe<br>Venta</th>
                    <th>Costo<br>Vendido</th>
                    <th>Ganancia</th>
                    <th>Margen<br>Real</th>
                </tr>
            </thead>
            <tbody>
                @forelse($models as $item)
                    @php
                        $margenClass = $item->margen < 0 ? 'table-danger' : ($item->margen < 15 ? 'table-warning' : 'table-success');
                    @endphp
                    <tr>
                        <td>{{ $item->codigo }}</td>
                        <td style="white-space: nowrap;">{{ $item->descripcion }}</td>
                        <td style="white-space: nowrap;">{{ $item->proveedor }}</td>
                        <td>{{ $item->importacion }}</td>
                        <td class="text-center">{{ $item->unidad }}</td>
                        <td class="text-right">{{ number_format($item->fob_global, 2) }}</td>
                        <td class="text-right">{{ number_format($item->fob_unit, 4) }}</td>
                        <td class="text-right">{{ number_format($item->flete, 2) }}</td>
                        <td class="text-right">{{ number_format($item->seguro, 2) }}</td>
                        <td class="text-right">{{ number_format($item->gastos_vpe, 2) }}</td>
                        <td class="text-right">{{ number_format($item->gastos_agente, 2) }}</td>
                        <td class="text-right">{{ number_format($item->gastos_aduan, 2) }}</td>
                        <td class="text-right">{{ number_format($item->ad_valorem, 2) }}</td>
                        <td class="text-right">{{ number_format($item->transporte, 2) }}</td>
                        <td class="text-right">{{ number_format($item->gastos_banc, 2) }}</td>
                        <td class="text-right">{{ number_format($item->costo_unit_usd, 4) }}</td>
                        <td class="text-right">{{ number_format($item->tipo_cambio, 3) }}</td>
                        <td class="text-right">{{ number_format($item->costo_unit_sol, 4) }}</td>
                        <td class="text-center">
                            @if($item->fecha_ingreso)
                                {{ \Carbon\Carbon::parse($item->fecha_ingreso)->format('d/m/Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($item->cant_importada, 2) }}</td>
                        <td class="text-center">{{ number_format($item->cantidad, 2) }}</td>
                        <td class="text-right">{{ number_format($item->precio_lista, 2) }}</td>
                        <td class="text-right">{{ number_format($item->precio_venta, 2) }}</td>
                        <td class="text-right">{{ number_format($item->importe_total, 2) }}</td>
                        <td class="text-right">{{ number_format($item->costo_vendido, 2) }}</td>
                        <td class="text-right {{ $item->ganancia < 0 ? 'text-danger' : '' }}">{{ number_format($item->ganancia, 2) }}</td>
                        <td class="text-right {{ $margenClass }}">{{ number_format($item->margen, 2) }}%</td>
                    </tr>
                @empty
                    <tr><td colspan="27" class="text-center text-muted">No se encontraron ventas de productos importados en el rango.</td></tr>
                @endforelse
            </tbody>
            <tfoot class="thead-light">
                <tr>
                    <th colspan="4" class="text-right">TOTALES</th>
                    <th></th>
                    <th class="text-right">{{ number_format($models->sum('fob_global'), 2) }}</th>
                    <th colspan="9"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2"></th>
                    <th class="text-right">{{ number_format($models->sum('cantidad'), 2) }}</th>
                    <th colspan="3"></th>
                    <th class="text-right">{{ number_format($models->sum('importe_total'), 2) }}</th>
                    <th class="text-right">{{ number_format($models->sum('costo_vendido'), 2) }}</th>
                    <th class="text-right">{{ number_format($models->sum('ganancia'), 2) }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <small class="text-muted">
        <i class="fas fa-info-circle"></i>
        Costos de importación en USD (última importación con costo > 0 e ingreso anterior a la venta).
        Conversión a soles con el tipo de cambio de esa importación. Margen = (Venta − Costo vendido) / Venta × 100.
    </small>
</div>
@endsection
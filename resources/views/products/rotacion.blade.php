@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- === ENCABEZADO === --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h4 class="mb-2">
            <i class="fa fa-sync text-primary"></i> 
            Reporte de Rotación de Productos 
            <span class="badge badge-light border ml-2">{{ $dias }} días</span>
        </h4>
    </div>

    {{-- === FILTROS Y LEYENDA === --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body py-2">

            <div class="row align-items-center">
                {{-- FILTROS DE FECHA --}}
                <div class="col-md-7 d-flex flex-wrap align-items-center mb-2 mb-md-0">
                    <form class="form-inline" method="GET">
                        <label class="mr-2 text-muted">Desde:</label>
                        <input type="date" name="desde" value="{{ $fechaInicioInput }}" 
                               class="form-control form-control-sm mr-3" style="width:160px;">
                        <label class="mr-2 text-muted">Hasta:</label>
                        <input type="date" name="hasta" value="{{ $fechaFinInput }}" 
                               class="form-control form-control-sm mr-3" style="width:160px;">
                        <button class="btn btn-primary btn-sm mr-2">
                            <i class="fa fa-search"></i> Consultar
                        </button>
                    </form>

	                {{-- BUSCADOR --}}
	                <input type="text" id="buscar" 
	                       class="form-control form-control-sm mr-2" 
	                       placeholder="Buscar por código, descripción o proveedor..."
	                       style="max-width: 300px;">

	                {{-- CONTADOR DE REGISTROS --}}
	                <small id="contador-registros" class="text-muted">
	                    ({{ count($data) }} registros)
	                </small>
                </div>

                {{-- LEYENDA A LA DERECHA --}}
                <div class="col-md-5 text-md-right small">
                    <div class="d-inline-flex align-items-center mr-3">
                        <span class="badge badge-danger mr-2" style="width:20px;height:12px;">&nbsp;</span>
                        <span class="text-muted">Sin stock total</span>
                    </div>
                    <div class="d-inline-flex align-items-center mr-3">
                        <span class="badge badge-warning mr-2" style="width:20px;height:12px;">&nbsp;</span>
                        <span class="text-muted">Falta stock almacén SJM</span>
                    </div>
                    <div class="d-inline-flex align-items-center">
                        <span class="badge badge-light mr-2 border" style="width:20px;height:12px;">&nbsp;</span>
                        <span class="text-muted">Stock suficiente</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- === BUSCADOR === --}}
    <div class="d-flex align-items-center mb-3">
    </div>


    <div class="table-responsive">
        <table id="tabla-rotacion" class="table table-bordered table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Unidad</th>
                    <th>Cant_Ven</th>
                    <th>Prom_Mes</th>
                    <th>Stock_SJM</th>
                    <th>Stock_PH</th>
                    <th>Moneda</th>
                    <th>Costo</th>
                    <th>Cant_Comp</th>
                    <th>Fec_Compra</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
				    @php
				        $stock01     = $item->Stock_01 ?? 0;
				        $stock03     = $item->Stock_03 ?? 0;
				        $stockTotal  = $stock01 + $stock03;
				        $prom        = $item->Prom_Mes ?? 0;
				        $promClass   = '';   // color solo para la celda
				        $icon        = '';   // icono para indicar estado
				        $title       = '';

				        if ($prom > $stockTotal) {
				            $promClass = 'table-danger';  // rojo claro
				            $icon = '<i class="fa fa-exclamation-circle text-danger ml-1" title="Demanda mayor al stock total"></i>';
				            $title = "NO HAY STOCK SUFICIENTE EN LOS ALMACENES";
				        } elseif ($prom > $stock01) {
				            $promClass = 'table-warning'; // amarillo claro
				            $icon = '<i class="fa fa-exclamation-triangle text-warning ml-1" title="Falta stock en almacén 01"></i>';
				            $title = "NO HAY STOCK SUFICIENTE EN EL ALMACEN DE SJM";
				        }
				    @endphp
                    <tr>
                        <td>
                        	<a href="#" class="ver-compras" data-codigo="{{ $item->Codigo }}" data-descripcion="{{ $item->Descripcion }}" title="VER ULTIMAS COMPRAS">
					        	{{ $item->Codigo }}
					    	</a>
						</td>
                        <td>{{ $item->Descripcion }}</td>
                        <td>{{ $item->Unidad }}</td>
                        <td class="text-right">{{ number_format($item->Cant_Ven, 2) }}</td>
				        {{-- === CELDA CRÍTICA: PROMEDIO MENSUAL === --}}
				        <td class="text-right {{ $promClass }} text-nowrap" title="{{ $title }}">
				            {!! number_format($prom, 2) . '' . $icon !!}
				        </td>
                        <td class="text-right">{{ number_format($item->Stock_01, 2) }}</td>
                        <td class="text-right">{{ number_format($item->Stock_03, 2) }}</td>
                        <td>{{ $item->Moneda }}</td>
                        <td class="text-right">{{ number_format($item->Costo, 2) }}</td>
                        <td class="text-right">{{ number_format($item->Cant_Comp, 2) }}</td>
                        <td>
						    @if(!empty($item->Fec_Compra))
						        {{ \Carbon\Carbon::parse($item->Fec_Compra)->format('d/m/Y') }}
						    @else
						        <span class="text-muted">—</span>
						    @endif
						</td>
                        <td class="{{ $item->EsImportacion ? 'table-info' : '' }}" title="{{ $item->EsImportacion ? 'IMPORTACION' : '' }}">{{ $item->Proveedor }}</td>
                    </tr>
                @empty
                    <tr><td colspan="12" class="text-center text-muted">No se encontraron registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalCompras" tabindex="-1" role="dialog" aria-labelledby="tituloModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Últimas Compras</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div id="contenidoModal" class="table-responsive text-center text-muted">
            Cargando información...
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    // Filtra la tabla en tiempo real al escribir
    $('#buscar').on('keyup', function () {
        const valor = $(this).val().toLowerCase().trim();
        
        $('#tabla-rotacion tbody tr').each(function () {
            const textoFila = $(this).text().toLowerCase();
            $(this).toggle(textoFila.indexOf(valor) > -1);
        });
    });
});
</script>

<script>
$(document).ready(function () {

    // cuando se hace clic en un código de producto
    $(document).on('click', '.ver-compras', function (e) {
        e.preventDefault();

        const codigo = $(this).data('codigo');
        const descripcion = $(this).data('descripcion');
        const $modal = $('#modalCompras');
        const $contenido = $('#contenidoModal');

        // título del modal
        $('#tituloModal').html(`Últimas Compras<br><small class="text-primary">${codigo} - ${descripcion}</small>`);

        // contenido temporal
        $contenido.html('<div class="py-3 text-secondary">Cargando <i class="fa fa-spinner fa-spin"></i></div>');

        // abrir modal
        $modal.modal('show');

        // llamada AJAX al backend
        $.get("{{ route('compras.detalle') }}", { codigo: codigo })
            .done(function (html) {
                $contenido.html(html);
            })
            .fail(function () {
                $contenido.html('<div class="text-danger py-3">Error al cargar los datos.</div>');
            });
    });

    const $tabla = $('#tabla-rotacion');
    const $filas = $tabla.find('tbody tr');
    const $contador = $('#contador-registros');

    function actualizarContador() {
        const visibles = $tabla.find('tbody tr:visible').length;
        $contador.text(`(${visibles} registro${visibles === 1 ? '' : 's'})`);
    }

    // inicial
    actualizarContador();

    // al escribir en el buscador
    $('#buscar').on('keyup', function () {
        const valor = $(this).val().toLowerCase().trim();

        $filas.each(function () {
            const textoFila = $(this).text().toLowerCase();
            $(this).toggle(textoFila.indexOf(valor) > -1);
        });

        actualizarContador();
    });
});
</script>

@endsection

@extends('layouts.app')

@section('title', "Comprobantes del Pedido {$id}")

@section('content')
<div class="container-fluid py-4">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <h4 class="mb-2">
            <i class="fa fa-file-invoice text-primary"></i>
            Comprobantes del Pedido <strong>{{ $id }}</strong>
        </h4>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Regresar
        </a>
    </div>

    @if ($facturas->isEmpty())
        <div class="alert alert-warning text-center shadow-sm">
            <i class="fa fa-exclamation-triangle"></i>
            No se encontraron facturas ni comprobantes asociados a este pedido.
        </div>
    @else
        {{-- === LISTADO DE COMPROBANTES === --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light border-bottom fw-bold text-secondary py-2">
                <i class="fa fa-list"></i> Lista de comprobantes
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th>Documento</th>
                                <th>Fecha</th>
                                <th class="d-none d-md-table-cell">RUC / DNI</th>
                                <th>Cliente</th>
                                <th>Importe</th>
                                <th>Moneda</th>
                                <th>Estado</th>
                                <th>Guia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturas as $factura)
                            <tr class="text-center">
                                <td data-label="Documento">
                                    <button 
                                        class="btn btn-sm btn-outline-primary btn-ver-pdf"
                                        data-ruta="{{ $factura->ruta }}"
                                        data-tipo="{{ $factura->tipo }}"
                                        data-serie="{{ $factura->serie }}"
                                        data-numero="{{ $factura->numero }}"
                                        title="Ver PDF">
                                        <i class="fa fa-file-pdf"></i> {{ $factura->tipo }} {{ $factura->serie }}-{{ $factura->numero }}
                                    </button>
                                </td>
                                <td data-label="Fecha">{{ $factura->fecha ? \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') : '' }}</td>
                                <td data-label="RUC / DNI" class="d-none d-md-table-cell">{{ $factura->ruc }}</td>
                                <td data-label="Cliente" class="text-start">{{ $factura->cliente }}</td>
                                <td data-label="Importe" class="text-end">{{ number_format($factura->importe, 2) }}</td>
                                <td data-label="Moneda">{{ $factura->moneda ?? '—' }}</td>
                                <td data-label="Estado">
                                    @php $estado = strtoupper($factura->estado ?? ''); @endphp
                                    @if(str_contains($estado, 'APROBADO'))
                                        <span class="badge bg-success text-white">APROBADO</span>
                                    @elseif(str_contains($estado, 'PENDIENTEXML'))
                                        <span class="badge bg-warning text-white">PENDIENTE</span>
                                    @elseif(str_contains($estado, 'ANULADO'))
                                        <span class="badge bg-danger text-white">ANULADO</span>
                                    @elseif(str_contains($estado, 'RECHAZADO'))
                                        <span class="badge bg-dark text-white">RECHAZADO</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $estado ?? '—' }}</span>
                                    @endif
                                </td>
                                <td data-label="Guia">
                                    @if($factura->guia_numero != '')
                                        <a href="{{ route('guia.view', ['id'=>$factura->guia]) }}">{{ $factura->guia_serie.'-'.$factura->guia_numero }}</a>
                                    @endif
                                 </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- === VISOR PDF === --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
                <div>
                    <i class="fa fa-file-pdf"></i>
                    <span id="pdfTitle">Vista previa del comprobante</span>
                </div>
                <small class="opacity-75">Pedido: {{ $id }}</small>
            </div>
            <div class="card-body p-0 text-center" style="height: 85vh; background: #f8f9fa;">
                <iframe id="iframePdf" src="" width="100%" height="100%" style="border: none;"></iframe>
            </div>
        </div>
    @endif
</div>

{{-- Script JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const botones = document.querySelectorAll('.btn-ver-pdf');
    const iframe = document.getElementById('iframePdf');
    const pdfTitle = document.getElementById('pdfTitle');

    // Detectar si el usuario está en un dispositivo móvil
    const isMobile = /Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i.test(navigator.userAgent);

    botones.forEach(btn => {
        btn.addEventListener('click', function () {
            const ruta = this.dataset.ruta;
            const tipo = this.dataset.tipo;
            const serie = this.dataset.serie;
            const numero = this.dataset.numero;
            const url = "{{ route('ver-pdf') }}?ruta=" + encodeURIComponent(ruta);

            if (isMobile) {
                // 👉 En celulares: abrir en nueva pestaña
                window.open(url, '_blank');
            } else {
                // 👉 En PC: mostrar en el iframe
                pdfTitle.textContent = `${tipo}-${serie}-${numero}`;
                iframe.src = url;
                window.scrollTo({ top: iframe.offsetTop - 70, behavior: 'smooth' });
            }
        });
    });

    if (isMobile) {
    // Ocultar Visor en moviles
        document.querySelector('.card.shadow-sm.border-0:last-of-type').style.display = 'none';
    } else {
    // Mostrar automáticamente el primero SOLO en PC
        @if($facturas->isNotEmpty())
            const primeraRuta = @json($facturas->first()->ruta);
            const primerTipo = @json($facturas->first()->tipo);
            const primeraSerie = @json($facturas->first()->serie);
            const primerNumero = @json($facturas->first()->numero);
            pdfTitle.textContent = `${primerTipo}-${primeraSerie}-${primerNumero}`;
            iframe.src = "{{ route('ver-pdf') }}?ruta=" + encodeURIComponent(primeraRuta);
        @endif
    }
});
</script>

<style>
    .table thead th { vertical-align: middle; }
    .card-header small { font-size: .8rem; }
    iframe { transition: opacity 0.4s ease; }
    .btn-ver-pdf {
        white-space: nowrap;       /* 🔒 impide saltos de línea */
        text-overflow: ellipsis;   /* 🔸 si algún texto es muy largo, lo recorta con “...” */
        overflow: hidden;
        max-width: 100%;           /* mantiene el ancho dentro de su celda */
        display: inline-flex;      /* alinea ícono y texto correctamente */
        align-items: center;       /* centra verticalmente el ícono */
        gap: 4px;                  /* separa el ícono del texto */
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 4px; /* pequeñas filas flotantes */
    }

    .table thead th {
        vertical-align: middle;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.03em;
    }

    .table tbody tr {
        background: #fff;
        box-shadow: 0 1px 2px rgba(0,0,0,0.08);
        transition: transform 0.1s ease, box-shadow 0.1s ease;
    }


    .table tbody td {
        vertical-align: middle;
        font-size: 0.9rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .table thead {
            display: none; /* oculta encabezado en móviles para vista tipo cards */
        }
        .table tbody tr {
            display: block;
            margin-bottom: 0.75rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .table tbody td {
            display: flex;
            justify-content: space-between;
            text-align: right;
            padding: 0.5rem 1rem;
        }
        .table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            text-align: left;
        }
    }

</style>
@endsection

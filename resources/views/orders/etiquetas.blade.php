@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 col-xl-6 mx-auto">

            {{-- CARD PRINCIPAL --}}
            <div class="card shadow-sm border-0 card-etiquetas">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="fa fa-tag text-primary mr-1"></i>
                        Etiquetas para Guía {{ $cab->GRENUMSER }}-{{ $cab->GRENUMDOC }}
                    </h5>
                    <small class="text-muted d-block mt-2">
                        <strong>Cliente:</strong> {{ $cab->RECEPTORRAZSOCIAL }}<br>
                        <strong>Dirección:</strong> {{ $cab->LLEGADADIRECCION }}
                    </small>
                </div>

                <div class="card-body">

                    <form action="{{ route('etiquetas.imprimir') }}" method="POST" id="form-etiquetas">
                        @csrf

                        <input type="hidden" name="cliente" value="{{ $cab->RECEPTORRAZSOCIAL }}">
                        <input type="hidden" name="guia" value="{{ $cab->GRENUMSER }}-{{ $cab->GRENUMDOC }}">
                        <input type="hidden" name="direccion" value="{{ $cab->LLEGADADIRECCION }}">
                        <input type="hidden" name="pedido" value="{{ $cab->CFNUMPED }}">

                        {{-- FILA: bultos a imprimir + cantidad --}}
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="bultos_seleccionados" class="mb-1">
                                    Bultos a imprimir (opcional)
                                </label>
                                <input type="text" name="bultos_seleccionados" id="bultos_seleccionados" 
                                    class="form-control form-control-sm" 
                                    placeholder="Ej: 1-5,8,10">
                                <small class="text-muted">
                                    Si lo dejas vacío imprime todos.
                                </small>
                            </div>

                            <div class="form-group col-md-5">
                                <label for="bultos" class="mb-1">Cantidad de bultos</label>
                                <input type="number" id="bultos" name="bultos" 
                                    class="form-control form-control-sm" 
                                    min="1" autocomplete="off">
                            </div>
                        </div>

                        {{-- SECCIÓN PESOS --}}
                        <div class="form-group mb-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted small text-uppercase font-weight-bold">
                                    Pesos por bulto
                                </span>
                                <small class="text-muted">
                                    Completa el peso de cada bulto (kg)
                                </small>
                            </div>
                            <div id="contenedor-pesos"></div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-success btn-sm px-4">
                                <i class="fa fa-print mr-1"></i> Imprimir etiquetas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- BOTÓN REIMPRIMIR ÚLTIMA IMPRESIÓN --}}
            @if(session()->has('etiquetas.last_print'))
                @php
                    $last = session('etiquetas.last_print');
                @endphp

                <div class="card border-0 shadow-sm mt-3 bg-light card-ultima-impresion">
                    <div class="card-body py-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted text-uppercase small font-weight-bold mb-1">
                                Última impresión guardada
                            </div>
                            <div class="small">
                                <strong>Guía:</strong> {{ $last['guia'] ?? '' }}<br>
                                <strong>Cliente:</strong> {{ $last['cliente'] ?? '' }}<br>
                                <strong>Bultos:</strong> {{ $last['bultos'] ?? '' }}
                            </div>
                        </div>

                        <button type="button" id="btn-reimprimir-llenar" class="btn btn-outline-warning btn-sm">
                            <i class="fa fa-history mr-1"></i>
                            Reimprimir última (llenar datos)
                        </button>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
(function () {
    const bultosInput      = document.getElementById('bultos');
    const contenedorPesos  = document.getElementById('contenedor-pesos');
    const form             = document.getElementById('form-etiquetas');

    // 👉 Dar focus al cargar la página
    if (bultosInput) bultosInput.focus();

    // 1. Generar inputs de pesos ni bien se escribe la cantidad de bultos
    bultosInput.addEventListener('input', function () {
        let cant = parseInt(this.value, 10) || 0;
        contenedorPesos.innerHTML = '';

        if (cant <= 0) return;

        for (let i = 1; i <= cant; i++) {
            const group = document.createElement('div');
            group.className = 'form-group peso-row mb-2';
            group.innerHTML = `
                <label class="mb-1">Peso del bulto ${i}</label>
                <div class="input-group input-group-sm">
                    <input type="number" step="0.01" min="0" 
                           class="form-control peso-input"
                           name="pesos[${i}]" 
                           data-index="${i}" 
                           autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>
            `;
            contenedorPesos.appendChild(group);
        }
    });

    // 2. Validar que todos los pesos tengan valor
    function validarPesos() {
        const pesoInputs = contenedorPesos.querySelectorAll('.peso-input');

        if (pesoInputs.length === 0) {
            alert('Primero indique la cantidad de bultos.');
            bultosInput.focus();
            return false;
        }

        for (const input of pesoInputs) {
            if (input.value === '' || isNaN(parseFloat(input.value))) {
                alert('Todos los pesos deben tener un valor.');
                input.focus();
                return false;
            }
        }

        return true;
    }

    // 3. Enter en "bultos" -> primer peso
    bultosInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            if (!this.value || parseInt(this.value, 10) <= 0) {
                return;
            }

            const primerPeso = contenedorPesos.querySelector('.peso-input');
            if (primerPeso) {
                primerPeso.focus();
            }
        }
    });

    function focusSiguienteInput(actual) {
        const inputs = Array.from(
            document.querySelectorAll('#bultos, .peso-input')
        );

        const idx = inputs.indexOf(actual);

        if (idx >= 0 && idx < inputs.length - 1) {
            inputs[idx + 1].focus();
        } else if (idx === inputs.length - 1) {
            if (validarPesos()) {
                form.requestSubmit();
            }
        }
    }

    contenedorPesos.addEventListener('keydown', function (e) {
        if (e.target.classList.contains('peso-input') && e.key === 'Enter') {
            e.preventDefault();
            focusSiguienteInput(e.target);
        }
    });

    form.addEventListener('submit', function (e) {
        if (!validarPesos()) {
            e.preventDefault();
            return;
        }

        const ok = confirm('¿Desea imprimir las etiquetas?');
        if (!ok) {
            e.preventDefault();
        }
    });

    // === SI HAY DATOS EN SESSION, PREPARAMOS EL BOTÓN REIMPRIMIR ===
    @if(session()->has('etiquetas.last_print'))
        const lastPrint = @json(session('etiquetas.last_print'));
        const btnReimprimir = document.getElementById('btn-reimprimir-llenar');

        if (btnReimprimir && lastPrint) {
            btnReimprimir.addEventListener('click', function () {
                if (!lastPrint.bultos || !lastPrint.pesos) {
                    alert('No hay datos suficientes de la última impresión.');
                    return;
                }

                bultosInput.value = lastPrint.bultos;
                bultosInput.dispatchEvent(new Event('input'));

                const pesos = lastPrint.pesos || {};
                Object.keys(pesos).forEach(function (idx) {
                    const input = document.querySelector('input[name="pesos[' + idx + ']"]');
                    if (input) {
                        input.value = pesos[idx];
                    }
                });

                const firstPeso = document.querySelector('.peso-input');
                if (firstPeso) firstPeso.focus();
            });
        }
    @endif
    
})();
</script>

<style>
    .card-etiquetas .card-header h5 {
        font-weight: 600;
    }

    .card-etiquetas label {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .peso-row {
        background-color: #f9fafb;
        border-radius: .35rem;
        padding: .35rem .5rem .6rem;
    }

    .peso-row:nth-child(odd) {
        background-color: #f3f4f6;
    }

    .card-ultima-impresion {
        border-left: 4px solid #ffc107;
    }

    @media (max-width: 767.98px) {
        .card-etiquetas .card-header {
            flex-direction: column;
        }
    }
</style>
@endsection

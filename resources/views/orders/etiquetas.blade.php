@extends('layouts.app')

@section('content')
<div class="container">

    <h4>Etiquetas para Guia {{ $cab->GRENUMSER }}-{{ $cab->GRENUMDOC }}</h4>
    <p><strong>Cliente:</strong> {{ $cab->RECEPTORRAZSOCIAL }}</p>
    <p><strong>Dirección:</strong> {{ $cab->LLEGADADIRECCION }}</p>

    <form action="{{ route('etiquetas.imprimir') }}" method="POST" id="form-etiquetas">
        @csrf

        <input type="hidden" name="cliente" value="{{ $cab->RECEPTORRAZSOCIAL }}">
        <input type="hidden" name="guia" value="{{ $cab->GRENUMSER }}-{{ $cab->GRENUMDOC }}">
        <input type="hidden" name="direccion" value="{{ $cab->LLEGADADIRECCION }}">
        <input type="hidden" name="pedido" value="{{ $cab->CFNUMPED }}">

        <div class="form-group">
            <label>Cantidad de bultos</label>
            <input type="number" id="bultos" name="bultos" class="form-control" min="1" autocomplete="off">
        </div>

        <div id="contenedor-pesos"></div>

        <button type="submit" class="btn btn-success mt-3">Imprimir etiquetas</button>
    </form>
</div>

<script>
(function () {
    const bultosInput      = document.getElementById('bultos');
    const contenedorPesos  = document.getElementById('contenedor-pesos');
    const form             = document.getElementById('form-etiquetas');

    // 👉 Dar focus al cargar la página
    bultosInput.focus();

    // 1. Generar inputs de pesos ni bien se escribe la cantidad de bultos
    bultosInput.addEventListener('input', function () {
        let cant = parseInt(this.value, 10) || 0;
        contenedorPesos.innerHTML = '';

        if (cant <= 0) {
            return;
        }

        for (let i = 1; i <= cant; i++) {
            const group = document.createElement('div');
            group.className = 'form-group mt-2';
            group.innerHTML = `
                <label>Peso del bulto ${i} (kg)</label>
                <input type="number" step="0.01" min="0" 
                       class="form-control peso-input"
                       name="pesos[${i}]" 
                       data-index="${i}" 
                       autocomplete="off">
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

    // Helper: ir al siguiente input (bultos + pesos)
    function focusSiguienteInput(actual) {
        const inputs = Array.from(
            document.querySelectorAll('#bultos, .peso-input')
        );

        const idx = inputs.indexOf(actual);

        if (idx >= 0 && idx < inputs.length - 1) {
            // Hay siguiente input -> enfocar
            inputs[idx + 1].focus();
        } else if (idx === inputs.length - 1) {
            // Último peso -> validar y enviar con confirmación
            if (validarPesos()) {
                form.requestSubmit(); // dispara evento submit (con confirm)
            }
        }
    }

    // 3 y 4. Enter en pesos -> siguiente; en el último -> confirmar e imprimir
    contenedorPesos.addEventListener('keydown', function (e) {
        if (e.target.classList.contains('peso-input') && e.key === 'Enter') {
            e.preventDefault();
            focusSiguienteInput(e.target);
        }
    });

    // Confirmación y validación también al usar el botón "Imprimir etiquetas"
    form.addEventListener('submit', function (e) {
        // Validar pesos
        if (!validarPesos()) {
            e.preventDefault();
            return;
        }

        // Confirmar impresión
        const ok = confirm('¿Desea imprimir las etiquetas?');
        if (!ok) {
            e.preventDefault();
        }
    });
})();
</script>
@endsection

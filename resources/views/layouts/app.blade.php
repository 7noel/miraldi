<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpeg" href="/img/icono_miraldi.gif" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        a.mi-enlace {
            color: #0000EE;
            text-decoration: none;
        }

        a.mi-enlace:visited {
            color: #0000EE;
        }

        a.mi-enlace:hover {
            color: #0000EE;
        }

        a.mi-enlace:active {
            color: #0000EE;
        }
        #spinner {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .form-container {
            position: relative;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1000;
        }
        .spinner-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1001;
        }
        .paint-canvas {
          border: 1px black solid;
          display: block;
          margin: 1rem;
        }

        .color-picker {
          margin: 1rem 1rem 0 1rem;
        }
    </style>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Jquery ui js -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- Print JS -->
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Condensed&family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Encode Sans Condensed', sans-serif;
            /*font-family: 'Roboto', sans-serif;*/
            /*font-family: 'Roboto Condensed', sans-serif;*/
        }
        th {
            text-wrap: balance;
        }
        td, td span {
            text-wrap: pretty;
        }
        .ui-autocomplete {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .ui-autocomplete {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 13px;
            text-align: left;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
        }

        .ui-autocomplete > li > div {
            display: block;
            padding: 2px 10px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333333;
            white-space: nowrap;
        }

        .ui-state-hover,
        .ui-state-active,
        .ui-state-focus {
            text-decoration: none;
            color: #262626;
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .ui-helper-hidden-accessible {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
        .ui-menu-item div:hover {
            /*background-color: #007bff;*/
            background-color: #17a2b8;
            color: white;
        }
        ul.ui-autocomplete.ui-menu {
          z-index: 1050;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="{{ config('options.styles.navbar') }}">
            <div class="container-fluid">
                <a class="navbar-brand link" href="{{ url('/') }}">
                    <!-- <img src="/img/logo_makim_doc.jpg" alt="" height="50px"> -->
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @inject('menu','App\Http\Controllers\MenuController')
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                @if( !Auth::guest() )

                    @foreach($menu->links() as $modulo => $links)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $modulo }}</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($links as $link)
                                @if(isset($link['div']))
                                <div class="dropdown-divider"></div>
                                @endif
                                @if(isset($link['route']))
                                <a class="dropdown-item link" href="{{ route($link['route']) }}">{{ $link['name'] }}</a>
                                @else
                                <a class="dropdown-item link" href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                                @endif
                            @endforeach
                            </div>
                        </li>
                    @endforeach
                @endif

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('companies.register') and 1==0)
                                <li class="nav-item">
                                    <a class="nav-link link" href="{{ route('companies.register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item link" href="{{ route('change_password') }}">Cambiar Contraseña</a>
                                    <a class="dropdown-item link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="overlay" id="overlay"></div>
            <div id="spinner" class="text-center spinner-container">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
                <p>Cargando...</p>
            </div>
            @yield('content')
        </main>
    </div>
    <script>
$(document).ready(function () {
    $('#inputBusqueda').on('input', function() {
        // Obtener el valor del input y eliminar los espacios en blanco al inicio y final
        var valor = $(this).val().trim();

        // Comprobar si el valor tiene exactamente 4 caracteres
        if (valor.length >= 4) {
            // Realizar la petición GET si tiene 4 caracteres
            $.get(`/apiGetProductos/${valor}`, function(data) {
                // Aquí puedes manejar la respuesta de la API
                console.log(data);

                $('#table-products').empty()
                $.each(data, function (index, Obj) {
                    presentacion = ((Obj.APESO>1) ? round(Obj.APESO) : 1)
                    precio = ((Obj.price == null) ? 0 : Number(Obj.price.PRE_ACT).toFixed(2))
                    stock_disponible = (Obj.stock == null) ? 0 : (parseInt(0+Obj.stock.STSKDIS));
                    $tr = `<tr>
                                <td class="text-center text-codigo">${Obj.ACODIGO}</td>
                                <td class="text-center text-codigo">${Obj.ACODIGO2}</td>
                                <td class="text-description">${Obj.ADESCRI}</td>
                                <td class="text-center no-almacen">${Obj.ACODMON} ${precio}</td>
                                <td class="text-center text-unidad">${Obj.AUNIDAD}</td>
                                <td class="text-center text-presentacion">${presentacion}</td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <a href="#" onclick="verMovimientos(event, '${Obj.ACODIGO}')" class="btn btn-outline-info btn-sm" title="Historial"><i class="fas fa-history"></i></a>
                                    <a href="/products/${Obj.ACODIGO}" class="btn btn-outline-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="/products/${Obj.ACODIGO}/edit" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                </td>
                            </tr>`
                    $('#table-products').append($tr)
                })
            });
        }
    });
    $(".link").on('click', function (e) {
        $('#overlay').show()
        $('#spinner').show()
    })
    $(".form-loading").submit(function( event ) {
        $('button[type=submit]').attr("disabled", true)
        $('#overlay').show()
        $('#spinner').show()
    })
    $('#precio_base, #gastos_admin, #utilidad').change(function () {
        base = parseFloat($('#precio_base').val())
        admin = parseFloat($('#gastos_admin').val())
        utilidad = parseFloat($('#utilidad').val())
        precio = Math.round(base * (100 + admin) * (100 + utilidad)/ 100) / 100
        $('#precio').text(precio)
    })
    $('.click-form').click(function (e) {
        e.preventDefault()
        if (confirm("¿Seguro que desea guardar los cambios?")) {
            console.log('adentro del formulario picking')
            $("#form-picking-create").submit()
        }
    })

    $("#form-oc").submit(function (e) {
        e.preventDefault()
        get_oc()
    })

    $("#btn-excel-codbar").click(function(e) {
        e.preventDefault()
        // eliminar los elementos con clase "input-excel"
        $(".input-excel").remove()

        i = 0
        $(".select").each(function() {
            codigo = $(this).children().eq(1).text()
            descripcion = $(this).children().eq(2).text()
            cantidad = $(this).children().eq(0).find(".text-cantidad-codbar").val()
            elements = `<input class="input-excel" name="products[${i}][codigo]" type="hidden" value="${codigo}">
            <input class="input-excel" name="products[${i}][descripcion]" type="hidden" value="${descripcion}">
            <input class="input-excel" name="products[${i}][cantidad]" type="hidden" value="${cantidad}">`
            $("#form-excel-codbar").append(elements)
            i = i + 1
        })
        // eliminar clase "style", ocultar los "tr" y eliminar las "cantidades" de los input en los tr
        $("#table-report tr").removeClass("style")
        $("#table-report tr").css("display","none")
        $("#table-report tr td input").val('')
        $("#ocompra").val('')
        $("#search").val('')
        // Enviar formulario
        $("#form-excel-codbar").submit()
    })

    $("#btn-codbar-save").click(function(e) {
        e.preventDefault()
        i = 0
        $(".select").each(function() {
            codigo = $(this).children().eq(1).text()
            descripcion = $(this).children().eq(2).text()
            cantidad = $(this).children().eq(0).find(".text-cantidad-codbar").val()
            elements = `<input class="input-excel" id="codigo_${i}" name="products[${i}][codigo]" type="hidden" value="${codigo}">
            <input class="input-excel" id="descripcion_${i}" name="products[${i}][descripcion]" type="hidden" value="">
            <input class="input-excel" id="cantidad_${i}" name="products[${i}][cantidad]" type="hidden" value="${cantidad}">`
            $("#form-codbar-save").append(elements)

            $(`#codigo_${i}`).val(codigo)
            $(`#descripcion_${i}`).val(descripcion)
            i = i + 1
        })
        $("#form-codbar-save").submit()
        // alert('Se guardaron los registros')
        //window.location.reload()
    })

    $(".text-cantidad-codbar").change(function () {
        $input = $(this)
        if ($input.val() > 0) {
            $input.parent().parent().addClass("select")
        } else {
            $input.parent().parent().removeClass("select")
        }
    })

    n = $('#discount_2').val()
    n = Math.round(parseFloat(n)*1000000)/1000000
    if (isNaN(n)) {n = 0}
    $('#discount_2').val(n)
    window.descuento2 = n
    $("#discount_2").change(function () {
        n = $("#discount_2").val()
        window.descuento2 = $("#discount_2").val()
    })
    //n = $(myElement).parent().parent().find(id).val()
    n = $("#CFPORDESCL").val()
    n = Math.round(parseFloat(n)*1000000)/1000000
    if (isNaN(n)) {n = 0}
    $("#CFPORDESCL").val(n)
    window.descuento1 = n
    // if ($('#is_downloadable').length) {
    //     $('.is_downloadable').val($('#is_downloadable').val())
    // }
    $("#CFPORDESCL").change(function () {
        n = $("#CFPORDESCL").val()
        window.descuento1 = $("#CFPORDESCL").val()
        // $(".txtDscto").val(n)
        calcTotal()
    })
    $("#form-buscar-codigo").submit(function(e){
        e.preventDefault()
        get_product()
    })

    $("#form-picking-qr").submit(function(e){
        e.preventDefault()
        get_picking()
    })
    $("#form-add-picking").submit(function(e){
        e.preventDefault()
        addPrPicking()
    })
    $('#check-cantidad-pk').change(function() {
        if($(this).is(":checked")) {
            $('.pk-div-cantidad').removeClass("d-none")
            $('#cantidad').focus()
            $('#cantidad').select()
        } else {
            $('.pk-div-cantidad').addClass('d-none')
            $('#cantidad').val('1')
            $('#codigo').focus()
        }
    })
    $("#btn-image-load").click(function (e) {
        $("#image_base64").val(document.querySelector("#canvas").toDataURL('image/jpeg').replace(/^data:image\/jpeg;base64,/, ""))
    })
    $(".pagar-venta").click(function(e){
        //console.log($(this).data('id'))
        m_id = $(this).data('id')

        $.get(`/get_cpe/${m_id}`, function(data){
            //console.log(data)
            $("#pagarModalLabel").html(data.sn)
            if (data.currency_id==2) {
                $("#currency_id").html('DOLARES')
            } else {
                $("#currency_id").html('SOLES')
            }
            $("#total").html(data.total)
            $("#deuda").html((data.total-data.amortization).toFixed(2))
            $('#metodo option').filter(function() {
                return !this.value || $.trim(this.value).length == 0 || $.trim(this.text).length == 0
            }).remove()
        })
    })
    $('.btn-anular').click(function(e){
        e.preventDefault();
        var row = $(this).parents('tr');
        var id = row.data('id');
        var tipo = row.data('tipo');
        var form = $('#form-delete');
        var url = form.attr('action').replace(':_ID', id);
        var data = form.serializeArray();
        // row.fadeOut();

        if (!confirm(`Seguro que desea anular ${tipo} ?`)) {
            e.preventDefault();
            return false;
        }
        
        $.post(url, data, function(result){
            //console.log(result);
            alert(`${tipo}-${result.sn} fue anulado`)
            //alert(result.message);
            row.find('.status').html('<span class="badge badge-danger">ANUL</span>')
            row.find('.btn-anular').fadeOut()
        }).fail(function(){
            alert(`${tipo} no fue anulado`)
            // row.show();
        });
    });

    // $('#p_value').change(function () {
    //     x = Math.round($('#p_value').val()*118)/100
    //     $('#p_price').val(x)
    // })
    // $('#p_price').change(function () {
    //     x = Math.round($('#p_price').val()*10000/118)/100
    //     $('#p_value').val(x)
    // })
    // $('#p_value_cost').change(function () {
    //     x = Math.round($('#p_value_cost').val()*118)/100
    //     $('#p_price_cost').val(x)
    // })
    // $('#p_price_cost').change(function () {
    //     x = Math.round($('#p_price_cost').val()*10000/118)/100
    //     $('#p_value_cost').val(x)
    // })
    if ($('#with_tax').val() == 1) {
        $('.withTax').show()
        $('.withoutTax').hide()
    } else {
        $('.withTax').hide()
        $('.withoutTax').show()
    }

    $('#with_tax').change(function(){
        $('.withTax').toggle()
        $('.withoutTax').toggle()
    })

    $(document).on('click', '.btn-delete-item', function (e) {
        e.preventDefault()
        $(this).parent().parent().remove()
        calcTotal()
    })

    $(document).on('click', '.btn-edit-item', function (e) {
        e.preventDefault()
        window.el = $(this).parent().parent()
        editModalProduct()
        setTimeout(function() {
            $('#txtCantidad').focus()
            $('#txtCantidad').select()
        }, 500)
    })

    $(document).on('change','#txtCantidad, #txtPrecio, #txtValue, #txtDscto2', function (e) {
        calcTotalItem(this)
    });

    //autocomplete para elementos agregados por javascript
    // $(document).on('focus','x.txtProduct', function (e) {
    //     $this = this
    //     if ( !$($this).data("autocomplete") ) {
    //         e.preventDefault()
    //         $($this).autocomplete({
    //             source: "/api/products/autocompleteAjax",
    //             minLength: 4,
    //             select: function(event, ui){
    //                 $p = ui.item.id
    //                 $($this).parent().parent().find('.categoryId').val($p.category_id)
    //                 $($this).parent().parent().find('.subCategoryId').val($p.sub_category_id)
    //                 if ($('#is_downloadable')) {
    //                     $($this).parent().parent().find('.is_downloadable').val($p.is_downloadable)
    //                 }
    //                 $($this).parent().parent().find('.productId').val($p.ACODIGO)
    //                 $($this).parent().parent().find('.txtProduct').val($p.ADESCRI)
    //                 $($this).parent().parent().find('.unitId').val($p.AUNIDAD)
    //                 $($this).parent().parent().find('.txtValue').val($p.price.PRE_ACT) // PRE_ACT es precio sin IGV
    //                 $($this).parent().parent().find('.txtPrecio').val((($p.price.PRE_ACT*118)/100).toFixed(6))
    //                 $($this).parent().parent().find('.txtDscto').val(window.descuento1)
    //                 $($this).parent().parent().find('.txtDscto2').val(window.descuento2)
    //                 $($this).parent().parent().find('.intern_code').text($p.ACODIGO)
    //                 $($this).parent().parent().find('.txtCantidad').focus()
    //             }
    //         })
    //     }
    // })

    //Autocomplete de productos
    $('#txtProducto').autocomplete({
        source: "/api/products/autocompleteAjax",
        minLength: 4,
        select: function(event, ui){
            $p = ui.item.id
            if (existCodeInList($p.ACODIGO)) {
                alert(`El código "${$p.ACODIGO}" ya fue registrado.`)
                setTimeout(function() {
                    clearModalProduct()
                }, 100)
            } else {
                $('#txtCodigo').text($p.ACODIGO)
                $('#txtProduct').val($p.ADESCRI)
                $('#unitId').val($p.AUNIDAD)
                $('#txtValue').val(parseFloat($p.price.PRE_ACT)) // PRE_ACT es precio sin IGV
                $('#txtPrecio').val((($p.price.PRE_ACT*118)/100).toFixed(6))
                $('#txtDscto2').val(window.descuento2)
                $('#txtCantidad').val(1)
                stk = 0
                if ($p.stock.hasOwnProperty('STSKDIS') && $p.stock.STSKDIS != null) {
                    stk = ($p.stock.STSKDIS*1).toFixed(0)
                }
                $('#alert-stock').text(`Stock: ${stk} ${$p.AUNIDAD}`)
                if (stk > 0) {
                    $('#alert-stock').addClass(`badge-info`)
                    $('#alert-stock').removeClass(`badge-danger`)
                } else {
                    $('#alert-stock').removeClass(`badge-info`)
                    $('#alert-stock').addClass(`badge-danger`)
                }
                setTimeout(function() { // El retardo es necesario para los moviles
                    $('#txtCantidad').focus()
                    $('#txtCantidad').select()
                }, 100)
                $('#label-cantidad').text($p.AUNIDAD)
                calcTotalItem()
            }
        }
    })

    $('#btnAddProduct').click(function(e){
        e.preventDefault()
        delete window.el
        clearModalProduct()
        setTimeout(function() {
            $('#txtProducto').focus()
        }, 500)
    })

    $('#btn-add-product').click(function(e){
        e.preventDefault()
        addRowProduct2()
    })

    my_company = $('#my_company').val()
    $('#txtCompany').autocomplete({
        source: "/api/companiesAutocomplete/",
        minLength: 4,
        select: function(event, ui){
            $('#company_id').val(ui.item.id.CCODCLI)
            $('#address').val(ui.item.id.CDIRCLI)
            $('#doc').val(ui.item.id.CNUMRUC)
        }
    })
    $('#txtProvider').autocomplete({
        source: "/api/companies/autocompleteAjax/providers/"+my_company+"/",
        minLength: 4,
        select: function(event, ui){
            $('#company_id').val(ui.item.id)
        }
    })

    $('#txtShipper').autocomplete({
        source: "/api/shippersAutocomplete/",
        minLength: 4,
        select: function(event, ui){
            $('#shipper_id').val(ui.item.id.TRACODIGO)
        }
    })

    // $('#btnNewAttribute').click(function() {
    //     var items = $('#items-attribute').val()
    //     console.log("items = " + items)
    //     if (items>0 && $("input[name='attributes["+(items-1)+"][id]']").val() == "") {
    //         $("input[name='attributes["+(items-1)+"][name]']").focus()
    //     } else {
    //         renderTemplateRowAttribute()
    //     }
    // })

    changeIdType()
    $('#id_type').change(function(){
        changeIdType()
    });

    $('#doc').change(function(){
        var doc = $('#doc').val()
        $('#doc').val(doc)
        var type = $('#id_type').val()
        if (doc.length == 11 && type == '6') {
            getDataPadron(doc, type)
        }else if (doc.length == 8 && type == '1') {
            getDataPadron(doc, type)
        }
    });

    //changeCountry()

    // $('#country').change(function(){
    //     changeCountry()
    // });
    //carga departamentos
    $('#departamento').change(function(){
        cargaProvincias()
    });
    //carga provincias
    $('#provincia').change(function(){
        cargaDistritos()
    })

    $(document).on('change', '.text-uppercase', function (e) {
        var cadena=$(this).val().trim()
        cadena = cadena.replace("  "," ")
        cadena = cadena.toUpperCase()
        $(this).val(cadena)
    })

})

function activarPedido(pedido) {
    var userConfirmed = confirm(`¿Estás seguro de que deseas activar el Pedido ${pedido}?`);
    
    if (userConfirmed) {
        console.log(pedido)
        // El usuario hizo clic en "Aceptar"0000629
        // alert("Pedido Activado")
        // $("#btnActivarPedido").attr('disabled', 'disabled')
        window.location.href = `/activar_pedido/${pedido.toString().padStart(7, '0')}`
        // Aquí puedes ejecutar el código para eliminar el elemento
    } else {
        // El usuario hizo clic en "Cancelar"
        alert("Activación cancelada")
    }
}

function PdfToPrint(id) {
    url = `/pdf_to_print/${id}`
    console.log(url)
    $.get(url, function (data) {
        console.log(data)
    })
}

function quitar_spinner() {
    $('#overlay').hide()
    $('#spinner').hide()
    $('button[type=submit]').attr("disabled", false)
}

function get_oc() {
    oc = $("#ocompra").val()
    url = `/get_oc/${oc}`
    $.get(url, function(data){
        var oc_codigos = data.map((obj) => obj.OC_CCODIGO)
        //console.log(data)
        $("#table-report tr").each(function(){
            this.style.display = "none";
            codigo = $(this).children().eq(1).text()
            orden = oc_codigos.indexOf(codigo)
            if (orden >-1) {
                cantidad = parseInt(data[orden].OC_NCANTID)
                pres = $(this).children().eq(4).text()
                if (cantidad > 1 && pres >1) {cantidad = cantidad / pres}
                if (cantidad < 1) {cantidad = 1}
                $(this).children().eq(0).find(".text-cantidad-codbar").val(cantidad)
                $(this).addClass("select")
                this.style.display = "";
            }

        })
        quitar_spinner()
    })
}

/*function excel_codbar() {
    var box = {}; // my object
    var boxes =  []; // my array
    $(".select").each(function (index, el) {
        box = {
            cantidad : $(el).find('.text-cantidad-codbar').val(),
            codigo : $(el).find('.text-codigo').text(),
            description : $(el).find('.text-description').text()
        }
        boxes.push(box)
    })
    $.post('/excel_codbars_download', boxes, function(result){
        console.log(result);
    })
}*/

function filtro_tabla(table_report_warehouse) {
  // Declare variables 
  var input, filter, table, tr, td, i, j, visible;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  size = filter.length
  table = document.getElementById(table_report_warehouse);
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    visible = false;
    /* Obtenemos todas las celdas de la fila, no sólo la primera */
    td = tr[i].getElementsByTagName("td");
    for (j = 0; j < td.length; j++) {
      if (size>3 && td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
        visible = true;
      }
    }
    if (visible === true) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
}

function existCodeInList(code) {
    existe_codigo = false
    $('#tableItems tr').each(function (index, vtr) {
        codigo = $(vtr).find('.productId').val()
        if (codigo == code) {
            existe_codigo = true
        }
    })
    return existe_codigo
}

function clearModalProduct() {
    $('#txtProducto').addClass("form-control")
    $('#txtProducto').removeClass("form-control-plaintext")
    $('#txtProducto').attr('readonly', false)

    $('#txtProducto').focus()
    $('#txtProducto').val("")
    $('#txtProduct').val("")
    $('#txtCodigo').text("")
    $('#unitId').val("")
    $('#txtCantidad').val("0")
    $('#txtValue').val("0")
    $('#txtDscto2').val(window.descuento2)
    $('#txtTotal').val("0.00")
    $('#label-cantidad').text('')

    $('#alert-stock').addClass("badge-info")
    $('#alert-stock').removeClass("badge-danger")
    $('#alert-stock').text("")
    items = $('#items').val()
    max = 50
    $('#alert-items').text(`Items registrados: ${items}`)
    if (items < max) {
        $('#alert-items').removeClass("badge-danger")
        $('#alert-items').addClass("badge-light")
        $('#btn-add-product').prop("disabled", false);
    } else {
        $('#alert-items').addClass("badge-danger")
        $('#alert-items').removeClass("badge-light")
        $('#btn-add-product').prop("disabled", true);
    }
}

function editModalProduct() {
    items = $('#items').val()
    max = 50
    $('#alert-items').text(`Items registrados: ${items}`)
    $('#btn-add-product').prop("disabled", false);
    if (items < max) {
        $('#alert-items').removeClass("badge-danger")
        $('#alert-items').addClass("badge-light")
    } else {
        $('#alert-items').addClass("badge-danger")
        $('#alert-items').removeClass("badge-light")
    }

    $('#txtProducto').removeClass("form-control")
    $('#txtProducto').addClass("form-control-plaintext")
    $('#txtProducto').attr('readonly', true)

    $('#txtProducto').val(window.el.find('.txtProduct').val())
    $('#txtProduct').val(window.el.find('.txtProduct').val())
    $('#txtCodigo').text(window.el.find('.productId').val())
    $('#unitId').val(window.el.find('.unitId').val())
    $('#txtCantidad').val(window.el.find('.txtCantidad').val())
    $('#txtValue').val(window.el.find('.txtValue').val())
    $('#txtDscto2').val(window.el.find('.txtDscto2').val())
    $('#txtTotal').val(window.el.find('.txtTotal').text())
    $('#txtPriceItem').val(window.el.find('.txtPriceItem').text())
    $('#spanPriceItem').text(window.el.find('.txtPriceItem').text())
    $('#label-cantidad').text(window.el.find('.unitId').val())
    $('#exampleModalx').modal('show')
}

function addRowProduct2() {
    //obteniendo los valores de los inputs
    desc = $('#txtProducto').val()
    codigo = $('#txtCodigo').text()
    if (codigo == "") {
        $('#txtProducto').val("")
        $('#txtProduct').val("")
        $('#txtProducto').focus()
        return false;
    }
    u = $('#unitId').val()
    //console.log(u)
    q = $('#txtCantidad').val()
    if (!isNaN(q) && q <= 0) {
        $('#txtCantidad').val("")
        $('#txtCantidad').focus()
        return false;
    }
    v = $('#txtValue').val()
    if (!isNaN(v) && v <= 0) {
        $('#txtValue').val("")
        $('#txtValue').focus()
        return false;
    }
    d1 = window.descuento1
    d2 = parseFloat($('#txtDscto2').val())
    t = $('#txtTotal').val()
    if (typeof window.el === 'undefined') { // Si no existe la variable window.el (producto a editar) se agrega una fila
        items = $('#items').val()
        //preparando fila <tr>
        tr = `<tr>
            <input class="unitId" name="details[${items}][DFUNIDAD]" type="hidden" value="${u}">
            <td><span class='spanCodigo'>${codigo}</span><input class="productId" name="details[${items}][DFCODIGO]" type="hidden" value="${codigo}"></td>
            <td><span class='spanProduct'>${desc}</span><input class="txtProduct" name="details[${items}][DFDESCRI]" type="hidden" value=""></td>
            <td class="text-center"><span class='spanCantidad text-right'>${q} ${u}</span><input class="txtCantidad" name="details[${items}][DFCANTID]" type="hidden" value="${q}"></td>
            <td class="withTax text-right"><span class='spanPrecio'>${v*1.18}</span><input class="txtPrecio" name="details[${items}][price]" type="text" value="${v*1.18}"></td>
            <td class="withoutTax text-right"><span class='spanValue'>${v}</span><input class="txtValue" name="details[${items}][DFPREC_ORI]" type="hidden" value="${v}"></td>
            <td class="text-center"><span class='spanDscto2'>${d2}</span><input class="txtDscto2" name="details[${items}][DFPORDES]" type="hidden" value="${d2}"></td>
            <td class="withTax text-right"> <span class='txtTotal'>${t}</span> </td>
            <td class="withoutTax text-right"> <span class='txtPriceItem'>${t*1.18}</span> </td>
            <td class="text-center" style="white-space: nowrap;">
                <a href="#" class="btn btn-outline-primary btn-sm btn-edit-item" title="Editar">{!! $icons['edit'] !!}</a>
                <a href="#" class="btn btn-outline-danger btn-sm btn-delete-item" title="Eliminar"><i class="far fa-trash-alt"></i></a>
            </td>
        </tr>`
        //console.log(tr)

        $("#tableItems").append(tr)
        $(`input[name="details[${items}][DFDESCRI]"]`).val(desc)
        items = parseInt(items) + 1
        $('#items').val(items)

        if ($('#with_tax').val() == 1){
            $('.withTax').show()
            $('.withoutTax').hide()
        } else {
            $('.withTax').hide()
            $('.withoutTax').show()
        }

    } else {

        // window.el.find('.txtProduct').val($('#txtProduct').val())
        // window.el.find('.spanProduct').text($('#txtProduct').val())
        // window.el.find('.txtCodigo').val($('#txtCodigo').val())
        // window.el.find('.spanCodigo').text($('#txtCodigo').val())
        // window.el.find('.unitId').val($('#unitId').val())
        window.el.find('.txtCantidad').val(q)
        window.el.find('.spanCantidad').text(q+' '+u)
        window.el.find('.txtValue').val(v)
        window.el.find('.spanValue').text(v)
        window.el.find('.txtDscto2').val(d2)
        window.el.find('.spanDscto2').text(d2)

        $('#exampleModalx').modal('hide')
    }
    calcTotal()
    // window.descuento2 = d2
    clearModalProduct()

    // Grabando en la base de datos
    form = $(".form-loading")
    var actionUrl = form.attr('action')
    var formData = form.serialize()
    $.ajax({
        url: actionUrl, // Cambia esto por la URL de tu API
        type: 'POST',
        data: formData,
        success: function(response) {
            // Manejar la respuesta exitosa
            console.log('Datos guardados con éxito: ' + response)
        },
        error: function(xhr, status, error) {
            // Manejar el error
            console.log('Error al guardar los datos: ' + error)
        }
    })

}

function get_product() {
    codigo = $("#codigo").val()
    url = $('#form-buscar-codigo').attr('action').replace('ID', codigo)
    
    $.get(url, function(data){
        if (data.hasOwnProperty('ACODIGO') && data.ACODIGO != null) {
            $("#codigo").val('')
            $("#codigox").text(data.ACODIGO)
            $("#cod_fab").text(data.ACODIGO2)
            $("#name").text(data.ADESCRI)
            if (data.family.hasOwnProperty('FAM_NOMBRE') && data.family.FAM_NOMBRE != null) {
                $("#family").text(data.family.FAM_NOMBRE)
            } else {
                $("#family").text('')
            }
            if (data.stock.hasOwnProperty('STSKDIS') && data.stock.STSKDIS != null) {
                $("#stock").text(`${(data.stock.STSKDIS*1).toFixed(2)} ${data.AUNIDAD}`)
            } else {
                $("#stock").text('')
            }
            if (data.price.hasOwnProperty('PRE_ACT') && data.price.PRE_ACT != null) {
                $("#currency").text(data.price.MON_PRE)
                $("#price").text(data.price.PRE_ACT*1)
            } else {
                $("#price").text('SIN PRECIO')
            }
            $("#locker").text(data.lockers.map(function(locker){return locker.TCASILLERO}).join(';'))
            $('#product-details').removeClass('d-none')
        } else {
            $('#product-details').addClass('d-none')
            $("#codigox").text('')
            $("#cod_fab").text('')
            $("#name").text('')
            $("#family").text('')
            $("#currency").text('')
            $("#price").text('')
            $("#stock").text('')
            $("#locker").text('')
            alert(`No se encontró el código ${codigo} en la base de datos`)
            $("#codigo").val('')
        }
    })
}

function addPrPicking() {
    quantity = parseInt($("#cantidad").val().trim())
        
    code = $("#codigo").val().trim()
    if (code == '') {
        $("#codigo").focus()
        return false
    }
    code_exist = false
    item_ready = false
    order_ready = true
    play_music = true
    // Recorre los tr
    var contador = 0
    $("#table-picking tr").each(function(){
        contador = contador + 1
        let codigo = $(this).children().eq(0).find('a')
        let codigo2 = $(this).children().eq(1) // codigo de fabricante
        es_total = parseInt($("#es").val())
        es = parseInt($(this).children().eq(4).text())
        pl = parseInt($(this).children().eq(3).text())
        // Cuando encuentra el código interno o el de fabrica
        if ((codigo.text() != '' && codigo.text() == code) || (codigo2.text() == code && codigo.text() != '')) {
            $row = $(this)
            if (!$('#check-cantidad-pk').is(":checked")) {
                quantity = parseInt($(this).children().eq(5).text())
            }
            code_exist = true
            es = quantity + es
            $(this).children().eq(4).text(es)
            $(this).find(".es").val(es)
            es_total += quantity
            if (pl == es) {
                // Cuando se completa un item
                $(this).addClass("table-success")
                $(this).removeClass("table-danger")
                $(this).removeClass("table-warning")
                item_ready = true
            } else if (pl < es) {
                // Cuando excede la cantidad de unidades
                audio = document.getElementById("audio-error")
                audio.play()
                play_music = false
                opcion = confirm("El item ya está completo, ¿desea omitir la ultima lectura?")
                if (opcion == false) {
                    // Si se agrega la lectura del scaner
                    play_music = true
                    $(this).removeClass("table-success")
                    $(this).addClass("table-danger")
                    $(this).removeClass("table-warning")
                } else {
                    // Si se omite la lectura del scaner
                    $(this).children().eq(4).text(es - quantity)
                    $(this).find(".es").val(es - quantity)
                    es_total -= quantity
                }
            } else {
                // Cuando aún no se completa el item
                $(this).removeClass("table-success")
                $(this).removeClass("table-danger")
                $(this).addClass("table-warning")
            }
            $("#es").val(es_total)
        }
        if (pl > es) { order_ready = false }
    })
    console.log(`pl: ${pl}, es: ${es}, code_exist:${code_exist}, item_ready: ${item_ready}, order_ready: ${order_ready}`)
    if (code_exist) {
        $row.insertBefore($('#table-picking tr:first'))
    }
    if (!code_exist) {
        audio = document.getElementById("audio-error")
        audio.play()
        console.log('error')
        alert("No se encontró el código")
    } else if (play_music) {
        if (order_ready) {
            audio = document.getElementById("audio-success_3")
            window.navigator.vibrate([200, 100, 200])
            audio.play()
        } else if (item_ready) {
            audio = document.getElementById("audio-success_2")
            audio.play()
        } else if (code_exist) {
            // audio = document.getElementById("audio-success")
            // audio.play()
        }
    }
    $("#codigo").val("")
    $("#codigo").focus()
}

function get_picking() {
    qr = $("#picking_qr").val().trim()
    qr = qr.replace(' ', ' ')
    vals = qr.split('|')
    orden_id = vals.shift()
    pl_total = 0
    $("#CFNUMPED").val(orden_id)
    $("#items").val(vals.length)
    var prs = {}
    $.each(vals, function (index, val) {
        arr = val.split(' ')
        prs[arr[0]] = parseInt(arr[1])
        // console.log(arr[0])
    })
    // console.log(prs)
    $.get(`/get_picking/${qr}`, function(data) {
        // console.log(data)
        $('#table-picking').empty()
        i = 0
        $.each(data.products, function (index, pr) {
            peso = ((pr.APESO > 1) ? parseInt(pr.APESO) : 1)
            ubicacion = pr.lockers.map(function(locker){return locker.TCASILLERO}).join(';')
            stock_disponible = (typeof pr.stock.STSKDIS === 'undefined') ? 0 : (parseInt(0+pr.stock.STSKDIS) - data.in_pickings[pr.ACODIGO]);
            tr=`<tr>
                    <td><a href="#" class="mi-enlace" onclick="verMovimientos(event, '${pr.ACODIGO}')" data-toggle="modal" data-target="#myModal">${pr.ACODIGO}</a></td>
                    <td>${pr.ACODIGO2}</td>
                    <td>${pr.ADESCRI}</td>
                    <td class="text-center">${prs[pr.ACODIGO]}</td>
                    <td class="text-center">0</td>
                    <td class="text-center">${peso}</td>
                    <td class="text-center">${stock_disponible}</td>
                    <td class="text-center">${ubicacion}</td>

                    <input type="hidden" class="codigo" name="details[${i}][codigo]" value="${pr.ACODIGO}">
                    <input type="hidden" class="codigo2" name="details[${i}][codigo2]" value="${pr.ACODIGO2}">
                    <input type="hidden" class="name" name="details[${i}][name]" value="${pr.ADESCRI}">
                    <input type="hidden" class="pl" name="details[${i}][pl]" value="${prs[pr.ACODIGO]}">
                    <input type="hidden" class="es" name="details[${i}][es]" value="0">
                </tr>`
            $('#table-picking').append(tr)
            i = i + 1
            pl_total += prs[pr.ACODIGO]
        })
        $("#pl").val(pl_total)
    })
    $('.qr').addClass('d-none')
    $('.picking').removeClass('d-none')
    $('#codigo').focus()
}

function verMovimientos(e, codigo) {
    e.preventDefault()

    page = `/movimientos/${codigo}`
    $.get(page, function(data){
        console.log(data)
        $('#exampleModal').modal('show')
        $('#table-movimientos').empty()
        $('#codigo_descripcion').text(`Producto: ${codigo} - ${data.product.ADESCRI}`)
        $('#stock').text(`Stock: ${0+data.stock}`)
        $('#stock_disponible').text(`Stock sin Embalar: ${data.stock - data.in_picking}`)
        $.each(data.movimientos, function (index, Obj) {
            if (Obj.invoiced_at == null) {
                $tr = `<tr>
                        <td class="text-center">${Obj.CFNUMPED}</td>
                        <td class="text-center">${Obj.picking_id}</td>
                        <td class="text-center">${Obj.created_at.split('T')[0]}</td>
                        <td class="text-center">${Obj.quantity}</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td>${Obj.user.name}</td>
                        <td>${Obj.order.CFNOMBRE}</td>
                    </tr>`
            } else {
                $tr = `<tr>
                        <td class="text-center">${Obj.CFNUMPED}</td>
                        <td class="text-center">${Obj.picking_id}</td>
                        <td class="text-center">${Obj.created_at.split('T')[0]}</td>
                        <td class="text-center">${Obj.quantity_invoiced}</td>
                        <td class="text-center">${Obj.invoice}</td>
                        <td class="text-center">${Obj.invoiced_at.split(' ')[0]}</td>
                        <td>${Obj.user.name}</td>
                        <td>${Obj.order.CFNOMBRE}</td>
                    </tr>`
            }
            $('#table-movimientos').append($tr)
        })
    })
}

function calcTotal () {
    var with_tax = false
    if ($('#with_tax').val() == 1) {
        with_tax = true
    }
    var gross_value = 0 // Valor Bruto, suma de subtotales
    var gross_precio = 0 // Precio Bruto, suma de subtotales
    var d_items = 0
    var subtotal = 0
    var total = 0
    var q,p,d1,d2,t,pu;
    $('#tableItems tr').each(function (index, vtr) {
        if (!($(vtr).find('.isdeleted').is(':checked'))) {
            q = parseFloat($(vtr).find('.txtCantidad').val())
            // v = parseFloat((($(vtr).find('.txtPrecio').val()*100)/118).toFixed(6))
            // p = parseFloat($(vtr).find('.txtPrecio').val())
            v = parseFloat($(vtr).find('.txtValue').val())
            p = parseFloat((($(vtr).find('.txtValue').val()*118)/100).toFixed(6))
            // v = p * 100 / (100 + 18);
            // v = parseFloat($(vtr).find('.txtValue').val());
            d1 = parseFloat(window.descuento1)
            _d1 = Math.round(q*v*d1*10000)/1000000
            d2 = parseFloat($(vtr).find('.txtDscto2').val())
            _d2 = Math.round((q*v-_d1)*d2*10000)/1000000
            discount = Math.round(1000000*(_d1 + _d2))/1000000
            vt = Math.round(1000000*(q*v-discount))/1000000 // total por item
            t = Math.round(1180000*(q*v-discount))/1000000
            $(vtr).find('.txtTotal').text( vt.toFixed(2) )
            $(vtr).find('.txtPriceItem').text( t.toFixed(2) )
            //console.log(`cantidad: ${q}, valor: ${v}, precio: ${p}, d1: ${_d1}, d2: ${_d2}, descuento: ${discount} ValorItem: ${vt}, PrecioTotal: ${t}`)


            gross_value += Math.round(100*q*v)/100
            gross_precio += Math.round(100*q*p)/100
            d_items += discount
            // subtotal += vt
            total += t
        }
    })
    d_items = Math.round(100*d_items)/100
    gross_value = Math.round(100 * gross_value) / 100
    gross_precio = Math.round(100 * gross_precio) / 100
    subtotal = Math.round(100*(gross_value - d_items))/100
    //console.log(`vbruto: ${gross_value}, descuentos: ${d_items}, subtotal: ${subtotal}, total: ${total}`)
    // subtotal = Math.round(100 * subtotal) / 100
    // total = Math.round(100 * total) / 100
    if (with_tax) {
        // subtotal = Math.round(10000 * total / 118) / 100
        // gross_value = Math.round(10000 * gross_precio / 118) / 100
        d_items = gross_value - subtotal
    } else {
        // total = Math.round(118 * subtotal) / 100
    }

    $('#mGrossValue').text(gross_value.toFixed(2))
    $('#mDiscount').text(d_items.toFixed(2))
    $('#mSubTotal').text(subtotal.toFixed(2))
    $('#mIgv').text((total-subtotal).toFixed(2))
    $('#mTotal').text(total.toFixed(2))
}

// function validateItem (myElement, id, decimales=2) {
//     n = $(myElement).parent().parent().find(id).val()
//     n = Math.round(parseFloat(n)*1000000)/1000000
//     if (isNaN(n)) {n=0.00}
//     $(myElement).parent().parent().find(id).val(n.toFixed(decimales))
//     //if (id=='.txtDscto') {window.descuento1 = n.toFixed(2)}
//     if (id=='.txtDscto2') {window.descuento2 = n.toFixed(2)}
//     return n
// }

function calcTotalItem (myElement) {
    q = parseFloat($('#txtCantidad').val())
    v = parseFloat($('#txtValue').val())
    p = parseFloat((v*118/100).toFixed(6))
    d1 = parseFloat(window.descuento1)
    d2 = parseFloat($('#txtDscto2').val())
    if (isNaN(q)) {
        q = 1
        $('#txtCantidad').val(q)
    }
    if (isNaN(v)) {
        v = 0
        v = $('#txtValue').val(v)
    }
    if (isNaN(d2)) {
        d2 = 0
        d2 = $('#txtDscto2').val(d2)
    }
    vt = 100*Math.round(q*v*(100-d1)*(100-d2))/1000000 // total por item
    t = 100*Math.round(q*p*(100-d1)*(100-d2))/1000000
    $('#txtTotal').val( vt.toFixed(2) )
    $('#txtPriceItem').val( t.toFixed(2) )
    $('#spanValueItem').text( vt.toFixed(2) )
    $('#spanPriceItem').text( t.toFixed(2) )
}

// function addRowProduct(data='') {
//     var items = $('#items').val()
//     if (items>0) {
//         if ($("input[name='details["+(items-1)+"][DFCODIGO]']").val() == "") {
//             $("input[name='details["+(items-1)+"][DFDESCRI]']").focus()
//         } else{
//             renderTemplateRowProduct(data)
//         };
//     } else{
//         renderTemplateRowProduct(data)
//     };
//     if ($('#with_tax').val() == 1){
//         $('.withTax').show()
//         $('.withoutTax').hide()
//     } else {
//         $('.withTax').hide()
//         $('.withoutTax').show()
//     }
// }

// function renderTemplateRowProduct (data) {
//     if (data != "") {
//         ele = document.getElementById("tableItems").lastElementChild.querySelector("[data-product]");
//         if (!isDesignEnabled(ele, data.id)) {return true}
//     }
//     var clone = activateTemplate("#template-row-item")
//     var items = $('#items').val()
//     clone.querySelector("[data-productid]").setAttribute("name", "details[" + items + "][DFCODIGO]")
//     clone.querySelector("[data-unitid]").setAttribute("name", "details[" + items + "][DFUNIDAD]")
//     clone.querySelector("[data-product]").setAttribute("name", "details[" + items + "][DFDESCRI]")
//     clone.querySelector("[data-cantidad]").setAttribute("name", "details[" + items + "][DFCANTID]")
//     clone.querySelector("[data-precio]").setAttribute("name", "details[" + items + "][price]")
//     clone.querySelector("[data-value]").setAttribute("name", "details[" + items + "][DFPREC_ORI]")
//     clone.querySelector("[data-dscto]").setAttribute("name", "details[" + items + "][CFPORDESCL]")
//     clone.querySelector("[data-dscto]").setAttribute("value", window.descuento1)
//     clone.querySelector("[data-dscto2]").setAttribute("name", "details[" + items + "][DFPORDES]")
//     clone.querySelector("[data-dscto2]").setAttribute("value", window.descuento2)
//     // clone.querySelector("[data-isdeleted]").setAttribute("name", "details[" + items + "][is_deleted]")
//     if (items>0) {$("input[name='details["+(items-1)+"][DFDESCRI]']").addClass('form-control-plaintext text')}
    
//     items = parseInt(items) + 1
//     $('#items').val(items)
//     $("#tableItems").append(clone)
//     el = document.getElementById("tableItems").lastElementChild.querySelector("[data-product]")
//     if (data != '') {
//         setRowProduct(el, data)
//     }

//     $("input[name='details["+(items-1)+"][DFDESCRI]']").focus()
// }
// function renderTemplateRowAttribute () {
//     var clone = activateTemplate("#template-row-attribute");
//     var items = $('#items-attribute').val()
//     clone.querySelector("[data-name]").setAttribute("name", "attributes[" + items + "][name]")
//     clone.querySelector("[data-value]").setAttribute("name", "attributes[" + items + "][value_1]")
//     clone.querySelector("[data-isdeleted]").setAttribute("name", "attributes[" + items + "][is_deleted]")
//     //if (items>0) {$("input[name='accessories["+(items-1)+"][name]']").attr('disabled', true);};
    
//     $("#tbodyAttributes").append(clone)
//     items = parseInt(items) + 1
//     $('#items-attribute').val(items)
// }

// function addRowBranch() {
//     var items = $('#items').val()
//     if (items>0) {
//         if ($("input[name='branches["+(items-1)+"][name]']").val() == "") {
//             console.log('en el segundo if')
//             $("input[name='branches["+(items-1)+"][name]']").focus()
//         } else if ($("input[name='branches["+(items-1)+"][address]']").val() == "") {
//             $("input[name='branches["+(items-1)+"][address]']").focus()
//         } else if ($("input[name='branches["+(items-1)+"][ubigeo_code]']").val() == "") {
//             $("input[name='branches["+(items-1)+"][ubigeo]']").focus()
//         } else{
//             renderTemplateRowBranch()
//         }
//     } else{
//         renderTemplateRowBranch()
//     }
// }

// function renderTemplateRowBranch () {
//     var clone = activateTemplate("#template-row-item");
//     var items = $('#items').val()
//     clone.querySelector("[data-branchId]").setAttribute("name", "branches[" + items + "][branch_id]")
//     clone.querySelector("[data-ubigeoId]").setAttribute("name", "branches[" + items + "][ubigeo_code]")
//     clone.querySelector("[data-name]").setAttribute("name", "branches[" + items + "][company_name]")
//     clone.querySelector("[data-address]").setAttribute("name", "branches[" + items + "][address]")
//     clone.querySelector("[data-ubigeo]").setAttribute("name", "branches[" + items + "][ubigeo]")
//     clone.querySelector("[data-mobile]").setAttribute("name", "branches[" + items + "][mobile]")
//     clone.querySelector("[data-contact]").setAttribute("name", "branches[" + items + "][contact]")
//     clone.querySelector("[data-isdeleted]").setAttribute("name", "branches[" + items + "][is_deleted]")
//     //if (items>0) {$("input[name='branches["+(items-1)+"][txtProduct]']").attr('disabled', true);};
    
//     items = parseInt(items) + 1
//     $('#items').val(items);
//     $("#tableItems").append(clone)

//     $("input[name='branches["+(items-1)+"][name]']").focus()
// }

function getDataPadron (doc, type) {
    urls = {"1":`https://dniruc.apisperu.com/api/v1/dni/${doc}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im5vZWwubG9nYW5AZ21haWwuY29tIn0.pSSHu1Rh3RUgPubnjemiDNyMAN0ZjgTCXaupa8VsEYY`, "6":`https://dniruc.apisperu.com/api/v1/ruc/${doc}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im5vZWwubG9nYW5AZ21haWwuY29tIn0.pSSHu1Rh3RUgPubnjemiDNyMAN0ZjgTCXaupa8VsEYY`}
    $.get(urls[type], function(data){
        if (data) {
            //console.log(data)
            if (type=='6') {
                $('#company_name').val(data.razonSocial)
                $('#paternal_surname').val('')
                $('#maternal_surname').val('')
                $('#name').val('')
                if (data.hasOwnProperty('ubigeo') && data.ubigeo != null) {
                    //$('#address').val(data.direccion.replace(` ${data.departamento} ${data.provincia} ${data.distrito}`, ''))
                    $('#address').val(data.direccion.replace(` ${data.departamento} ${data.provincia} ${data.distrito}`, '') + ` - ${data.distrito} - ${data.provincia} - ${data.departamento}`)
                    $('#departamento').val(data.departamento)
                    $('#provincia').val(data.provincia)
                    $('#ubigeo_code').val(data.ubigeo)
                }
            } else {
                $('#paternal_surname').val(data.apellidoPaterno)
                $('#maternal_surname').val(data.apellidoMaterno)
                $('#name').val(data.nombres)
                $('#company_name').val(`${data.apellidoPaterno} ${data.apellidoMaterno} ${data.nombres}`)
            }
            //console.log(data)
        }
    })
}

function changeIdType() {
    var id_type = $('#id_type').val()
    if (['1','4','7','A'].indexOf(id_type)!=-1) {
        $("#company_name").removeAttr("required", "required")
        $("#paternal_surname").attr("required", "required")
        // $("#maternal_surname").attr("required", "required")
        $("#name").attr("required", "required")

        $("#company_name").parent().parent().addClass("d-none")
        $("#brand_name").parent().parent().addClass("d-none")
        $("#paternal_surname").parent().parent().removeClass("d-none")
        $("#maternal_surname").parent().parent().removeClass("d-none")
        $("#name").parent().parent().removeClass("d-none")
    } else if (['6','-','0'].indexOf(id_type)!=-1){
        $("#company_name").attr("required", "required")
        $("#paternal_surname").removeAttr("required", "required")
        // $("#maternal_surname").removeAttr("required", "required")
        $("#name").removeAttr("required", "required")

        $("#company_name").parent().parent().removeClass("d-none")
        $("#brand_name").parent().parent().removeClass("d-none")
        $("#paternal_surname").parent().parent().addClass("d-none")
        $("#maternal_surname").parent().parent().addClass("d-none")
        $("#name").parent().parent().addClass("d-none")
    }
}


/*cargar provincias*/
function cargaProvincias(){
    var $dep = $('#departamento')
    var $pro = $('#provincia')
    var $dis = $('#ubigeo_code')
    var page ="/listarProvincias/" + $dep.val()
    if ($dep.val()=="") {
        $pro.empty("")
        $dis.empty("")
    } else {
        $.get(page, function(data){
            $pro.empty();
            $pro.append("<option value=''>Seleccionar</option>");
            $.each(data, function (index, ProvinciaObj) {
                $pro.append("<option value='"+ProvinciaObj.provincia+"'>"+ProvinciaObj.provincia+"</option>")
            });
        });
    }
}

/*cargar distritos*/
function cargaDistritos(){
    var $dep = $('#departamento')
    var $pro=$('#provincia')
    var $dis=$('#ubigeo_code')
    var page = "/listarDistritos/" + $dep.val() + "/" + $pro.val()
    if ($pro=='') {
        $dis.empty("")
    } else {
        $.get(page, function(data){
            $dis.empty()
            $dis.append("<option value=''>Seleccionar</option>");
            $.each(data, function (index, DistritoObj) {
                $dis.append("<option value='"+DistritoObj.code+"'>"+DistritoObj.distrito+"</option>")
            })
        })

    }
}

function changeCountry() {
    var country = $('#country').val()
    if (country == 'PE') {
        $('#departamento').attr( "required", "required" )
        $('#provincia').attr( "required", "required" )
        $('#ubigeo_code').attr( "required", "required" )

        $('#field_departamento').parent().show()
        $('#field_provincia').parent().show()
        $('#field_ubigeo_code').parent().show()
    } else {
        $('#departamento').removeAttr( "required" )
        $('#provincia').removeAttr( "required" )
        $('#ubigeo_code').removeAttr( "required" )

        $('#field_departamento').parent().hide()
        $('#field_provincia').parent().hide()
        $('#field_ubigeo_code').parent().hide()
    }
}
function activateTemplate (id) {
    var t = document.querySelector(id)
    return document.importNode(t.content, true)
}
function getCar() {
    placa = $('#placa').val().trim()
    url = `/getCar/${placa}`
    if (placa!='') {
        $.get(url, function(data){
            if (data.id) {
                $('#car_id').val(data.id)
                $('#company_id').val(data.company_id)
                $('#my_company').val(data.my_company)
                $('#attention').val(data.contact_name)
            } else {
                // Si no existe el input company_name (diferente a una cita), se blanquea los campos para agregar una placa que si existe en la BD.
                if ($('#company_name').length == 0) {
                    alert("Placa no registrada en el sistema")
                    $('#placa').val('')
                    $('#placa').focus()
                }
            }
        });
    }
}
function checkCar() {
    placa = $('#txtplaca').val().trim()
    url = `/getCar/${placa}`
    if (placa!='') {
        $.get(url, function(data){
            if (data.id) {
                alert("La Placa ya está registrada en el sistema")
                $('#txtplaca').val('')
                $('#txtplaca').focus()
            }
        });
    }
}

    </script>
    @yield('scripts')
</body>
</html>

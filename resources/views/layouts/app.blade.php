<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpeg" href="/img/favicon.png" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

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
    </style>
</head>
<body>
    <div id="app">
        <nav class="{{ config('options.styles.navbar') }}">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
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
                                <a class="dropdown-item" href="{{ route($link['route']) }}">{{ $link['name'] }}</a>
                                @else
                                <a class="dropdown-item" href="{{ $link['url'] }}">{{ $link['name'] }}</a>
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
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('companies.register') and 1==0)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('companies.register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
            @yield('content')
        </main>
    </div>
    <script>
$(document).ready(function () {
    // if ($('#is_downloadable').length) {
    //     $('.is_downloadable').val($('#is_downloadable').val())
    // }
    $("#form-add-picking").submit(function(e){
        e.preventDefault()
        addPrPicking()
    })
    $("#btn-image-load").click(function (e) {
        $("#image_base64").val(document.querySelector("#canvas").toDataURL('image/jpeg').replace(/^data:image\/jpeg;base64,/, ""))
    })
    $(".pagar-venta").click(function(e){
        console.log($(this).data('id'))
        m_id = $(this).data('id')

        $.get(`/get_cpe/${m_id}`, function(data){
            console.log(data)
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
            console.log(result);
            alert(`${tipo}-${result.sn} fue anulado`)
            //alert(result.message);
            row.find('.status').html('<span class="badge badge-danger">ANUL</span>')
            row.find('.btn-anular').fadeOut()
        }).fail(function(){
            alert(`${tipo} no fue anulado`)
            // row.show();
        });
    });

    $('#p_value').change(function () {
        x = Math.round($('#p_value').val()*118)/100
        $('#p_price').val(x)
    })
    $('#p_price').change(function () {
        x = Math.round($('#p_price').val()*10000/118)/100
        $('#p_value').val(x)
    })
    $('#p_value_cost').change(function () {
        x = Math.round($('#p_value_cost').val()*118)/100
        $('#p_price_cost').val(x)
    })
    $('#p_price_cost').change(function () {
        x = Math.round($('#p_price_cost').val()*10000/118)/100
        $('#p_value_cost').val(x)
    })
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

    $(document).on('change','.txtCantidad, .txtPrecio, .txtValue, .txtDscto, .txtDscto2', function (e) {
        calcTotalItem(this)
        calcTotal()
    });

    //autocomplete para elementos agregados por javascript
    $(document).on('focus','.txtProduct', function (e) {
        $this = this
        if ( !$($this).data("autocomplete") ) {
            e.preventDefault()
            $($this).autocomplete({
                source: "/api/products/autocompleteAjax",
                minLength: 4,
                select: function(event, ui){
                    $p = ui.item.id
                    $($this).parent().parent().find('.categoryId').val($p.category_id)
                    $($this).parent().parent().find('.subCategoryId').val($p.sub_category_id)
                    if ($('#is_downloadable')) {
                        $($this).parent().parent().find('.is_downloadable').val($p.is_downloadable)
                    }
                    $($this).parent().parent().find('.productId').val($p.id)
                    $($this).parent().parent().find('.txtProduct').val($p.name)
                    $($this).parent().parent().find('.unitId').val($p.unit_id)
                    $($this).parent().parent().find('.txtValue').val($p.value)
                    $($this).parent().parent().find('.txtPrecio').val($p.price)
                    $($this).parent().parent().find('.txtDscto').val(window.descuento1)
                    $($this).parent().parent().find('.txtDscto2').val(window.descuento2)
                    $($this).parent().parent().find('.intern_code').text($p.intern_code)
                    $($this).parent().parent().find('.txtCantidad').focus()
                }
            })
        }
    })

    $('#btnAddProduct').bind("click", function(e){
        e.preventDefault()
        addRowProduct()
    });

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
        source: "/api/companies/autocompleteAjax/shippers/"+my_company+"/",
        minLength: 4,
        select: function(event, ui){
            $('#shipper_id').val(ui.item.id)
            $('#branch_shipper_id').empty()
            $('#branch_shipper_id').append(`<option value=''>Seleccionar</option>`)
            ui.item.branches.forEach(function (b) {
                $('#branch_shipper_id').append(`<option value='${b.id}'>${b.company_name}</option>`)
            })
            $('#branch_shipper_id').focus()
        }
    })

    $('#btnNewAttribute').click(function() {
        var items = $('#items-attribute').val()
        console.log("items = " + items)
        if (items>0 && $("input[name='attributes["+(items-1)+"][id]']").val() == "") {
            $("input[name='attributes["+(items-1)+"][name]']").focus()
        } else {
            renderTemplateRowAttribute()
        }
    })

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

    $('#country').change(function(){
        changeCountry()
    });
    //carga departamentos
    $('#DEPARTAMENTO').change(function(){
        cargaProvincias()
    });
    //carga provincias
    $('#PROVINCIA').change(function(){
        cargaDistritos()
    })

    $(document).on('change', '.text-uppercase', function (e) {
        var cadena=$(this).val().trim()
        cadena = cadena.replace("  "," ")
        cadena = cadena.toUpperCase()
        $(this).val(cadena)
    })

    $('#btnAddBranch').click(function(e){
        addRowBranch()
    });

    $(document).on('focus','.txtUbigeo', function (e) {
        // console.log($(this));
        $var = {}
        $var.this = this;
        if ( !$($var.this).data("autocomplete") ) {
            e.preventDefault()
            $($var.this).autocomplete({
                source: "/api/ubigeos/autocompleteAjax",
                minLength: 2,
                select: function(event, ui){
                    console.log(ui)
                    var cod=ui.item.id
                    $($var.this).parent().parent().find('.ubigeoId').val(cod)
                }
            });
        }
    });
    $('#vin').change(function (e) {
        vin = $('#vin').val().trim().toUpperCase()
        $('#vin').val(vin) //3HGRM3830CG603778
        $('#codigo').val(vin.substring(3, 7))
        arr_years = {A:2010, B:2011, C:2012, D:2013, E:2014, F:2015, G:2016, H:2017, J:2018, K:2019, L:2020, M:2021, N:2022, P:2023, R:2024, S:2025, T:2026, V:2027, W:2028, X:2029, Y:2030, 1:2031, 2:2032, 3:2033, 4:2034, 5:2035, 6:2036, 7:2037, 8:2038, 9:2039}
        year = arr_years[vin.substring(9, 10)]
        $('#year').val(year)
    })
    $('#add_contact').change(function (e) {
        if ($('#add_contact').is(':checked')) {
            $('.contact').removeClass("d-none")
            $('#contact_name').attr("required", "required")
        } else {
            $('.contact').addClass( "d-none")
            $('#contact_name').removeAttr("required", "required")
        }
    })
    if ($('#add_contact').is(':checked')) {
        $('.contact').removeClass("d-none");
        $('#contact_name').attr("required", "required");
    }

    $('#placa').change(function (e) {
        getCar()
    })
    $('#txtplaca').change(function (e) {
        checkCar()
    })
    $('#type_service').change(function (e) {
        if ('PREVENTIVO' == $('#type_service').val()) {
            $('#preventivo').parent().parent().removeClass("d-none")
            $('#preventivo').attr("required", "required")
        } else {
            $('#preventivo').parent().parent().addClass( "d-none")
            $('#preventivo').removeAttr("required", "required")
        }
    })
   // $("#type_detail_p").prop("checked", true);
    $(".send_cpe").submit(function(e) {
        e.preventDefault()
        var form = $(this)
        //console.log(form.serializeArray()[0].value)
        console.log(form.serialize())
        var url = "/send_cpe?"+form.serialize();
        console.log(url)
        $('.dropdown-toggle').dropdown('hide')
        $.get(url, function(data){
            console.log(data)
        });
    })
})

function addPrPicking() {
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
    $("#table-picking tr").each(function(){
        let codigo = $(this).children().eq(0)
        es = parseInt($(this).children().eq(3).text())
        pl = parseInt($(this).children().eq(2).text())
        // Cuando encuentra el código
        if (codigo.text() == code) {
            code_exist = true
            es = 1 + es
            $(this).children().eq(3).text(es)
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
                    $(this).children().eq(3).text(es - 1)
                }
            } else {
                // Cuando aún no se completa el item
                $(this).removeClass("table-success")
                $(this).removeClass("table-danger")
                $(this).addClass("table-warning")
            }
        }
        if (pl > es) { order_ready = false }
    })
    if (!code_exist) {
        audio = document.getElementById("audio-error")
        audio.play()
        console.log('error')
        alert("No se encontró el código")
    } else if (play_music) {
        if (order_ready) {
            audio = document.getElementById("audio-success_3")
            console.log('order')
        } else if (item_ready) {
            audio = document.getElementById("audio-success_2")
            console.log('item')
        } else if (code_exist) {
            audio = document.getElementById("audio-success")
            console.log('codigo')
        }
        audio.play()
    }
    $("#codigo").focus()
}

function get_picking() {
    qr = $("#picking_qr").val().trim()
    vals = qr.split('|')
    orden_id = vals.shift()
    var prs = {}
    $.each(vals, function (index, val) {
        arr = val.split(' ')
        prs[arr[0]] = parseInt(arr[1])
        // console.log(arr[0])
    })
    // console.log(prs)
    $.get(`/get_picking/${qr}`, function(data){
        // console.log(data)
        $('#table-picking').empty()
        $.each(data.products, function (index, pr) {
            tr=`<tr>
                    <td>${pr.ACODIGO}</td>
                    <td>${pr.ADESCRI}</td>
                    <td>${prs[pr.ACODIGO]}</td>
                    <td>0</td>
                </tr>`
            $('#table-picking').append(tr)
        })
    })
    $('.qr').addClass('d-none')
    $('.picking').removeClass('d-none')
    $('#codigo').focus()
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
            v = parseFloat($(vtr).find('.txtValue').val())
            p = parseFloat($(vtr).find('.txtPrecio').val())
            // v = p * 100 / (100 + 18);
            // v = parseFloat($(vtr).find('.txtValue').val());
            d1 = parseFloat($(vtr).find('.txtDscto').val())
            d2 = parseFloat($(vtr).find('.txtDscto2').val())
            vt = Math.round(q*v*(100-d1)*(100-d2)/100) / 100 // total por item
            t = Math.round(q*p*(100-d1)*(100-d2)/100) / 100
            console.log(vt)
            console.log(t)
            discount = Math.round(100*q*v)/100 - vt

            gross_value += Math.round(100*q*v)/100
            gross_precio += Math.round(100*q*p)/100
            d_items += discount
            subtotal += vt
            total += t
            // gross_value = (Math.round(q*v*100)/100) + gross_value;
            // discount = (Math.round(q*v*d)/100) + discount;
            // subtotal = gross_value - (Math.round(q*v*d)/100) + subtotal;
        }
    });
    gross_value = Math.round(100 * gross_value) / 100
    gross_precio = Math.round(100 * gross_precio) / 100
    subtotal = Math.round(100 * subtotal) / 100
    total = Math.round(100 * total) / 100
    if (with_tax) {
        subtotal = Math.round(10000 * total / 118) / 100
        gross_value = Math.round(10000 * gross_precio / 118) / 100
        d_items = gross_value - subtotal
        // gross_value = Math.round(subtotal*1000000/((100-d1)*(100-d2))) / 100
    } else {
        total = Math.round(118 * subtotal) / 100
    }
    // if ($('#with_tax').val() == 1){
    //  subtotal = Math.round(total * 10000 / (100 + 18)) / 100;
    // } else {
    //  total = Math.round(subtotal * (100 + 18))/100;
    // }
    // discount = (gross_value - subtotal);


    $('#mGrossValue').text(gross_value.toFixed(2))
    $('#mDiscount').text(d_items.toFixed(2))
    $('#mSubTotal').text(subtotal.toFixed(2))
    $('#mIgv').text((total-subtotal).toFixed(2))
    $('#mTotal').text(total.toFixed(2))
}

function validateItem (myElement, id, decimales=2) {
    n = $(myElement).parent().parent().find(id).val()
    n = Math.round(parseFloat(n)*1000000)/1000000
    if (isNaN(n)) {n=0.00}
    $(myElement).parent().parent().find(id).val(n.toFixed(decimales))
    if (id=='.txtDscto') {window.descuento1 = n.toFixed(2)}
    if (id=='.txtDscto2') {window.descuento2 = n.toFixed(2)}
    return n
}

function calcTotalItem (myElement) {
    var with_tax = false
    if ($('#with_tax').val() == 1) {
        with_tax = true
    }
    cantidad = validateItem(myElement,'.txtCantidad', 2)
    precio = validateItem(myElement,'.txtPrecio', 4)
    value = validateItem(myElement,'.txtValue', 4)
    dscto = validateItem(myElement,'.txtDscto', 0)
    dscto2 = validateItem(myElement,'.txtDscto2', 0)
    if ($(myElement).hasClass('txtPrecio')) {
        $(myElement).parent().parent().find('.txtValue').val( (precio/1.18).toFixed(4) )
        value = validateItem(myElement,'.txtValue')
    } else if($(myElement).hasClass('txtValue')) {
        $(myElement).parent().parent().find('.txtPrecio').val( (value*1.18).toFixed(4) )
        precio = validateItem(myElement,'.txtPrecio')
    }
    if (with_tax) {
        price_item = Math.round((cantidad*precio)*(100-dscto)*(100-dscto2)/100)/100;
        total = Math.round(price_item*10000/118)/100
    } else {
        total = Math.round((cantidad*value)*(100-dscto)*(100-dscto2)/100)/100;
        price_item = Math.round(total*118)/100
    }
    console.log("with_tax: "+with_tax)
    console.log("Valor Item: "+total)
    console.log("Precio Item: "+price_item)
    // D = Math.round(cantidad * value * dscto) / 100;
    D = Math.round(cantidad * value - total) / 100
    // total = Math.round((cantidad*value-D)*100)/100;
    $(myElement).parent().parent().find('.txtTotal').text( total.toFixed(2) )
    $(myElement).parent().parent().find('.txtPriceItem').text( price_item.toFixed(2) )
}

function addRowProduct(data='') {
    var items = $('#items').val()
    if (items>0) {
        if ($("input[name='details["+(items-1)+"][DFCODIGO]']").val() == "") {
            $("input[name='details["+(items-1)+"][DFDESCRI]']").focus()
        } else{
            renderTemplateRowProduct(data)
        };
    } else{
        renderTemplateRowProduct(data)
    };
    if ($('#with_tax').val() == 1){
        $('.withTax').show()
        $('.withoutTax').hide()
    } else {
        $('.withTax').hide()
        $('.withoutTax').show()
    }
}

function renderTemplateRowProduct (data) {
    if (data != "") {
        ele = document.getElementById("tableItems").lastElementChild.querySelector("[data-product]");
        if (!isDesignEnabled(ele, data.id)) {return true}
    }
    var clone = activateTemplate("#template-row-item")
    var items = $('#items').val()
    clone.querySelector("[data-productid]").setAttribute("name", "details[" + items + "][DFCODIGO]")
    clone.querySelector("[data-unitid]").setAttribute("name", "details[" + items + "][DFUNIDAD]")
    clone.querySelector("[data-product]").setAttribute("name", "details[" + items + "][DFDESCRI]")
    clone.querySelector("[data-cantidad]").setAttribute("name", "details[" + items + "][DFCANTID]")
    clone.querySelector("[data-precio]").setAttribute("name", "details[" + items + "][price]")
    clone.querySelector("[data-value]").setAttribute("name", "details[" + items + "][DFPREC_ORI]")
    clone.querySelector("[data-dscto]").setAttribute("name", "details[" + items + "][CFPORDESCL]")
    clone.querySelector("[data-dscto2]").setAttribute("name", "details[" + items + "][DFPORDES]")
    // clone.querySelector("[data-isdeleted]").setAttribute("name", "details[" + items + "][is_deleted]")
    if (items>0) {$("input[name='details["+(items-1)+"][DFDESCRI]']").attr('disabled', true)}
    
    items = parseInt(items) + 1
    $('#items').val(items)
    $("#tableItems").append(clone)
    el = document.getElementById("tableItems").lastElementChild.querySelector("[data-product]")
    if (data != '') {
        setRowProduct(el, data)
    }

    $("input[name='details["+(items-1)+"][DFDESCRI]']").focus()
}
function renderTemplateRowAttribute () {
    var clone = activateTemplate("#template-row-attribute");
    var items = $('#items-attribute').val()
    clone.querySelector("[data-name]").setAttribute("name", "attributes[" + items + "][name]")
    clone.querySelector("[data-value]").setAttribute("name", "attributes[" + items + "][value_1]")
    clone.querySelector("[data-isdeleted]").setAttribute("name", "attributes[" + items + "][is_deleted]")
    //if (items>0) {$("input[name='accessories["+(items-1)+"][name]']").attr('disabled', true);};
    
    $("#tbodyAttributes").append(clone)
    items = parseInt(items) + 1
    $('#items-attribute').val(items)
}

function addRowBranch() {
    var items = $('#items').val()
    if (items>0) {
        if ($("input[name='branches["+(items-1)+"][name]']").val() == "") {
            console.log('en el segundo if')
            $("input[name='branches["+(items-1)+"][name]']").focus()
        } else if ($("input[name='branches["+(items-1)+"][address]']").val() == "") {
            $("input[name='branches["+(items-1)+"][address]']").focus()
        } else if ($("input[name='branches["+(items-1)+"][ubigeo_code]']").val() == "") {
            $("input[name='branches["+(items-1)+"][ubigeo]']").focus()
        } else{
            renderTemplateRowBranch()
        }
    } else{
        renderTemplateRowBranch()
    }
}

function renderTemplateRowBranch () {
    var clone = activateTemplate("#template-row-item");
    var items = $('#items').val()
    clone.querySelector("[data-branchId]").setAttribute("name", "branches[" + items + "][branch_id]")
    clone.querySelector("[data-ubigeoId]").setAttribute("name", "branches[" + items + "][ubigeo_code]")
    clone.querySelector("[data-name]").setAttribute("name", "branches[" + items + "][company_name]")
    clone.querySelector("[data-address]").setAttribute("name", "branches[" + items + "][address]")
    clone.querySelector("[data-ubigeo]").setAttribute("name", "branches[" + items + "][ubigeo]")
    clone.querySelector("[data-mobile]").setAttribute("name", "branches[" + items + "][mobile]")
    clone.querySelector("[data-contact]").setAttribute("name", "branches[" + items + "][contact]")
    clone.querySelector("[data-isdeleted]").setAttribute("name", "branches[" + items + "][is_deleted]")
    //if (items>0) {$("input[name='branches["+(items-1)+"][txtProduct]']").attr('disabled', true);};
    
    items = parseInt(items) + 1
    $('#items').val(items);
    $("#tableItems").append(clone)

    $("input[name='branches["+(items-1)+"][name]']").focus()
}

function getDataPadron (doc, type) {
    urls = {"1":`https://dniruc.apisperu.com/api/v1/dni/${doc}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im5vZWwubG9nYW5AZ21haWwuY29tIn0.pSSHu1Rh3RUgPubnjemiDNyMAN0ZjgTCXaupa8VsEYY`, "6":`https://dniruc.apisperu.com/api/v1/ruc/${doc}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im5vZWwubG9nYW5AZ21haWwuY29tIn0.pSSHu1Rh3RUgPubnjemiDNyMAN0ZjgTCXaupa8VsEYY`}
    $.get(urls[type], function(data){
        if (data) {
            console.log(data)
            if (type=='6') {
                $('#company_name').val(data.razonSocial)
                if (data.hasOwnProperty('ubigeo') && data.ubigeo != null) {
                    //$('#address').val(data.direccion.replace(` ${data.departamento} ${data.provincia} ${data.distrito}`, ''))
                    $('#address').val(data.direccion.replace(` ${data.departamento} ${data.provincia} ${data.distrito}`, '') + ` ${data.distrito} ${data.provincia} ${data.departamento}`)
                    $('#departamento').val(data.departamento)
                    $('#provincia').val(data.provincia)
                    $('#ubigeo_code').val(data.ubigeo)
                }
            } else {
                $('#paternal_surname').val(data.apellidoPaterno)
                $('#maternal_surname').val(data.apellidoMaterno)
                $('#name').val(data.nombres)
            }
            //console.log(data)
        }
    });
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
    var $dep = $('#DEPARTAMENTO')
    var $pro = $('#PROVINCIA')
    var $dis = $('#UBIGEO')
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
    var $dep = $('#DEPARTAMENTO')
    var $pro=$('#PROVINCIA')
    var $dis=$('#UBIGEO')
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

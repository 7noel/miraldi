@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Bienvenido</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3">
                            <a href="{{ route('clients.index') }}" class="thumbnail">CLIENTES
                                <img src="/img/companies.jpg" alt="...">
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <a href="{{ route('products.index') }}" class="thumbnail">PRODUCTOS
                                <img src="/img/productos.gif" alt="...">
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <a href="{{ route('orders.filter') }}" class="thumbnail">PEDIDOS
                                <img src="/img/pedido.png" alt="...">
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <a href="{{ route('purchases.index') }}" class="thumbnail">COMPRAS
                                <img src="/img/buy.png" alt="...">
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-deck">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('companies.index') }}" class="card-title text-dark link">CLIENTES
                        <img src="/img/clientes.png" class="card-img-top"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('orders.index') }}" class="card-title text-dark link">PEDIDOS
                        <img src="/img/cotiza.png" class="card-img-top"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('pickings.create') }}" class="card-title text-dark link">PICKING
                        <img src="/img/picking.png" class="card-img-top"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('products.excel_codbars') }}" class="card-title text-dark link">Código de Barras
                        <img src="/img/barcode2.png" class="card-img-top"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

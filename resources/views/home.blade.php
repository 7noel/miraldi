@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-deck">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('companies.index') }}" class="card-title text-dark">CLIENTES
                        <img src="/img/clientes.png" class="card-img-top"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('orders.index') }}" class="card-title text-dark">PEDIDOS
                        <img src="/img/cotiza.png" class="card-img-top"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('pickings.create') }}" class="card-title text-dark">PICKING
                        <img src="/img/picking.png" class="card-img-top"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('products.excel_codbars') }}" class="card-title text-dark">Código de Barras
                        <img src="/img/barcode2.png" class="card-img-top"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

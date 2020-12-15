@extends('layouts.app', ['title' => 'VC - Products', 'active' => 'products'])

@section('content')
<div class="">
    <div class="container-fluid">
        <div class="row mt-5 text-center">
            <div class="col mt-5">
                <h1>Detalhes de Produto</h1>
            </div>
        </div>
        <div class="row mt-5 d-flex justify-content-center">
            <div class="col-6">
                @include('components.messages')
            </div>
        </div>
        <div class="row">
            <div class="col-3 text-center">
                <div class="card card-body mb-4" style="min-width: 18em;">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">
                                <i class="far fa-file-alt"></i>
                                Historico de datas
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col min-card-height-2x">
                            @if(count($historic) > 0)
                                <table class="table table-responsive" style="zoom: 80%;">
                                    <thead>
                                        <th><small>Data</small></th>
                                        <th><small>Quantidade</small></th>
                                        <th><small>Lote</small></th>
                                    </thead>
                                    <tbody>
                                    @foreach($historic as $hist)
                                    <tr>
                                        <td><small>{{ $hist->date }}</small></td>
                                        <td><small>{{ $hist->amount }}</small></td>
                                        <td><small>{{ $hist->lote }}</small></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>Nada por aqui...</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                @include('components.card_product', ['product' => $product, 'collapse_class' => 'show'])
            </div>
            <div class="col-3">
                <div class="card card-body action-card">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">O que deseja fazer <i class="far fa-question-circle"></i></h5>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-around">
                        <div class="col-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProduct{{ $product->id }}"
                                    title="Editar produto">
                                <i class="fas fa-pen-square"></i>
                            </button>
                            @include('products.modal', ['product' => $product])
                        </div>
                        <div class="col-2">
                            <form action="{{ route('products.destroy', $product) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit" title="Deletar este produto" onclick="return confirm('Tem certeza?');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>

                <div class="card card-body mb-4 mt-2 action-card">
                    <div class="row">
                        <div class="col">
                            <img src="https://www.cognex.com/api/Sitecore/Barcode/Get?data={{ $product->barcode }}&code=S_EAN13&width=300&imageType=PNG&foreColor=%23000000&backColor=%23FFFFFF&rotation=RotateNoneFlipNone"
                                 alt="Barcode generated by Cognex Corporation" width="250"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
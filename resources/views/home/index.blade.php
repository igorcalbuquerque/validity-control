@extends('layouts.app', ['title' => 'VC - Home'])

@section('content')
<div class="">
    <div class="container-fluid">
        <div class="row mt-5 text-center">
            <div class="col mt-5">
                <h1>Home</h1>
            </div>
        </div>
        <div class="row text-center">
            <div class="col"><h3 title="ID da sua empresa é {{ $user->company->id }}">{{ $user->company->name }}</h3></div>
        </div>
        <div class="row mt-5 mb-2">
            <div class="col d-flex justify-content-center">
                @include('components.search_form', ['route' => route('products.search') ])
            </div>
        </div>
        <div class="row mt-5 d-flex justify-content-center">
            <div class="col-2"></div>
            <div class="col-8">
                @include('components.messages')
            </div>
            <div class="col-2"></div>
        </div>
        
        <div class="row d-flex justify-content-start">
            <div class="col-4">
                @if(isset($critical_dates) && count($critical_dates) > 0)
                    @include('components.exp_dates.card_exp_dates', ['dates' => $critical_dates, 'title' => 'Produtos em data critica ( 3 dias )'])
                @endif
                @if(isset($expired_products) && count($expired_products) > 0)
                    @include('components.exp_dates.card_exp_dates', ['dates' => $expired_products, 'title' => 'Produtos vencidos', 'danger' => true])
                @endif
            </div>
            <div class="col-4">
                @if(isset($users_granted))
                    @include('components.users.card_users_granted', ['users' => $users_granted])
                @endif
            </div>
            <div class="col-4">
                @if(isset($access_requests))
                    @include('components.users.card_access_requests', ['requests' => $access_requests])
                @endif
            </div>
        </div>

        <div class="row mt-5 mb-2">
            <div class="col d-flex justify-content-center">
                <div class="card card-body chart-categories">
                    <div id="piechart" class="chart-categories"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('head_scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@push('scripts')
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    var graphicData = <?= $graphic_data; ?>;

    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(graphicData);

        var options = {
            title: 'Produtos com até 30 dias ( Por categoria )',
            //is3D: true,
            pieHole:0.4,
            //sliceVisibilityThreshold: 0.05,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>
@endpush
@extends('adminlte::page')

@section('title', 'Orders Charts')

@section('content_header')
    <h1>Cahrts</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Orders Status Chart</h3>
        </div>
        <div class="card-body" style="max-width: 500px; margin: auto;">
            <canvas id="ordersPieChart" width="350" height="350" style="max-width:100%"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Orders Per Month</h3>
        </div>
        <div class="card-body" style="max-width: 600px; margin: auto;">
            <canvas id="ordersBarChart" width="450" height="350" style="max-width:100%"></canvas>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        
        const pieCtx = document.getElementById('ordersPieChart');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($ordersByStatus->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($ordersByStatus->toArray())) !!}
                }]
            }
        });

        
        const barCtx = document.getElementById('ordersBarChart');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($ordersMonthly->toArray())) !!},
                datasets: [{
                    label: 'Orders per Month',
                    data: {!! json_encode(array_values($ordersMonthly->toArray())) !!}
                }]
            }
        });
    </script>

@stop

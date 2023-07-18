@extends('layouts.dashboard')

@section('title', 'Finanças')
@section('title-page', 'Finanças')
@section('title-sub-page', 'Home')

@section('content')

<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="white-box">
            <h3 class="box-title"><small class="pull-right m-t-10 text-success"></small> Previsão (Mensal)</h3>
            <div class="stats-row">
                <div class="stat-item">
                    <h6>Total de Moradores Activos do Condomínio</h6> <b>{{ $year['total'] }}</b></div>
                <div class="stat-item">
                    <h6>Valor a arrecadar</h6> <b>{{ number_format(($year['total'] * 200000), '2') }} Kzs</b></div>
            </div>
            <div id="sparkline8"></div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="white-box">
            <h3 class="box-title"><small class="pull-right m-t-10 text-success"></small> Previsão (Anual)</h3>
            <div class="stats-row">
                <div class="stat-item">
                    <h6>Total de Moradores Activos do Condomínio</h6> <b>{{ $year['total'] }}</b></div>
                <div class="stat-item">
                    <h6>Valor a arrecadar</h6> <b>{{ number_format((($year['total'] * 200000) * 12), '2') }} Kzs</b></div>
                    <!-- <h6>Valor a arrecadar</h6> <b>{{ ($year['total'] * 200000) * 12 }} Kzs</b></div> -->
            </div>
            <div id="sparkline8"></div>
        </div>
    </div>
</div>
@endsection

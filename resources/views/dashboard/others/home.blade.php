@extends('layouts.dashboard')

@section('title', 'Página Inicial')
@section('title-page', 'Página Inicial')
@section('title-sub-page', '#')

@section('content')




<!-- /.row -->
<!-- ============================================================== -->
<!-- Different data widgets -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="row row-in">
                <div class="col-lg-3 col-sm-6 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-danger"><i class="mdi mdi-home-modern"></i></span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15">{{ $building }}</h3>
                        </li>
                        <li class="col-middle">
                            <h4>Prédios</h4>
                            <!-- <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div> -->
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-6  b-0">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-warning"><i class="mdi mdi-flag-variant"></i></span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15">{{ $apartament }}</h3>
                        </li>
                        <li class="col-middle">
                            <h4>Apartamentos</h4>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-info"><i class="mdi mdi-account-key"></i></span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15">{{ $porter }}</h3>
                        </li>
                        <li class="col-middle">
                            <h4>Porteiros</h4>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-6 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-success"><i class="mdi mdi-account-switch"></i></span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15">{{ $resident }}</h3>
                        </li>
                        <li class="col-middle">
                            <h4>Moradores</h4>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--row -->
            
            

@endsection

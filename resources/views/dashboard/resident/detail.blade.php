@extends('layouts.dashboard')

@section('title', 'Morador')
@section('title-page', 'Moradores')
@section('title-sub-page', 'Documentação')

@section('content')


@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
        <div class="alert alert-{{ $msg }} alert-dismissable">
            {!! Session::get('alert-' . $msg) !!}
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div>
    @endif
@endforeach

<!-- .row -->
<div class="row">


    <div class="col-md-4 col-xs-12">


        <!-- .row -->
        <div class="row el-element-overlay m-b-40">
            <!-- /.usercard -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="el-card-item">
                        <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('../images/padrao.jpg') }}" />
                            <div class="el-overlay">
                                <ul class="el-info">
                                    <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{ asset('../images/padrao.jpg') }}"><i class="icon-magnifier"></i></a></li>
                                    <li><a class="btn default btn-outline" href="javascript:void(0);"><i class="icon-link"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="el-card-content">
                            <h3 class="box-title">{{ $resident->name }}</h3> <small></small>
                            <br/> </div>
                    </div>
                </div>
            </div>
            <!-- /.usercard-->
        </div>

    </div>
    <div class="col-md-8 col-xs-12">
        <div class="white-box">
            <ul class="nav nav-tabs tabs customtab">

                <li class="active tab">
                    <a href="#bi" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Bilhete</span> </a>
                </li>
                <li class="tab">
                    <a href="#contract" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Contrato</span> </a>
                </li>

               
            </ul>
            <div class="tab-content">
                
                <div class="tab-pane active" id="bi">
                    <div class="row">
                        <div class="col-md-12" style="height: 500px;">
                            <embed src="{{ $resident->bi }}" type="application/pdf" width="100%" height="100%">
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane" id="contract">
                    <div class="row">
                        <div class="col-md-12" style="height: 500px;">
                            <embed src="{{ $resident->contract }}" type="application/pdf" width="100%" height="100%">
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- /.row -->

@endsection

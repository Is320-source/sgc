@extends('layouts.dashboard')

@section('title', 'Meu Perfil')
@section('title-page', 'Meu Perfil')
@section('title-sub-page', 'Usuários')

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
                        <div class="el-card-avatar el-overlay-1"> <img src="{{ $user->photo }}" />
                            <div class="el-overlay">
                                <ul class="el-info">
                                    <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{ $user->photo }}"><i class="icon-magnifier"></i></a></li>
                                    <li><a class="btn default btn-outline" href="javascript:void(0);"><i class="icon-link"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="el-card-content">
                            <h3 class="box-title">{{ $user->name }}</h3> <small>{{ $user->email }}</small>
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
                    <a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Meu Perfil</span> </a>
                </li>
                <li class="tab">
                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Editar Perfil</span> </a>
                </li>

                <li class="tab">
                    <a href="#photo" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Editar Foto</span> </a>
                </li>
                <li class="tab">
                    <a href="#password" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Editar Password</span> </a>
                </li>
            </ul>
            <div class="tab-content">
                
                <div class="tab-pane active" id="profile">
                    <div class="row">
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Nome Completo</strong>
                            <br>
                            <p class="text-muted">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Telefone</strong>
                            <br>
                            <p class="text-muted">(+244) 946 428 275</p>
                        </div>
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Email</strong>
                            <br>
                            <p class="text-muted">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="col-md-6 col-xs-6"> <strong>Gênero</strong>
                            <br>
                            <p class="text-muted">{{ auth()->user()->genere == '0' ? 'Masculino' : 'Femenino' }}</p>
                        </div>


                        <div class="col-md-6 col-xs-6"> <strong>Tipo</strong>
                            <br>
                            <p class="text-muted">{{ auth()->user()->type == '0' ? 'Adm' : 'Gerente' }}</p>
                        </div>


                        <div class="col-md-6 col-xs-6"> <strong>Morada</strong>
                            <br>
                            <p class="text-muted">{{ auth()->user()->address }}</p>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- <h5>Wordpress <span class="pull-right">80%</span></h5>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">50% Complete</span> </div>
                    </div>
                    <h5>HTML 5 <span class="pull-right">90%</span></h5>
                    <div class="progress">
                        <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">50% Complete</span> </div>
                    </div>
                    <h5>jQuery <span class="pull-right">50%</span></h5>
                    <div class="progress">
                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;"> <span class="sr-only">50% Complete</span> </div>
                    </div>
                    <h5>Photoshop <span class="pull-right">70%</span></h5>
                    <div class="progress">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%;"> <span class="sr-only">50% Complete</span> </div>
                    </div> -->
                </div>
                
                <div class="tab-pane" id="settings">
                    <form class="form-horizontal form-material" action="{{ route('dashboard.update.user', $user->id) }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label class="col-md-12">Nome Completo</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="Nome" id="name" name="name" class="form-control form-control-line" value="{{ $user->name }}"> </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input type="email" placeholder="E-mail" name="email" id="E-mail" class="form-control form-control-line" value="{{ $user->email }}"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Telefone</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="Telefone" name="phone" id="phone" class="form-control form-control-line" value="{{ $user->phone }}"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Gênero</label>
                            <div class="col-sm-12">
                                <select class="form-control form-control-line" name="genere" id="genere">
                                    <option value="0" {{ $user->genere == '0' ? 'selected' : '' }}>Masculino</option>
                                    <option value="1" {{ $user->genere == '1' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Morada</label>
                            <div class="col-md-12">
                            <input type="text" value="{{ $user->address }}" name="address" class="form-control form-control-line"> </div>
                        </div>
 
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="submit" >Actualizar</button>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="tab-pane" id="photo">
                    <div class="row">
                        <div class="col-sm-12 ol-md-12 col-xs-12">

                            <form action="{{ route('dashboard.update.user', $user->id) }}" method="post" enctype='multipart/form-data'>
                            @csrf
                            @method('PUT')
                                <div class="white-box">
                                    <input type="file" id="photo" name="photo" class="dropify" /> </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit" >Actualizar</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.row -->
                </div>


                <div class="tab-pane" id="password">
                    <!-- .row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="white-box">
                                <form class="form-horizontal" action="{{ route('dashboard.password.user', $user->id) }}" method="post" enctype='multipart/form-data'>
                                @csrf
                                @method('PUT')
                                    <div class="form-group">
                                        <label class="col-md-6">Senha Actual</label>
                                        <div class="col-md-12">
                                            <input type="password" name="old_password" class="form-control" placeholder="Senha Actual"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Nova Senha</label>
                                        <div class="col-md-12">
                                            <input type="password" name="new_password" class="form-control" placeholder="Senha Actual"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Confirmar Nova Senha</label>
                                        <div class="col-md-12">
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Senha Actual"> </div>
                                    </div>
                                            
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <button class="btn btn-success" type="submit" >Actualizar</button>
                                        </div>

                                        <!-- <div class="col-sm-2">
                                            <button class="btn btn-info" >Gerar</button>
                                        </div> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

@endsection

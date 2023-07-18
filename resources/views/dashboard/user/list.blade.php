@extends('layouts.dashboard')

@section('title', 'Lista de Administradores')
@section('title-page', 'Administradores')
@section('title-sub-page', 'Lista')

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
    <div class="col-md-12">
        <div class="white-box" style="text-align:right;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newAdm" data-whatever="@mdo">Novo Administrador</button>
        </div>
    </div>
</div>


<!-- .row -->
<div class="row el-element-overlay m-b-40">
    <!-- /.usercard -->
    @forelse ($users as $user)

    @if ($user->id != '1')
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="white-box">
                <div class="el-card-item">
                    <div class="el-card-avatar el-overlay-1"> <img src="{{ $user->photo ?? asset('../images/padrao.jpg') }}" style="height: 220px;" />
                        <div class="el-overlay">
                            <ul class="el-info">
                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{ $user->photo ?? asset('../images/padrao.jpg') }}"><i class="icon-magnifier"></i></a></li>
                                <li><a class="btn default btn-outline" href="javascript:void(0);"><i class="icon-link"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="el-card-content">
                        <h3 class="box-title">{{ $user->name }}</h3> <small>{{ $user->type == '0' ? 'Principal' : ($user->type == '1' ? 'Secundário' : 'Funcionário') }}</small>
                        <br /> <br />
                    </div>

                    <div style="text-align: center;">
                        @if ($user->id != Auth::user()->id)
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#statusAdm" data-whatever="@mdo">{{ $user->status == '0' ? 'Desactivar' : 'Activar' }}</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#excluirAdm" data-whatever="@mdo">Excluir</button>
                        @else
                        <a href="{{ route('dashboard.show.user', $user->id) }}" class="btn btn-info">Meu Perfil</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="statusAdm" tabindex="-1" role="dialog" aria-labelledby="statusAdmLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="statusAdmLabel1">Alterar Estado</h4>
                    </div>
                    
                    <div class="modal-body">
                        <form action="{{ route('dashboard.status.user', $user->id) }}" method="post" enctype='multipart/form-data'>
                            @csrf
                            @method('PUT')
                            <p>Tens certeza que desejas {{ $user->status == '0' ? 'desactivar' : 'activar' }} <strong>{{ $user->name }}?</strong></p>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Sim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="excluirAdm" tabindex="-1" role="dialog" aria-labelledby="excluirAdmLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="excluirAdmLabel1">Excluir {{ $user->name }}</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('dashboard.destroy.user', $user->id) }}" method="post" enctype='multipart/form-data'>
                            @csrf
                            @method('DELETE')
                            <p>Tens certeza que desejas excluir <strong>{{ $user->name }}?</strong></p>
                            <p>Com isso, {{ $user->name }} já não terá acesso ao sistema, sendo excluido permanentemente.</p>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Sim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endif
    @empty

    @endforelse

</div>

<div class="modal fade" id="newAdm" tabindex="-1" role="dialog" aria-labelledby="newAdmLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newAdmLabel1">Novo Administrador</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.store.user') }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Nome Completo *</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome do Administrador">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">E-mail *</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="E-mail">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Telefone *</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefone">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Tipo *</label>
                        <select class="form-control" name="type" id="type">
                            <option value="0">Principal</option>
                            <option value="1" selected>Secundário</option>
                            <option value="2">Terciário</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Senha *</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="control-label">Confirmar Senha *</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar Senha">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Validar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>




@endsection
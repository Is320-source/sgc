@extends('layouts.dashboard')

@section('title', 'Pagamentos')
@section('title-page', 'Todos os Pagamentos')
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
<!-- 
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="text-align:right;">
        <form method="post" action="#">
            @csrf
                <div class="row">
                     <div class="col-md-2">
                         <input type="text" class="form-control" name="name" value="{{ !empty($searched['name']) ? $searched['name'] : '' }}" placeholder="Name do Porteiro">
                     </div>
                     <div class="col-md-2">
                         <input type="number" class="form-control" name="phone_number" value="{{ !empty($searched['phone']) ? $searched['phone'] : '' }}" placeholder="Phone">
                     </div>

                     <div class="col-md-2">
                         
                         <input type="date" class="form-control" name="created_at" value="{{ !empty($searched['date']) ? $searched['date'] : '' }}" placeholder="Registed date">
                     </div>
                     <div class="col-md-2">
                        <button type="submit" class="btn btn-info">Data filter</button>
                     </div>

                     <div class="col-md-2">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newPorter" data-whatever="@mdo">Novo Administrador</button>
                     </div>

                </div>
           </form>
        </div>
    </div>
</div>
 -->


<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="text-align:right;">
            <form method="post" action="{{ route('dashboard.search.porter') }}">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <select class="form-control" name="genere" id="genere">
                            <option value="0">-- Todos os Pagamentos --</option>
                            <option value="1">Femenino</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <!-- <input type="date" class="form-control" name="genere" id="genere"> -->

                        <select class="selectpicker" multiple data-live-search="true">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                    </div>

                    <div class="col-md-2">
                        <input type="date" class="form-control" name="genere" id="genere">
                    </div>



                    <div class="col-md-1">
                        <button type="submit" class="btn btn-info">Pesquisar</button>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#file" data-whatever="@mdo"><i class="fa fa-file"></i></button>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newPorter" data-whatever="@mdo">Novo Pagamento</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (isset($searched['result']))
    <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
        <div class="white-box">
            <div class="card">
                <h5 style="color:black;"><strong>Resultado:</strong> {{ $searched['result'] }}</h5>
            </div>
        </div>
    </div>
    @endif


    <div class="col-sm-12">



        <div class="white-box">


            <h3 class="box-title m-b-0">Pagamentos</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Tipo de Pagamento</th>
                            <th>Morador</th>
                            <th>Telefone</th>
                            <th>Estado</th>
                            <th>Acção</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($porters as $porter)

                        <tr>
                            <td>{{ $loop->index + 1}}</td>
                            <td><img src="{{ $porter->photo }}" style="width: 38px; height:38px; " class="thumb-lg img-circle" alt="img"></td>
                            <td>{{ $porter->name }}</td>
                            <td>{{ $porter->status == '0' ? 'Activo' : 'Desactivado' }}</td>
                            <td>{{ $porter->phone }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" data-placement="top" title="Editar" data-toggle="modal" data-target="#edit{{ $porter->id }}">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a class="btn btn-warning btn-sm" data-placement="top" title="Editar" data-toggle="modal" data-target="#EditMessage{{ $porter->id }}">
                                    <i class="fa fa-key"></i>
                                </a>

                                <a class="btn btn-success btn-sm" data-placement="top" title="Deletar" data-toggle="modal" data-target="#delete{{ $porter->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>



                        <!-- Modal de edit Model, pega para  -->
                        <!-- Modal -->
                        <div class="modal fade" id="edit{{ $porter->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                            <div class="modal-dialog" role="document ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Porteiro </strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('dashboard.update.porter', $porter->id) }}" method="post" enctype='multipart/form-data'>
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="name" class="control-label">Nome Completo *</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $porter->name }}" placeholder="Nome do Porteiro">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Telefone *</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $porter->phone }}" placeholder="Telefone">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Gênero *</label>
                                                <select class="form-control" name="genere" id="genere">
                                                    <option value="0" {{ $porter->genere == '0' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="1" {{ $porter->genere == '1' ? 'selected' : '' }}>Femenino</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Estado (opcional)</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="0" {{ $porter->status == '0' ? 'selected' : '' }}>Activar</option>
                                                    <option value="1" {{ $porter->status == '1' ? 'selected' : '' }}>Desactivar</option>
                                                </select>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success">Actualizar</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->



                        <!-- Modal de edit Model, pega para  -->
                        <!-- Modal -->
                        <div class="modal fade" id="EditMessage{{ $porter->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                            <div class="modal-dialog" role="document ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><strong>Reenviar Senha</strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="edit-form" method="POST" action="#">
                                        @csrf
                                        <!-- @method('PUT') -->
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group m-t-20">

                                                        <p>Tens certeza que desejas alterar senha e reenviar para o porteiro ({{ $porter->name }})? </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success dropdown-toggle waves-effect waves-light">Reenviar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->



                        <!-- Modal de edit Model, pega para  -->
                        <!-- Modal -->
                        <div class="modal fade" id="delete{{ $porter->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                            <div class="modal-dialog" role="document ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><strong>Deletar Porteiro </strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="edit-form" method="POST" action="{{ route('dashboard.destroy.porter', $porter->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group m-t-20">

                                                        <p>Tens certeza que desejas excluir este porteiro ({{ $porter->name }})? </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success dropdown-toggle waves-effect waves-light">Sim</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        @endforeach

                    </tbody>
                </table>
                @if (isset($filters))
                {{ $porters->appends($filters)->links() }}
                @else
                {{ $porters->links() }}
                @endif
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="newPorter" tabindex="-1" role="dialog" aria-labelledby="newPorterLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newPorterLabel1">Novo Porteiro</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.store.porter') }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Nome Completo *</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome do Porteiro">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Telefone *</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefone">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Gênero *</label>
                        <select class="form-control" name="genere" id="genere">
                            <option value="0" selected>Masculino</option>
                            <option value="1">Femenino</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Validar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="file" tabindex="-1" role="dialog" aria-labelledby="fileLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="fileLabel1">Exportar Todos os Pagamentos</h4>
            </div>
            <div class="modal-body">

                <form action="{{ route('dashboard.report.porter') }}" method="post" enctype='multipart/form-data'>
                    @csrf

                    <div class="form-group">
                        <label for="name" class="control-label">De (opcional)</label>
                        <input type="date" class="form-control" name="start">
                    </div>


                    <div class="form-group">
                        <label for="name" class="control-label">Até (opcional)</label>
                        <input type="date" class="form-control" name="end">
                    </div>


                    <div class="form-group">
                        <label for="genere" class="control-label">Tipo de Exportação *</label>
                        <select class="form-control" name="type" required>
                            <option selected>-- Selecionar Exportação --</option>
                            <option value="0">PDF</option>
                            <option value="1">Excel</option>
                        </select>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Imprimir</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<script>
    (function() {
        $('select').selectpicker();

        console.log('dsffffffff');
    })();
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

@endsection
@extends('layouts.dashboard')

@section('title', 'Lista de Serviços')
@section('title-page', 'Serviços')
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

<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="text-align:right;">
        <form method="post" action="{{ route('dashboard.search.service') }}">
            @csrf
                <div class="row">
                     <div class="col-md-4">
                         <input type="text" class="form-control" name="name" value="{{ !empty($searched['name']) ? $searched['name'] : '' }}" placeholder="Serviço">
                     </div>
                     
                     <div class="col-md-1">
                        <button type="submit" class="btn btn-info">Pesquisar</button>
                     </div>

                     <div class="col-md-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#file" data-whatever="@mdo"><i class="mdi mdi-printer"></i></button>
                     </div>

                     <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newservice" data-whatever="@mdo">Novo Serviço</button>
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

    <h3 class="box-title m-b-0">Lista de Serviços</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Serviço</th>
                    <th>Complemento</th>
                    <th>Estado</th>
                    <th>Acção</th>
                </tr>
            </thead>
            <tbody>


            @foreach ($services as $service)

                <tr>
                   <td>{{ $loop->index + 1}}</td>
                   <td>{{ $service->service }}</td>
                   <td>{{ $service->description }}</td>
                   <td>{{ $service->status == '0' ? 'Activo' : 'Desactivado' }}</td>
                   <td>
                       <a class="btn btn-primary btn-sm" data-placement="top" title="Editar" data-toggle="modal" data-target="#edit{{ $service->id }}">
                           <i class="fa fa-edit"></i>
                       </a>

                       <a class="btn btn-success btn-sm" data-placement="top" title="Deletar" data-toggle="modal" data-target="#delete{{ $service->id }}">
                           <i class="fa fa-trash"></i>
                       </a>
                   </td>
                </tr>



                <!-- Modal de edit Model, pega para  -->
                <!-- Modal -->
                <div class="modal fade" id="edit{{ $service->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                    <div class="modal-dialog" role="document ">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Serviço </strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form action="{{ route('dashboard.update.service', $service->id) }}" method="post" enctype='multipart/form-data'>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name" class="control-label">Serviço *</label>
                                        <input type="text" class="form-control" id="name" name="service" value="{{ $service->service }}" placeholder="Serviço"> 
                                    </div>


                                    <div class="form-group">
                                        <label for="description" class="control-label">Descrição *</label>
                                        <textarea class="form-control" id="description" name="description" placeholder="Descrição" rows="4">{{ $service->description }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Estado (opcional)</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="0" {{ $service->status == '0' ? 'selected' : '' }}>Activar</option>
                                                <option value="1" {{ $service->status == '1' ? 'selected' : '' }}>Desactivar</option>
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
                <div class="modal fade" id="delete{{ $service->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                    <div class="modal-dialog" role="document ">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong>Deletar Serviço </strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="edit-form" method="POST" action="{{ route('dashboard.destroy.service', $service->id) }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                                    <div class="form-group m-t-20">
                                                    
                                                        <p>Tens certeza que desejas excluir este Serviço ({{ $service->service }})? </p>
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
            {{ $services->appends($filters)->links() }}
        @else
            {{ $services->links() }}
        @endif
    </div>
</div>
</div>

</div>


<div class="modal fade" id="newservice" tabindex="-1" role="dialog" aria-labelledby="newserviceLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newserviceLabel1">Novo Serviço</h4> </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.store.service') }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Serviço *</label>
                        <input type="text" class="form-control" id="service" name="service" placeholder="Serviço"> 
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Descrição *</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Descrição" rows="4"></textarea>
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
                <h4 class="modal-title" id="fileLabel1">Exportar Serviços</h4> </div>
            <div class="modal-body">

                <form action="{{ route('dashboard.report.service') }}" method="post" enctype='multipart/form-data'>
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




@endsection

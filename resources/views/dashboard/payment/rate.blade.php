@extends('layouts.dashboard')

@section('title', 'Taxas de Condomínio')
@section('title-page', 'Taxas do Condomínio')
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

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newPorter" data-whatever="@mdo">Nova Taxa</button>

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


            <h3 class="box-title m-b-0">Taxas de Condomínio</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Nome da Taxa</th>
                            <th>Valor</th>
                            <th>Dia de Pagamento</th>
                            <th>Multa</th>
                            <th>Acção</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($rates as $rate)

                        <tr>
                            <td>{{ $loop->index + 1}}</td>
                            <td>{{ $rate->rate_name }}</td>
                            <td>{{ number_format($rate->value, '2', ',', '.') . ' Kzs' }}</td>
                            <td>{{ $rate->date_limit }}</td>
                            <td>{{ number_format($rate->mult, '2', ',', '.') . ' Kzs' }}</td>
                            <td>{{ $rate->status == '0' ? 'Activo' : 'Desactivado' }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" data-placement="top" title="Editar" data-toggle="modal" data-target="#edit{{ $rate->id }}">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a class="btn btn-danger btn-sm" data-placement="top" title="Deletar" data-toggle="modal" data-target="#delete{{ $rate->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>



                        <!-- Modal de edit Model, pega para  -->
                        <!-- Modal -->
                        <div class="modal fade" id="edit{{ $rate->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                            <div class="modal-dialog" role="document ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Porteiro </strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('dashboard.update.rate', $rate->id) }}" method="post" enctype='multipart/form-data'>
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group">
                                                <label for="name" class="control-label">Nome da Taxa *</label>
                                                <input type="text" class="form-control" id="rate_name" name="rate_name" value="{{ $rate->rate_name }}" placeholder="Nome do Porteiro">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Valor *</label>
                                                <input type="number" class="form-control" id="value" name="value" value="{{ $rate->value }}" placeholder="Valor a pagar">
                                            </div>


                                            <div class="form-group">
                                                <label for="phone" class="control-label">Dia Limente de Pagamenta *</label>
                                                <input type="number" class="form-control" id="date_limit" name="date_limit" value="{{ $rate->date_limit }}" placeholder="Dia de pagamento no mês">
                                            </div>


                                            <div class="form-group">
                                                <label for="phone" class="control-label">Multa *</label>
                                                <input type="number" class="form-control" id="mult" name="mult" value="{{ $rate->mult }}" placeholder="Multa">
                                            </div>


                                            <div class="form-group">
                                                <label for="phone" class="control-label">Estado *</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="0" {{ $rate->status == '0' ? 'selected' : '' }}>Activar</option>
                                                    <option value="1" {{ $rate->status == '1' ? 'selected' : '' }}>Desactivar</option>
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
                        <div class="modal fade" id="delete{{ $rate->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                            <div class="modal-dialog" role="document ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><strong>Deletar Taxa </strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="edit-form" method="POST" action="{{ route('dashboard.destroy.rate', $rate->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group m-t-20">

                                                        <p>Tens certeza que desejas excluir esta taxa ({{ $rate->rate_name }})? </p>
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
                {{ $rates->appends($filters)->links() }}
                @else
                {{ $rates->links() }}
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
                <h4 class="modal-title" id="newPorterLabel1">Nova Taxa</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.store.rate') }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Nome da Taxa *</label>
                        <input type="text" class="form-control" id="rate_name" name="rate_name" placeholder="Nome do Porteiro">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Valor *</label>
                        <input type="number" class="form-control" id="value" name="value" placeholder="Valor a pagar">
                    </div>


                    <div class="form-group">
                        <label for="phone" class="control-label">Dia Limente de Pagamenta *</label>
                        <input type="number" class="form-control" id="date_limit" name="date_limit" placeholder="Dia de pagamento no mês">
                    </div>


                    <div class="form-group">
                        <label for="phone" class="control-label">Multa *</label>
                        <input type="number" class="form-control" id="mult" name="mult" placeholder="Multa">
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
                <h4 class="modal-title" id="fileLabel1">Exportar Taxas do Condomínio</h4>
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



@endsection
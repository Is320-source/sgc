@extends('layouts.dashboard')

@section('title', 'Lista de Moradores')
@section('title-page', 'Moradores')
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
            <form method="post" action="{{ route('dashboard.search.resident') }}">
            @csrf
                <div class="row">
                     <div class="col-md-4">
                         <input type="text" class="form-control" name="name" value="{{ !empty($searched['name']) ? $searched['name'] : '' }}" placeholder="Name do Morador">
                     </div>
                     
                     <div class="col-md-1">
                        <button type="submit" class="btn btn-info">Pesquisar</button>
                     </div>

                     <div class="col-md-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fileResident" data-whatever="@mdo"><i class="fa fa-file"></i></button>
                     </div>

                     <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newresident" data-whatever="@mdo">Novo Morador</button>
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


    <h3 class="box-title m-b-0">Lista de Moradores</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nome</th>
                    <th>Residência</th>
                    <th>Telefone</th>
                    <th>Estado</th>
                    <th>Acção</th>
                </tr>
            </thead>
            <tbody>


            @foreach ($residents as $resident)

                <tr>
                   <td>{{ $loop->index + 1}}</td>
                   <!-- <td><img src="{{ $resident->photo }}" style="width: 38px; height:38px; " class="thumb-lg img-circle" alt="img"></td> -->
                   <td>{{ $resident->name }}</td>
                   <td>{{ $resident->building .' - '. $resident->apartament }}</td>
                   <td>{{ $resident->phone }}</td>
                   <td>{{ $resident->status == '0' ? 'Activo' : 'Desactivado' }}</td>
                   <td>
                       <a class="btn btn-info btn-sm" href="{{ route('dashboard.show.resident', $resident->id) }}">
                           <i class="fa fa-eye"></i>
                       </a>

                       <a class="btn btn-primary btn-sm" data-placement="top" title="Editar" data-toggle="modal" data-target="#edit{{ $resident->id }}">
                           <i class="fa fa-edit"></i>
                       </a>

                       <a class="btn btn-warning btn-sm" data-placement="top" title="Editar" data-toggle="modal" data-target="#EditMessage{{ $resident->id }}">
                           <i class="fa fa-key"></i>
                       </a>

                       <a class="btn btn-success btn-sm" data-placement="top" title="Deletar" data-toggle="modal" data-target="#delete{{ $resident->id }}">
                           <i class="fa fa-trash"></i>
                       </a>
                   </td>
                </tr>



                <!-- Modal de edit Model, pega para  -->
                <!-- Modal -->
                <div class="modal fade" id="edit{{ $resident->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                    <div class="modal-dialog" role="document ">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Morador </strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form action="{{ route('dashboard.update.resident', $resident->id) }}" method="post" enctype='multipart/form-data'>
                                    @csrf
                                    @method('PUT')
                                    
                                    <div id="info-form_edit"></div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">Nome Completo *</label>
                                        <input type="text" class="form-control" id="name-edit" name="name" value="{{ $resident->name }}" placeholder="Nome do Morador"> 
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="control-label">Telefone *</label>
                                        <input type="number" class="form-control" id="phone-edit" name="phone" value="{{ $resident->phone }}" placeholder="Telefone"> 
                                    </div>

                                    <div class="form-group">
                                        <label for="genere" class="control-label">Gênero *</label>
                                            <select class="form-control" name="genere" id="genere-edit">
                                                <option value="0" {{ $resident->genere == '0' ? 'selected' : '' }}>Masculino</option>
                                                <option value="1" {{ $resident->genere == '1' ? 'selected' : '' }}>Femenino</option>
                                            </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="control-label">Prédio *</label>
                                            <select class="form-control" name="building_id" id="building_id_edit" onChange="getApartamentsEdit()" required>
                                                @foreach ($buildings as $building)
                                                    <option value="{{ $building->id }}" {{ $resident->building_id == $building->id ? 'selected' : '' }}>{{ $building->building }}</option>
                                                @endforeach
                                            </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="phone" class="control-label">Apartamento *</label>
                                            <select class="form-control" name="apartament_id" id="apartament_id_edit" required>
                                                <option value="{{ $resident->apartament_id }}" selected>{{ $resident->apartament }}</option>
                                            
                                            </select>
                                    </div>


                                    
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Estado (opcional)</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="0" {{ $resident->status == '0' ? 'selected' : '' }}>Activar</option>
                                                <option value="1" {{ $resident->status == '1' ? 'selected' : '' }}>Desactivar</option>
                                            </select>
                                    </div>
                                
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <!-- <button type="button" id="btn-v-button_edit" class="btn btn-info">Validar</button> -->
                                        <button type="submit" id="btn-v-submit_edit" class="btn btn-success">Actualizar</button>
                                    </div>
                                    
                                        
                                </form>
                        </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->



                <!-- Modal de edit Model, pega para  -->
                <!-- Modal -->
                <div class="modal fade" id="EditMessage{{ $resident->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
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
                                                
                                                    <p>Tens certeza que desejas alterar senha e reenviar para o Morador ({{ $resident->name }})? </p>
                                                    
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
                <div class="modal fade" id="delete{{ $resident->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                    <div class="modal-dialog" role="document ">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong>Deletar Morador </strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="edit-form" method="POST" action="{{ route('dashboard.destroy.resident', $resident->id) }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                                    <div class="form-group m-t-20">
                                                    
                                                        <p>Tens certeza que desejas excluir este morador ({{ $resident->name }})? </p>
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
            {{ $residents->appends($filters)->links() }}
        @else
            {{ $residents->links() }}
        @endif
    </div>
</div>
</div>

</div>


<div class="modal fade" id="newresident" tabindex="-1" role="dialog" aria-labelledby="newresidentLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newresidentLabel1">Novo Morador</h4> </div>
            <div class="modal-body">

                <form action="{{ route('dashboard.store.resident') }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div id="info-form" ></div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nome Completo *</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome do Morador"> 
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Telefone *</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefone"> 
                    </div>
                    <div class="form-group">
                        <label for="genere" class="control-label">Gênero *</label>
                            <select class="form-control" name="genere" id="genere" required>
                                <option selected disabled>-- Selecionar Gênero --</option>
                                <option value="0">Masculino</option>
                                <option value="1">Femenino</option>
                            </select>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="control-label">Prédio *</label>
                            <select class="form-control" name="building_id" id="building_id" onChange="getApartaments()" required>
                                <option selected disabled>-- Selecionar Prédio --</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}">{{ $building->building }}</option>
                                @endforeach
                            </select>
                    </div>


                    <div class="form-group">
                        <label for="phone" class="control-label">Apartamento *</label>
                            <select class="form-control" name="apartament_id" id="apartament_id" required>
                                <option selected disabled>-- Selecionar Apartamento --</option>
                             
                            </select>
                    </div>



                    <div class="form-group">
                        <label for="phone" class="control-label">Bilhete de Identidade *</label>
                        <input type="file" class="form-control" id="bi" name="bi"> 
                    </div>


                    <div class="form-group">
                        <label for="contract" class="control-label">Contrato *</label>
                        <input type="file" class="form-control" id="contract" name="contract"> 
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-v-button" class="btn btn-info">Validar</button>
                        <button type="submit" id="btn-v-submit" class="btn btn-success">Validar</button>
                    </div>
                        
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="fileResident" tabindex="-1" role="dialog" aria-labelledby="fileResidentLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="fileResidentLabel1">Exportar Moradores</h4> </div>
            <div class="modal-body">

                <form action="{{ route('dashboard.report.resident') }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="phone" class="control-label">Prédio *</label>
                            <select class="form-control" name="building_id" require>
                                <option selected disabled>-- Selecionar Prédio --</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}">{{ $building->building }}</option>
                                @endforeach
                            </select>
                    </div>


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



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>


<script type="text/javascript">

    function getApartaments() {
        var selectBuilding = document.getElementById('building_id');
        var optionSelected = selectBuilding.options[selectBuilding.selectedIndex];
        // Pegar o select do Lote

        $('#apartament_id').empty();
        var apartaments = document.getElementById('apartament_id');
        // apartaments.empty();

        // console.log(optionSelected.value);
        $.get('/cdm/apartaments/' + optionSelected.value, function(data) {
            // console.log(data);
            apartamentsList = [];
            data.forEach(function(item) {
                // console.log(item);
                apartamentsList.push(`<option value="${ item.id }">${ item.apartament }</option>`);
            });
            apartaments.innerHTML += apartamentsList;
        }).fail(function() {
            console.log('Nao passou nada');
        })
    }

    jQuery(document).ready(function(  ) {
        jQuery("#btn-v-submit").hide(200)
        jQuery("#btn-v-button").click(function( ){
            
            var name = jQuery("#name").val()
            var phone = jQuery("#phone").val()
            var genere = jQuery("#genere").val()
            var building_id = jQuery("#building_id").val()
            var apartament_id = jQuery("#apartament_id").val()
        

            if(name !== '' && phone !== '' && genere !== '' && building_id !== '' && apartament_id !== ''){
          
              jQuery("#btn-v-button").hide(200)
              jQuery("#info-form").html("<div class='alert alert-info alert-dismissible'>Campos verificados... agora sumita os dados.</div>").show(200)
              jQuery("#btn-v-submit").show(200)
              
            }else{
              jQuery("#info-form").html("<div class='alert alert-danger alert-dismissible'>Todos os campos são importantes preencher.</div>").show(200).delay(2000).hide(200)
            }
        })
    })


</script>


<script type="text/javascript">

    function getApartamentsEdit() {
        var selectBuilding = document.getElementById('building_id_edit');
        var optionSelected = selectBuilding.options[selectBuilding.selectedIndex];
        // Pegar o select do Lote

        $('#apartament_id_edit').empty();
        var apartaments = document.getElementById('apartament_id_edit');
        // apartaments.empty();

        // console.log(optionSelected.value);
        $.get('/cdm/apartaments/' + optionSelected.value, function(data) {
            // console.log(data);
            apartamentsList = [];
            data.forEach(function(item) {
                // console.log(item);
                apartamentsList.push(`<option value="${ item.id }">${ item.apartament }</option>`);
            });
            apartaments.innerHTML += apartamentsList;
        }).fail(function() {
            console.log('Nao passou nada');
        })
    }


    // jQuery(document).ready(function(  ) {
    //     jQuery("#btn-v-submit_edit").hide(200)
    //     jQuery("#btn-v-button_edit").click(function( ){
            
    //         var name = jQuery("#name-edit").val()
    //         var phone = jQuery("#phone-edit").val()
    //         var genere = jQuery("#genere-edit").val()
    //         var building_id = jQuery("#building_id_edit").val()
    //         var apartament_id = jQuery("#apartament_id_edit").val()
        

    //         if(name !== '' && phone !== '' && genere !== '' && building_id !== '' && apartament_id !== ''){
          
    //           jQuery("#btn-v-button_edit").hide(200)
    //           jQuery("#info-form_edit").html("<div class='alert alert-info alert-dismissible'>Campos verificados... agora sumita os dados.</div>").show(200)
    //           jQuery("#btn-v-submit_edit").show(200)
              
    //         }else{
    //           jQuery("#info-form_edit").html("<div class='alert alert-danger alert-dismissible'>Todos os campos são importantes preencher.</div>").show(200).delay(2000).hide(200)
    //         }
    //     })
    // })
</script>

@endsection

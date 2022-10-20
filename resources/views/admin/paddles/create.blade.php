@extends('admin.layouts.dashboard')

@section('content')

{{-- VALIDACIONES-RESPUESTA--}}
@include('admin.layouts.success')   {{-- SAVE --}}
@include('admin.layouts.danger')    {{-- EDITAR --}}
@include('admin.layouts.delete')    {{-- DELELTE --}}

{{-- VALIDACIONES-RESPUESTA --}}
<div class="right_col" role="main">
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
          <div class="x_title">
            <h2>Ingresar Paletas</h2>
            <ul class="col-sm-1 nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form method="POST" enctype="multipart/form-data" action="{{ route('paddles.store') }}" id="form" data-parsley-validate class="form-horizontal form-label-left">
              @csrf 
                         
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="id_office_agency">Oficina:</label>
                <div class="col-sm-4">
                  <select class="select2_group form-control" name="id_office_agency">
                      @if (isset($paddle))
                        <option value="{{ $paddle->id_office_agency ?? null }}">{{ $paddle->office_agencies['name'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @foreach ($agencies as $agency)
                        <option value="{{ $agency->id }}">{{ $agency->name ?? '' }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="id_agent">Agente:</label>
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="id_agent">
                      @if (isset($paddle))
                        <option value="{{ $paddle->id_agent ?? null }}">{{ $paddle->agents['name'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($agents)) 
                        @foreach ($agents as $agent)
                          <option value="{{ $agent->id }}">{{ $agent->name ?? '' }}</option>
                        @endforeach
                      @endif
                     
                    </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="id_destination_state">Destino:</label>
                <div class="col-sm-3">
                    <select class="select2_group form-control" name="id_destination_state" >
                      @if (isset($paddle))
                        <option value="{{ $paddle->id_destination_state ?? null }}">{{ $paddle->destination_states['name'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      
                      @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name ?? '' }}</option>
                      @endforeach
                    </select>
                </div>
             
              </div>
           
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="dimension">Dimensiones:</label>
                <div class="col-sm-2">
                  <input id="dimension_width" name="dimension_width" placeholder="Ancho" class="date-picker form-control"  type="text"  value="{{ number_format(bcdiv(($paddle->dimension_width ?? 0), '1', 2), 2, ',', '.') ?? null }}">
                </div>
                <div class="col-sm-2">
                  <input id="dimension_length" name="dimension_length" placeholder="Largo" class="date-picker form-control"  type="text"  value="{{ number_format(bcdiv(($paddle->dimension_length ?? 0), '1', 2), 2, ',', '.') ?? null }}">
                </div>
                <div class="col-sm-2">
                  <input id="dimension_high" name="dimension_high" placeholder="Alto" class="date-picker form-control"  type="text"  value="{{ number_format(bcdiv(($paddle->dimension_high ?? 0), '1', 2), 2, ',', '.') ?? null }}">
                </div>

                <label class="col-form-label col-sm-1 label-align " for="dimension">Volumen:</label>
                <div class="col-sm-3">
                  <input id="volume" name="volume"  class="date-picker form-control"  type="text"  value="{{ number_format(bcdiv(($paddle->volume ?? 0), '1', 2), 2, ',', '.') ?? null }}">
                </div>
              </div>

              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="dimension">Peso en lbs:</label>
                <div class="col-sm-3">
                  <input id="weight" name="weight"  class="date-picker form-control"  type="text"  value="{{ number_format(bcdiv(($paddle->weight ?? 0), '1', 2), 2, ',', '.') ?? null }}">
                </div>
                <label class="col-form-label col-sm-4 label-align " for="dimension">Peso Cargable:</label>
                <div class="col-sm-3">
                  <input id="loadable_weight" name="loadable_weight"  class="date-picker form-control"  type="text"  value="{{ number_format(bcdiv(($paddle->loadable_weight ?? 0), '1', 2), 2, ',', '.') ?? null }}">
                </div>
              </div>

             
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="type_of_service">Servicio:</label>
                <div class="col-sm-3">
                    <select class="select2_group form-control" name="type_of_service" >
                      @if (isset($paddle))
                        <option value="{{ $paddle->type_of_service ?? null }}">{{ $paddle->type_of_service ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione</option>
                      @endif
                      <option value="Marítimo">Marítimo</option>
                      <option value="Terrestre">Terrestre</option>
                      <option value="Marítimo Express">Marítimo Express</option>
                    </select>
                </div>
                <label class="col-form-label col-sm-4 label-align " for="class">Clase:</label>
                <div class="col-sm-2">
                    <select class="select2_group form-control" name="class" >
                      @if (isset($paddle))
                        <option value="{{ $paddle->class ?? null }}">{{ $paddle->class ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione</option>
                      @endif
                      <option value="Clase 1">Clase 1</option>
                      <option value="Clase 2">Clase 2</option>
                      <option value="Clase 3">Clase 3</option>
                    </select>
                </div>
              </div>
              <div class="item form-group">
                  <label class="col-form-label col-sm-1 label-align " for="loose_packages">Bultos sueltos:</label>
                  <div class="col-md-1 col-sm-1 ">
                  <p> Si: <input type="radio" class="flat" name="loose_packages" id="loose_packagesYes" value="Yes"   /> 
                  </div>
                  <div class="col-md-1 col-sm-1 ">
                      No: <input type="radio" class="flat" name="loose_packages" id="loose_packagesNo" value="No" checked=""/>
                  </p>
                  </div>
                  <label class="col-form-label col-sm-5 label-align " for="reference">Referencia:</label>
                  <div class="col-sm-3">
                    <input id="reference" name="reference"  class="date-picker form-control"  type="text"  value="{{ $paddle->reference ?? '' }}">
                  </div>
              </div>

              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="dimension">Expediente:</label>
                <div class="col-sm-3">
                  <input id="record" name="record"  class="date-picker form-control"  type="text"  value="{{ $paddle->record ?? '' }}">
                </div>
                <label class="col-form-label col-sm-4 label-align " for="dimension">Número de Paquetes:</label>
                <div class="col-sm-3">
                  <input id="number_of_packages" name="number_of_packages"  class="date-picker form-control"  type="text"  value="{{ $paddle->number_of_packages ?? 0 }}">
                </div>
              </div>

              <br>
              <br>
              <div class="form-row">
                @if (empty($paddle))
                  <div class="col-sm-3 offset-sm-1">
                    <button type="submit" class="btn btn-primary" id="Btnpaddle">Registrar Paleta</button>
                  </div>
                @else
                  <div class="col-sm-3 offset-sm-1">
                    <button onclick="update();" class="btn btn-success" id="Btnpaddle">Actualizar Paleta</button>
                  </div>
                @endif
                <div class="col-sm-2 ">
                  <a href="{{ route('paddles.index') }}" class="btn btn-danger" type="button">Ver Listado</a>
                </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

@isset($paddle)
<div class="clearfix"></div>
  <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <div class="col-md-4 col-sm-4 h5">
              Paquetes Incluidos
            </div>
          
            <ul class="col-sm-1 nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form method="POST" enctype="multipart/form-data" action="{{ route('paddles.storePackage') }}" id="form" data-parsley-validate class="form-horizontal form-label-left">
              @csrf 
              <input id="id_paddle" name="id_paddle" value="{{ $paddle->id }}" class="date-picker form-control"  type="hidden" >
                  
                <div class="item form-group">
                  <label class="col-form-label col-sm-3 label-align " for="package_reference">Ingresar un Paquete en la Paleta:</label>
                  <div class="col-sm-3">
                    <input id="package_reference" name="package_reference"  class="date-picker form-control"  type="text" >
                  </div>
                  <div class="col-sm-3 ">
                    <button type="submit" class="btn btn-primary" id="Btnpaddle">Registrar Paquete</button>
                  </div>
                </div>
              </form>
              @isset($packages)
              <div class="card-box table-responsive">
      
                <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Tracking</th>
                      <th>Cliente</th>
                      <th>Casillero</th>
                      <th>Descripcion</th>
                      <th>Tipo</th>
                      <th>Agente</th>
                      <th>Oficina</th>
                    </tr>
                  </thead>
                 
                    @foreach ($packages as $package)
                    <tr>
                      <td class="text-center">
                        <a href="{{ route('packages.create',$package->id) }}"  title="Seleccionar">{{$package->id}}</a>
                      </td>
                      <td>{{$package->tracking ?? ''}}</td>
                      <td>{{$package->clients['firstname'] ?? ''}} {{$package->clients['firstlastname'] ?? ''}}</td>
                      <td>{{$package->clients['casillero'] ?? ''}}</td>
                      <td>{{$package->description ?? ''}}</td>
                      <td>{{$package->instruction ?? ''}}</td>
                      <td>{{$package->vendors['name'] ?? ''}}</td>
                      <td>{{$package->office_locations['direction'] ?? ''}}</td>
                    </tr>
                    @endforeach
                  @endisset
                  
        
                  </table>
                </div>
              </div>
          </div>
    </div>
</div>
@endisset

@endsection

@section('validation')

  @isset($paddle)
    <script>
      if("{{$paddle->loose_packages}}" == "Yes"){
          $('#loose_packagesYes').prop('checked', true);
      }else{
          $('#loose_packagesNo').prop('checked', true);
      }

      
    function update(){
      document.getElementById("form").action = "{{ route('paddles.update',$paddle->id) }}";
      document.getElementById("form").submit();
    }
    </script>
  @endisset
  
@endsection
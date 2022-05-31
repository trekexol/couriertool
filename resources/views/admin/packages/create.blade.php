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
            <h2>Ingresar Paquetes</h2>
            <ul class="col-sm-1 nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form method="POST" enctype="multipart/form-data" action="{{ route('packages.store') }}" id="form" data-parsley-validate class="form-horizontal form-label-left">
              @csrf 
              
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="tracking">Tracking </label>
                <div class="col-sm-4">
                  <input type="text" id="tracking" name="tracking" required="required" class="form-control " value="{{ $tracking ?? $package->tracking ?? null }}">
                </div>
                <label class="col-form-label col-sm-3 label-align " for="id_agent_shipper">Shipper: </label>
                <div class="col-sm-3">
                  <select class="select2_group form-control" name="id_agent_shipper" required>
                      @if (isset($package))
                        <option value="{{ $package->id_agent_shipper ?? null }}">{{ $package->shippers['name'] ?? null }}</option>
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
                <label class="col-form-label col-sm-1 label-align " for="id_client">Cliente</label>
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="id_client" required>
                      @if (isset($package))
                        <option value="{{ $package->id_client ?? null }}">{{ $package->clients['firstname'] ?? null }} {{ $package->clients['firstlastname'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($clients)) 
                        @foreach ($clients as $client)
                          <option value="{{ $client->id }}">{{$client->type_cedula ?? ''}}{{$client->cedula ?? ''}} - {{ $client->firstname ?? '' }} {{ $client->firstlastname ?? '' }}</option>
                        @endforeach
                      @endif
                     
                    </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="first-name">Agente Vendedor:</label>
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="id_agent_vendor" required>
                      @if (isset($package))
                        <option value="{{ $package->id_agent_vendor ?? null }}">{{ $package->vendors['name'] ?? null }}</option>
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
                <label class="col-form-label col-sm-3 label-align " for="first-name">Vendedor Externo:</label>
                <div class="col-sm-3">
                    <select class="select2_group form-control">
                      
                    </select>
                </div>
              </div>
           
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align">Fecha Llegada:
                </label>
                <div class="col-sm-4">
                  <input id="arrival_date" name="arrival_date" class="date-picker form-control"  required="required" type="date" value="{{ date_format(date_create($package->arrival_date ?? null),"Y-m-d") }}">
                </div>
                <label class="col-form-label col-sm-3 label-align">Hora Llegada:
                </label>
                <div class="col-sm-3 ">
                  @if (isset($package->arrival_date))
                    <input id="check_in" name="check_in" class="date-picker form-control"  type="time" required="required" value="{{ date_format(date_create($package->arrival_date ?? null),"H:i") }}">        
                  @else
                    <input id="check_in" name="check_in" class="date-picker form-control"  type="time" required="required" >                   
                  @endif
                  </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="first-name">Ubicación Oficina:</label>
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="id_agent_office_location" required>
                      @if (isset($package))
                        <option value="{{ $package->id_agent_office_location ?? null }}">{{ $package->office_locations['name'] ?? null }} - {{ $package->office_locations['direction'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($agents))
                        @foreach ($agents as $agent)
                          <option value="{{ $agent->id }}">{{ $agent->name ?? '' }} - {{ $agent->direction ?? '' }}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
                <label class="col-form-label col-sm-3 label-align " for="id_wharehouse">Almacen:</label>
                <div class="col-sm-3">
                    <select class="select2_group form-control" name="id_wharehouse" required>
                      @if (isset($package))
                        <option value="{{ $package->id_wharehouse ?? null }}">{{ $package->wharehouses['name'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($wharehouses))
                        @foreach ($wharehouses as $wharehouse)
                          <option value="{{ $wharehouse->id }}">{{ $wharehouse->name ?? '' }}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="content">Contenido:</label>
                <div class="col-sm-4">
                  <input type="text" id="content" name="content" required="required" class="form-control " value="{{ $package->content ?? null }}">
                </div>
                <label class="col-form-label col-sm-3 label-align " for="value">Valor:</label>
                <div class="col-sm-3">
                  <input type="text" id="value" name="value" required="required" class="form-control" value="{{ $package->value ?? null }}">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="id_origin_country">País de Origen:</label>
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="id_origin_country" required>
                      @if (isset($package))
                        <option value="{{ $package->id_origin_country ?? null }}">{{ $package->origin_countries['name'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($countries))
                        @foreach ($countries as $country)
                          <option value="{{ $country->id }}">{{ $country->name ?? '' }}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
                <label class="col-form-label col-sm-3 label-align " for="id_destination_country">País de Destino:</label>
                <div class="col-sm-3">
                    <select class="select2_group form-control" name="id_destination_country" required>
                      @if (isset($package))
                        <option value="{{ $package->id_destination_country ?? null }}">{{ $package->destination_countries['name'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($countries))
                        @foreach ($countries as $country)
                          <option value="{{ $country->id }}">{{ $country->name ?? '' }}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="id_delivery_company">Entregado por:</label>
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="id_delivery_company" required>
                      @if (isset($package))
                        <option value="{{ $package->id_delivery_company ?? null }}">{{ $package->delivery_companies['description'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($delivery_companies))
                        @foreach ($delivery_companies as $delivery_company)
                          <option value="{{ $delivery_company->id }}">{{ $delivery_company->description ?? '' }}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
                <label class="col-form-label col-sm-3 label-align " for="number_transport_guide">N° Guía Transporte:</label>
                <div class="col-sm-3">
                  <input type="text" id="number_transport_guide" name="number_transport_guide" required="required" class="form-control" value="{{ $package->number_transport_guide ?? null }}">
                </div>
              </div>

              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="service_type">Tipo Servicio:</label>
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="service_type" required>
                      @if (isset($package))
                        <option value="{{ $package->service_type ?? null }}">{{ $package->service_type ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      <option value="Pre-Pagado">Pre-Pagado</option>
                      <option value="Collected">Collected</option>
                    </select>
                </div>
                <label class="col-form-label col-sm-3 label-align " for="instruction">Instrucciones:</label>
                <div class="col-sm-2">
                    <select class="select2_group form-control" name="instruction" required>
                      @if (isset($package))
                        <option value="{{ $package->instruction ?? null }}">{{ $package->instruction ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      <option value="Aéreo">Aéreo</option>
                      <option value="Marítimo">Marítimo</option>
                      <option value="Terrestre">Terrestre</option>
                      <option value="Marítimo Express">Marítimo Express</option>
                    </select>
                </div>
                <div class="col-sm-2">
                  <select class="select2_group form-control" name="instruction_type" required>
                        @if (isset($package))
                          <option value="{{ $package->instruction_type ?? null }}">{{ $package->instruction_type ?? null }}</option>
                          <option value="">---------------------</option>
                        @else
                          <option value="">Seleccione una Opción</option>
                        @endif
                      <option value="Directo">Directo</option>
                      <option value="Consolidado">Consolidado</option>
                  </select>
                </div>
              </div>

              <div class="item form-group">
                <label class="col-form-label col-sm-2 label-align " for="description">Descrip/Coment:</label>
                <div class="col-sm-9">
                  <input type="text" id="description" name="description" required="required" class="form-control" value="{{ $package->description ?? null }}">
                </div>
              </div>
              <br>
              <div class="form-group row">
                <div class="col-sm-2 offset-sm-1">
                  <input type="checkbox" name="checks[]" id="high_value" value="high_value" data-parsley-mincheck="2"  class="flat" /> Alto Valor: 
                </div> 
                <div class="col-sm-2">
                  <input type="checkbox" name="checks[]" id="dangerous_goods" value="dangerous_goods" data-parsley-mincheck="2" class="flat" /> Merc. Peligrosa: 
                </div> 
                <div class="col-sm-2">
                  <input type="checkbox" name="checks[]" id="sed" value="sed" data-parsley-mincheck="2" class="flat" /> SED: 
                </div> 
                <div class="col-sm-2">
                  <input type="checkbox" name="checks[]" id="document" value="document" data-parsley-mincheck="2" class="flat" /> Documento: 
                </div> 
                <div class="col-sm-2">
                  <input type="checkbox" name="checks[]" id="fragile" value="fragile" data-parsley-mincheck="2" class="flat" /> Fragil: 
                </div> 
              </div>

              <br>
              <div class="form-row">
                @if (empty($package))
                  <div class="col-sm-3 offset-sm-1">
                    <button type="submit" class="btn btn-primary offset-sm-1" id="BtnPackage">Registrar Paquete</button>
                  </div>
                @else
                  <div class="col-sm-3 offset-sm-1">
                    <button onclick="update();" class="btn btn-success offset-sm-1" id="BtnPackage">Actualizar Paquete</button>
                  </div>
                @endif
                
            </div>
          </form>
      </div>
    </div>
  </div>
</div>


@if(isset($package))

  <div class="clearfix"></div>
  <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <div class="col-md-2 col-sm-2 h5">
              Tipo de mercancia
            </div>
            <div class="col-md-1 col-sm-1 offset-sm-8">
              <button id="agregar2" title="Agregar Bultos" type="button" onclick="nuevo_packagings2();" class=" btn btn-round btn-info fa fa-plus"></button>
            </div>
            <ul class="col-sm-1 nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <div class="item form-group">

              <form method="POST" action="{{ route('packages_type_of_goods.store') }}" id="form_contacto2" data-parsley-validate class="form-horizontal form-label-left">
                @csrf
                        <input type="hidden" id="id_package_type_of_good" name="id_package_type_of_good" value="{{ $package->id ?? null }}">

                        @if (isset($package_type_of_goods))
                          @foreach($package_type_of_goods as $package_type_of_good)
                            <div class="item form-group form-horizontal form-label-left">
                              <div class="col-sm-3">
                                <select class="select2_group form-control " name="service_type_type_of_good">
                                  <option value="{{ $package_type_of_good->id_type_of_good ?? null }}">{{ $package_type_of_good->type_of_goods['description'] ?? null }}</option>
                                  <option value="">---------------------</option>
                                  @foreach ($type_of_goods as $type_of_good)
                                    <option value="{{ $type_of_good->id }}">{{ $type_of_good->description ?? '' }}</option>
                                  @endforeach
                                </select>
                              </div>
                              
                              <div class="col-sm-1">
                                <input type="text"  placeholder="Unid." class="form-control" value="{{ $package_type_of_good->unit ?? '' }}">
                              </div>
                              <div class="col-sm-2">
                                <input type="text"  placeholder="Descripción." class="form-control" value="{{ $package_type_of_good->description ?? ''}}">
                              </div>
                              <div class="col-sm-2">
                                <input type="text" placeholder="Valor." class="form-control" value="{{ $package_type_of_good->value ?? ''}}">
                              </div>
                              <div class="col-sm-2">
                                <input type="text" placeholder="Arancel." class="form-control" value="{{ $package_type_of_good->tariff ?? ''}}">
                              </div>
                              <div class="col-sm-1">
                                <input type="text" placeholder="Cargo." class="form-control" value="{{ $package_type_of_good->charge ?? ''}}">
                              </div>
                            <div class="col-sm-1">
                              <a href="{{ route('packages_type_of_goods.edit',$package_type_of_good->id)}}" title="Editar"><i class="fa fa-edit"></i></a> 
                              <a href="#" class="delete_packages_type_of_good" title="Eliminar" data-id-packages_type_of_good={{$package_type_of_good->id}} data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash text-danger"></i></a> 
                            </div>
                          </div>
                          @endforeach
                        @endif
                       
            
                      <div class="item clonar2">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <select class="select2_group form-control " name="id_type_of_good[]">
                                  <option value="">Seleccione ...</option>
                                  @foreach ($type_of_goods as $type_of_good)
                                    <option value="{{ $type_of_good->id }}">{{ $type_of_good->description ?? '' }}</option>
                                  @endforeach
                                </select>
                            </div>
                            
                            <div class="col-sm-1">
                              <input type="text" id="unit_type_of_good" name="unit_type_of_good[]" placeholder="Unid." class="form-control" required>
                            </div>
                            <div class="col-sm-2">
                              <input type="text" id="description_type_of_good" name="description_type_of_good[]"  placeholder="Descripción." class="form-control" required>
                            </div>
                            <div class="col-sm-2">
                              <input type="text" id="value_type_of_good" name="value_type_of_good[]" placeholder="Valor." class="form-control" required>
                            </div>
                            <div class="col-sm-2">
                              <input type="text" id="tariff_type_of_good" name="tariff_type_of_good[]" placeholder="Arancel." class="form-control" required>
                            </div>
                            <div class="col-sm-1">
                              <input type="text" id="charge_type_of_good" name="charge_type_of_good[]" placeholder="Cargo." class="form-control" required>
                            </div>
                            <div class="col-sm-1">
                              <span class="badge badge-pill badge-danger puntero2 ocultar2">Eliminar</span>
                            </div>
                        </div>
                      </div>
            
                  <div id="contenedor2"></div>
                  <br>
                  <div class="form-row">
                      <div class="col-sm-3">
                          <button type="submit" class="btn btn-primary offset-sm-1" id="enviar_type_of_good">Registrar</button>
                      </div>
                  </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>
  <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <div class="col-md-2 col-sm-2 h5">
              Bultos
            </div>
            <div class="col-md-1 col-sm-1 offset-sm-8">
              <button id="agregar" title="Agregar Bultos" type="button" onclick="nuevo_packagings();" class=" btn btn-round btn-info fa fa-plus"></button>
            </div>
            <ul class="col-sm-1 nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
              <!--FORMULARIO TIPO DE MERCANCIA-->
              <div id="lumps_form" class="inputs_lump">
               
                <div class="item form-group">
                 

                <form method="POST" action="{{ route('packages_lumps.store') }}" id="form_contacto" data-parsley-validate class="form-horizontal form-label-left">
                  @csrf
                          <input type="hidden" id="id_package_lump" name="id_package_lump" value="{{ $package->id ?? null }}">

                          @if (isset($package_lumps))
                            @foreach($package_lumps as $package_lump)
                            <div class="item form-group form-horizontal form-label-left">
                              <div class="col-sm-3">
                                <select class="select2_group form-control" >

                                  <option value="{{ $package_lump->id_type_of_packaging ?? null }}">{{ $package_lump->type_of_packagings['description'] ?? null }}</option>
                                  <option value="">---------------------</option>

                                  @foreach ($type_of_packagings as $type_of_packaging)
                                    <option value="{{ $type_of_packaging->id }}">{{ $type_of_packaging->description ?? '' }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-sm-1">
                                <input type="text" placeholder="Cant." class="form-control" value="{{ $package_lump->amount }}">
                              </div>
                              <div class="col-sm-2">
                                <input type="text" placeholder="Peso Bulto." class="form-control" value="{{ $package_lump->bulk_weight }}">
                              </div>
                              <div class="col-sm-1">
                                <input type="text" placeholder="Largo." class="form-control" value="{{ $package_lump->length_weight }}">
                              </div>
                              <div class="col-sm-1">
                                <input type="text" placeholder="Ancho." class="form-control" value="{{ $package_lump->width_weight }}">
                              </div>
                              <div class="col-sm-1">
                                <input type="text" placeholder="Alto." class="form-control" value="{{ $package_lump->high_weight }}">
                              </div>
                              <div class="col-sm-2">
                                <input type="text" placeholder="Descripción." class="form-control" value="{{ $package_lump->description }}">
                              </div>
                              <div class="col-sm-1">
                                <a href="{{ route('packages_lumps.edit',$package_lump->id)}}" title="Editar"><i class="fa fa-edit"></i></a> 
                                <a href="#" class="delete_packages_lump" title="Eliminar" data-id-package_lump={{$package_lump->id}} data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash text-danger"></i></a> 
                              </div>
                            </div>
                            @endforeach
                          @endif

                          
                          <div class="item clonar">
                              <div class="form-group">
                                <div class="col-sm-3">
                                  <select class="select2_group form-control" name="type_of_packaging[]" required>
                                    <option value="">Seleccione ...</option>
                                    @foreach ($type_of_packagings as $type_of_packaging)
                                      <option value="{{ $type_of_packaging->id }}">{{ $type_of_packaging->description ?? '' }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-sm-1">
                                  <input type="text" id="amount_lump" name="amount_lump[]" placeholder="Cant." class="form-control" required>
                                </div>
                                <div class="col-sm-2">
                                  <input type="text" id="bulk_weight_lump" name="bulk_weight_lump[]"  placeholder="Peso Bulto." class="form-control" required>
                                </div>
                                <div class="col-sm-1">
                                  <input type="text" id="length_lump" name="length_lump[]" placeholder="Largo." class="form-control" required>
                                </div>
                                <div class="col-sm-1">
                                  <input type="text" id="width_lump" name="width_lump[]" placeholder="Ancho." class="form-control" required>
                                </div>
                                <div class="col-sm-1">
                                  <input type="text" id="high_lump" name="high_lump[]" placeholder="Alto." class="form-control" required>
                                </div>
                                <div class="col-sm-2">
                                  <input type="text" id="description_lump" name="description_lump[]"  placeholder="Descripción." class="form-control" required>
                                </div>
                                <span class="badge badge-pill badge-danger puntero ocultar">Eliminar</span>
                              </div>
                          </div>
                          
                        <div id="contenedor"></div>
                        <br>
                        <div class="form-row">
                            <div class="col-sm-3">
                                <button class="btn btn-primary offset-sm-1" id="enviar_contacto">Registrar</button>
                            </div>
                        </div>

                    </form>
                </div>
              </div>
          </div>
    </div>
</div>

@endif


<!-- Delete Warning Modal -->
<div class="modal modal-danger fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
          <form action="{{ route('packages_type_of_goods.delete')}}" method="post">
              @csrf
              @method('DELETE')
              <input id="id_packages_type_of_good_modal" type="hidden" class="form-control @error('id_packages_type_of_good_modal') is-invalid @enderror" name="id_packages_type_of_good_modal" readonly required autocomplete="id_packages_type_of_good_modal">
                     
              <h5 class="text-center">Seguro que desea eliminar?</h5>
              
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Eliminar</button>
          </div>
          </form>
      </div>
  </div>
</div>

@endsection


@section('validation')
<script>
      
  let agregar2 = document.getElementById('agregar2');
  let contenido2 = document.getElementById('contenedor2');

  let boton_enviar2 = document.querySelector('#enviar_type_of_good')

  agregar2.addEventListener('click', e2 =>{
      e2.preventDefault();
      let clonado2 = document.querySelector('.clonar2');
      let clon2 = clonado2.cloneNode(true);

      contenido2.appendChild(clon2).classList.remove('clonar2');

      let remover_ocutar2 = contenido2.lastChild.childNodes[1].querySelectorAll('span');
      remover_ocutar[0].classList.remove('ocultar2');
  });

  contenido2.addEventListener('click', e2 =>{
      e2.preventDefault();
      if(e2.target.classList.contains('puntero2')){
          let contenedor2  = e2.target.parentNode.parentNode;
      
          contenedor2.parentNode.removeChild(contenedor2);
      }
  });


  boton_enviar2.addEventListener('click', e2 => {
      e2.preventDefault();

      const formulario2 = document.querySelector('#form_contacto2');
      const form2 = new FormData(formulario2);

      const peticion2 = {
          body:form,
          method:'POST'
      };
    
    document.getElementById("form_contacto2").submit();

  });


</script>

  <script>
    
        let agregar = document.getElementById('agregar');
        let contenido = document.getElementById('contenedor');

        let boton_enviar = document.querySelector('#enviar_contacto')

        agregar.addEventListener('click', e =>{
            e.preventDefault();
            let clonado = document.querySelector('.clonar');
            let clon = clonado.cloneNode(true);

            contenido.appendChild(clon).classList.remove('clonar');

            let remover_ocutar = contenido.lastChild.childNodes[1].querySelectorAll('span');
            remover_ocutar[0].classList.remove('ocultar');
        });

        contenido.addEventListener('click', e =>{
            e.preventDefault();
            if(e.target.classList.contains('puntero')){
                let contenedor  = e.target.parentNode.parentNode;
            
                contenedor.parentNode.removeChild(contenedor);
            }
        });


        boton_enviar.addEventListener('click', e => {
            e.preventDefault();

            const formulario = document.querySelector('#form_contacto');
            const form = new FormData(formulario);

            const peticion = {
                body:form,
                method:'POST'
            };
          
          document.getElementById("form_contacto").submit();

        });


  </script>
 


  <script>
      $(document).on('click','.delete_packages_type_of_good',function(){
         
         let id_packages_type_of_good = $(this).attr('data-id-packages_type_of_good');
 
         $('#id_packages_type_of_good_modal').val(id_packages_type_of_good);
     });

     
 

  </script>
@isset($package)
  <script>  
     if("{{isset($package)}}"){
      if("{{(isset($package->high_value) && $package->high_value == true)}}"){

        document.getElementById("high_value").checked = true;

      }if("{{(isset($package->dangerous_goods) && $package->dangerous_goods == true)}}"){

        document.getElementById("dangerous_goods").checked = true;

      }if("{{(isset($package->sed) && $package->sed == true)}}"){
        
        document.getElementById("sed").checked = true;

      }
      if("{{(isset($package->document) && $package->document == true)}}"){

        document.getElementById("document").checked = true;

      }
      if("{{(isset($package->fragile) && $package->fragile == true)}}"){

        document.getElementById("fragile").checked = true;

      }
    }
    function update(){
      document.getElementById("form").action = "{{ route('packages.update',$package->id) }}";
      document.getElementById("form").submit();
    }
  </script>
@endisset
@endsection
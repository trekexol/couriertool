@extends('admin.layouts.dashboard')

@section('content')

{{-- VALIDACIONES-RESPUESTA--}}
@include('admin.layouts.success')   {{-- SAVE --}}
@include('admin.layouts.danger')    {{-- EDITAR --}}
@include('admin.layouts.delete')    {{-- DELELTE --}}

<div class="col-sm-1 offset-sm-4">
  <a href="{{ route('trakings.index') }}" type="submit" class="btn btn-light offset-sm-1" id="BtnPackage">Tracking</a>
</div>
@if (isset($package))
  <div class="col-sm-1">
    <a href="#" type="submit" class="active btn btn-light offset-sm-1" id="BtnPackage">Basico</a>
  </div>
  <div class="col-sm-1">
    <a href="{{ route('client_recipient_packages.register',$package->id) }}" type="submit" class="btn btn-light offset-sm-1" id="BtnPackage">Destino</a>
  </div>
  <div class="col-sm-1">
    <a href="{{ route('package_charges.index',$package->id) }}" type="submit" class="btn btn-light offset-sm-1" id="BtnPackage">Cargos</a>
  </div>
@endif




{{-- VALIDACIONES-RESPUESTA --}}
<div class="right_col" role="main">
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
          <div class="x_title">
            <div class="col-sm-2">
              <h2>Ingresar Paquetes</h2>
            </div>
            
            <div class="col-sm-2">
              <a href="{{ route('package_exports.exportPackageTemplate') }}" type="submit" class="btn btn-success offset-sm-1" id="BtnPackage">Plantilla</a>
            </div>
            <div class="col-sm-2">
              <form id="fileForm" method="POST" action="{{ route('package_imports.importPackageTemplate') }}" enctype="multipart/form-data" >
                @csrf
                <input id="file" type="file" value="import" accept=".xlsx" name="file" class="file">
              </form>
            </div>
             
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
              @isset($package)
                <div class="item form-group">
                <div class="col-sm-6">
                  <h3>Número de Paquete: {{ str_pad($package->id ?? 0, 6, "0", STR_PAD_LEFT)}}</h3>
                </div>
                </div>
              @endisset
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
             
                  <input type="text" id="client_casillero" onblur="getClient();" name="client_casillero" required="required" class="form-control " value="{{$package->clients['casillero'] ?? $client->casillero ?? ''}}">
             
               
                </div>
                
                  <a href="{{ route('clients.select') }}"  title="Buscar" ><i class="fa fa-search"></i></a>  
               
                <h5 id="label_client" class="col-form-label col-sm-3 justify-content-start" for="id_client">{{ $package->clients['firstname'] ?? $client->firstname ??  '' }} {{ $package->clients['firstlastname'] ?? $client->firstlastname ?? '' }}</h5>
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
              
              </div>
           
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align">Fecha Llegada:
                </label>
                <div class="col-sm-4">
                  <input id="arrival_date" name="arrival_date" class="date-picker form-control"  required="required" type="date" value="{{ date_format(date_create($package->arrival_date ?? $datenow ??null),"Y-m-d") }}">
                </div>
                <label class="col-form-label col-sm-3 label-align">Hora Llegada:
                </label>
                <div class="col-sm-3 ">
                  @if (isset($package->arrival_date))
                    <input id="check_in" name="check_in" class="date-picker form-control"  type="time"  value="{{ date_format(date_create($package->arrival_date ?? $datenow  ?? null),"H:i") }}">        
                  @else
                    <input id="check_in" name="check_in" class="date-picker form-control"  type="time"  >                   
                  @endif
                  </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="first-name">Ubicación Oficina:</label>
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="id_agency_office_location" required>
                      @if (isset($package))
                        <option value="{{ $package->id_agency_office_location ?? null }}">{{ $package->office_locations['name'] ?? null }} - {{ $package->office_locations['direction'] ?? null }}</option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($agencies))
                        @foreach ($agencies as $agency)
                          <option value="{{ $agency->id }}">{{ $agency->name ?? '' }} - {{ $agency->direction ?? '' }}</option>
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
                  <input type="text" id="value" name="value" required="required" class="form-control" value="{{ number_format($package->value ?? 0, 2, ',', '.') }}">
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
                  <input type="text" id="number_transport_guide" name="number_transport_guide"  class="form-control" value="{{ $package->number_transport_guide ?? null }}">
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
                  <input type="checkbox" name="checks[]"  id="myCheck"  value="high_value" onclick="myFunction();" >  Alto Valor: 
                </div> 
                <div class="col-sm-2">
                  <input type="checkbox" name="checks[]" id="dangerous_goods" value="dangerous_goods" data-parsley-mincheck="2" /> Merc. Peligrosa: 
                </div> 
                <div class="col-sm-2">
                  <input type="checkbox" name="checks[]" id="sed" value="sed" data-parsley-mincheck="2" /> SED: 
                </div> 
                <div class="col-sm-2">
                  <input type="checkbox" name="checks[]" id="document" value="document" data-parsley-mincheck="2" /> Documento: 
                </div> 
                <div class="col-sm-2">
                  <input type="checkbox" name="checks[]" id="fragile" value="fragile" data-parsley-mincheck="2" /> Fragil: 
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


  <div class="clearfix"></div>
  <div  class="row">
      <div id="formTypeofGoods" class="col-md-12 col-sm-12 ">
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


@if(isset($package))


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
                                <a href="#" class="delete_packages_lump" title="Eliminar" data-id-package_lump={{$package_lump->id}} data-toggle="modal" data-target="#deletePackagesLumpsModal"><i class="fa fa-trash text-danger"></i></a> 
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


<div class="clearfix"></div>
  <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <div class="col-md-2 col-sm-2 h5">
            Totales
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
                  <div class="item form-group form-horizontal form-label-left">
                    <label class="col-form-label col-sm-1 label-align " for="number_transport_guide">Peso Inicial:</label>
                    <div class="col-sm-1">
                      <input type="text"  class="form-control" value="{{ $package->starting_weight ?? 0 }}">
                    </div>
                    <label class="col-form-label col-sm-1 label-align " for="number_transport_guide">Peso Final:</label>
                    <div class="col-sm-1">
                      <input type="text"  class="form-control" value="{{ $package->final_weight ?? 0 }}">
                    </div>
                    <label class="col-form-label col-sm-1 label-align " for="number_transport_guide">Volumen:</label>
                    <div class="col-sm-1">
                      <input type="text"  class="form-control" value="{{ $package->volume ?? 0 }}">
                    </div>
                    <label class="col-form-label col-sm-1 label-align " for="number_transport_guide">Pie Cúbico:</label>
                    <div class="col-sm-1">
                      <input type="text"  class="form-control" value="{{ $package->cubic_foot ?? 0}}">
                    </div>
                    
                  </div>
                          
              </div>
          </div>
    </div>
</div>

@endif

@isset($package)
    
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
              <input id="id_package_modal" type="hidden" class="form-control @error('id_package_modal') is-invalid @enderror" value="{{$package->id}}" name="id_package_modal" readonly required autocomplete="id_package_modal">
                
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


<!-- Delete Warning Modal -->
<div class="modal modal-danger fade" id="deletePackagesLumpsModal" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
          <form action="{{ route('packages_lumps.delete')}}" method="post">
              @csrf
              @method('DELETE')
              <input id="id_packages_lump_modal" type="hidden" class="form-control @error('id_packages_lump_modal') is-invalid @enderror" name="id_packages_lump_modal" readonly required autocomplete="id_packages_lump_modal">
              <input id="id_package_modal2" type="hidden" class="form-control @error('id_package_modal') is-invalid @enderror" value="{{$package->id}}" name="id_package_modal" readonly required autocomplete="id_package_modal">
                     
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

@endisset

@endsection


@section('validation')
<script>
   $(".js-example-matcher").select2({
    matcher: matchCustom
    });

    function matchCustom(params, data) {
      // If there are no search terms, return all of the data
      if ($.trim(params.term) === '') {
        return data;
      }

      // Do not display the item if there is no 'text' property
      if (typeof data.text === 'undefined') {
        return null;
      }

      // `params.term` should be the term that is used for searching
      // `data.text` is the text that is displayed for the data object
      if (data.text.indexOf(params.term) > -1) {
        var modifiedData = $.extend({}, data, true);
        modifiedData.text += ' (matched)';

        // You can return modified objects from here
        // This includes matching the `children` how you want in nested data sets
        return modifiedData;
      }

      // Return `null` if the term should not be displayed
      return null;
    }

   
    
    function getClient(){
    
        var client_casillero    = document.getElementById("client_casillero").value;
        
      if(client_casillero != "")
      {
        $.ajax({
            url:"{{ route('clients.search','') }}" + '/' + client_casillero,
            beforSend:()=>{
                alert('consultando datos');
            },
            success:(response)=>{
               
                // console.clear();
                if(response.length > 0){
                    response.forEach((item, index, object)=>{
                        let {id,firstname,firstlastname} = item;
                       
                        if(firstlastname == null){
                          document.getElementById("label_client").innerHTML = firstname; 
                        }else{
                          document.getElementById("label_client").innerHTML = firstname+" "+firstlastname; 
                        }
                        

                    });
                }
                
                
            
            },
            error:(xhr)=>{
              alert("No se Encontro el Cliente");
            }
        })

      }
    }

    $("#formTypeofGoods").hide();

    function myFunction() {
      if(document.getElementById('myCheck').checked){
        $("#formTypeofGoods").show();
      }else{
        $("#formTypeofGoods").hide();
      }
      
    }

    $(document).ready(function () {
        $("#value").mask('000.000.000.000.000,00', { reverse: true });
        
    });        
    

    $(document).on('click','.delete_packages_type_of_good',function(){
        
        let id_packages_type_of_good = $(this).attr('data-id-packages_type_of_good');

        $('#id_packages_type_of_good_modal').val(id_packages_type_of_good);
    });

    $(document).on('click','.delete_packages_lump',function(){
        
        let id_packages_lump = $(this).attr('data-id-package_lump');

        $('#id_packages_lump_modal').val(id_packages_lump);
    });

   

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
  
  $("#file").on('change',function(){
      
      var file = document.getElementById("file").value;

      /*Extrae la extencion del archivo*/
      var basename = file.split(/[\\/]/).pop(),  // extract file name from full path ...
                                          // (supports `\\` and `/` separators)
      pos = basename.lastIndexOf(".");       // get last position of `.`

      if (basename === "" || pos < 1) {
          alert("El archivo no tiene extension");
      }          
      /*-------------------------------*/     

      if(basename.slice(pos + 1) == 'xlsx'){
        document.getElementById("fileForm").submit();
      }else{
        alert("Solo puede cargar archivos .xlsx");
      }            
          
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
 

@isset($package)
  <script>  
     if("{{isset($package)}}"){
      
      if("{{ (isset($package->high_value) && $package->high_value == '1') }}"){
        document.getElementById("myCheck").checked = true;
        
        if(document.getElementById('myCheck').checked){
          $("#formTypeofGoods").show();
        }else{
          $("#formTypeofGoods").hide();
        }   

      }if("{{(isset($package->dangerous_goods) && $package->dangerous_goods == 1)}}"){

        document.getElementById("dangerous_goods").checked = true;

      }if("{{(isset($package->sed) && $package->sed == 1)}}"){
        
        document.getElementById("sed").checked = true;

      }
      if("{{(isset($package->document) && $package->document == 1)}}"){

        document.getElementById("document").checked = true;

      }
      if("{{(isset($package->fragile) && $package->fragile == 1)}}"){

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
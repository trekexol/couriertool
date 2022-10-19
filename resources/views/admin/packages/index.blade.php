@extends('admin.layouts.dashboard')

@section('content')

{{-- VALIDACIONES-RESPUESTA--}}
@include('admin.layouts.success')   {{-- SAVE --}}
@include('admin.layouts.danger')    {{-- EDITAR --}}
@include('admin.layouts.delete')    {{-- DELELTE --}}
{{-- VALIDACIONES-RESPUESTA --}}
<div class="right_col" role="main">
 
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <div class="col-sm-2">
          <h2>Listado de Paquetes</h2>
        </div>
        <div class="col-sm-1">
          <a href="{{ route('package_exports.exportPackageManifiesto') }}" title="Paquetes en Origen Todos"><img src="{{asset('img/excel.png')}}" /> </a>
         </div>
        <div class="col-sm-1">
          <a href="{{ route('package_exports.exportPackage') }}" title="Paquetes en Origen AP"><img src="{{asset('img/excel.png')}}" /> </a>
        </div>
        <ul class="col-sm-1 nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
              <form id="formSearch" method="POST" action="{{ route('package_searchs.index') }}" enctype="multipart/form-data" >
                @csrf
              <div class="item form-group">
                <label class="col-form-label col-sm-2 label-align " for="first-name">Tipo de Envío:</label>
                <div class="col-sm-1">
                  <input type="radio" name="checks"  id="myCheck"  value="Todos"> <img for="myCheck" src="{{asset('img/todos.png')}}" />
                </div> 
                <div class="col-sm-1">
                  <input type="radio" name="checks" id="Aereo" value="Aéreo" data-parsley-mincheck="2" />  <img for="myCheck" src="{{asset('img/aereo.png')}}" />
                </div> 
                <div class="col-sm-1">
                  <input type="radio" name="checks" id="Maritimo" value="Marítimo" data-parsley-mincheck="2" /><img for="myCheck" src="{{asset('img/maritimo.png')}}" />
                </div> 
                <div class="col-sm-1">
                  <input type="radio" name="checks" id="MaritimoExpress" value="Marítimo Express" data-parsley-mincheck="2" /> <img for="myCheck" src="{{asset('img/maritimoexpres.png')}}" />
                </div> 
                <div class="col-sm-1">
                  <input type="radio" name="checks" id="Terrestre" value="Terrestre" data-parsley-mincheck="2" /> <img for="myCheck" src="{{asset('img/truck.png')}}" />
                </div> 
                
                <div class="col-sm-4">
                    <select class="select2_group form-control" name="status" required>
                      @if (isset($status))
                          <option >{{ $status }}</option>
                          <option disabled value="">--------------------</option>
                        @else
                          <option value="">Seleccione un Status</option>
                        @endif
                        
                        <option >(1) Recibido en Origen</option>
                        <option >(2) Embalado Para Despacho</option>
                        <option >(3) En Transporte Internacional</option>
                        <option >(4) Recibido Destino Principal</option>
                        <option >(5) En Ruta de Entrega</option>
                        <option >(6) Recibido en Agencia</option>
                        <option >(7) Entregado Cliente</option>
                        <option >(8) Entregado a Transporte</option>
                        <option >(9) Retenido / Hold</option>
                        <option >(10) Devuelto a la oficina</option>
                        <option >(11) Cliente no contactado</option>
                        <option >(32) En Transporte a Destino</option>
                        <option >(34) En Aduana</option>
                        <option >(66) Extraviado</option>
                        <option >(88) En Abandono</option>
                        <option >(89) Devolucion al Proveedor</option>
                      
                      </select>
                    </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-sm-1 label-align " for="first-name">Oficina:</label>
                <div class="col-sm-3">
                    <select class="select2_group form-control" name="id_agency" required>
                      @if (isset($agency_search))
                        <option value="{{ $agency_search->id ?? null }}">{{ $agency_search->name ?? null }} </option>
                        <option value="">---------------------</option>
                      @else
                        <option value="">Seleccione una Opción</option>
                      @endif
                      @if (isset($agencies))
                        @foreach ($agencies as $agency)
                          <option value="{{ $agency->id }}">{{ $agency->name ?? '' }} </option>
                        @endforeach
                      @endif
                    </select>
                </div>
                <label class="col-form-label col-sm-1 label-align " for="id_wharehouse">Almacen:</label>
                <div class="col-sm-3">
                    <select class="select2_group form-control" name="id_wharehouse" required>
                      @if (isset($wharehouse_search))
                        <option value="{{ $wharehouse_search->id ?? null }}">{{ $wharehouse_search->name ?? null }}</option>
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
                <label class="col-form-label col-sm-1 label-align " for="client">Cliente:</label>
                <div class="col-sm-2">
                  <input type="text" id="client" name="client"  class="form-control " value="{{ $search_client ?? null }}">
                </div>
                <a href="#" onclick="searchIndex();" title="Buscar" ><i class="fa fa-search"></i></a>  
              </div>
              </form>
        <table  class="table table-striped table-bordered" style="width:100%" > 
          <thead>
            <tr>
              <th>N°</th>
              <th>Pz</th>
              <th>Tracking</th>
              <th>Cliente</th>
              <th>Casillero</th>
              <th>Descripcion</th>
              <th>$</th>
              <th>Tipo</th>
              <th>Ins</th>
              <th>Oficina</th>
              <th>PC</th>
              <th>P</th>
              <th>PV</th>
              <th>Status</th>
              <th>Fecha</th>
              <th>O</th>
              <th></th>
            </tr>
          </thead>
          @php
               $cubic_foot = 0;
               $starting_weight = 0;
               $volume = 0;
           @endphp
          @isset($packages)
            @foreach ($packages as $package)
           @php
               $cubic_foot += $package->cubic_foot;
               $starting_weight += $package->starting_weight;
               $volume += $package->volume;

           @endphp
            <tr id="tr{{$package->id}}" >
              <td class="text-center">
                <a href="{{ route('packages.create',$package->id) }}"  title="Seleccionar">{{$package->id}}</a>
              </td>
              <td>{{$package->count_package_lumps ?? ''}}</td>
              <td>{{$package->tracking ?? ''}}</td>
              <td>{{$package->firstname ?? ''}} {{$package->firstlastname ?? ''}}</td>
              <td>{{$package->casillero ?? ''}}</td>
              <td>{{$package->description ?? ''}} </td>
              <td>
                @if (isset($package->date_payment) && $package->date_payment != null)
                  <a href="{{ route('packages.payment',$package->id) }}"><img src="{{asset('img/ok.png')}}" /> </a>
                @else
                  <a href="{{ route('packages.payment',$package->id) }}"><img src="{{asset('img/pagar.png')}}" /></a>
                @endif
              </td>
              <td>{{$package->instruction ?? ''}}</td>
              <td>
                @if ($package->instruction == "Aéreo")
                  <a href="{{ route('packages.tipoEnvio',$package->id) }}"><img src="{{asset('img/aereo.png')}}" /></a>
                @else
                  <a href="{{ route('packages.tipoEnvio',$package->id) }}"><img src="{{asset('img/maritimo.png')}}" /></a>
                @endif
              </td>
              <td>{{$package->agency_name ?? ''}}</td>
              <td>{{$package->cubic_foot ?? 0}}</td>
              <td>{{$package->starting_weight ?? 0}}</td>
              <td>{{$package->volume ?? 0}}</td>
              <td>{{$package->status ?? ''}}</td>
              <td>{{date_format(date_create($package->arrival_date ?? ''),"d-m-Y") }}</td>
              <td>{{$package->wharehouse_code ?? ''}}</td>
              <td>
                <a href="{{ route('packages.print',$package->id) }}"  title="Imprimir Etiquetas"><i class="fa fa-print"></i></a>
                <a href="{{ route('historial_status.viewPackage',$package->id) }}"  title="Ver Historial de Status"><i class="fa fa-question"></i></a>
                <a href="#" class="delete" data-id-package={{$package->id}} data-toggle="modal" data-target="#deleteModal" title="Eliminar"><i class="fa fa-trash text-danger"></i></a>  
                <a href="#" id="btnViewModal"
                  data-id="{{$package->id ?? null}}" 
                  data-tracking="{{$package->tracking ?? null}}" 
                  data-direction="{{$package->direction ?? null}}" 
                  data-street_received="{{$package->street_received ?? null}}" 
                  data-urbanization_received="{{$package->urbanization_received ?? null}}" 
                  data-name_agency_client="{{$package->name_agency_client ?? null}}" 
                  data-agent_shipper_name="{{$package->agent_shipper_name ?? null}}" 
                  data-agent_name="{{$package->agent_name ?? null}}" 
                  data-casillero="{{$package->casillero ?? null}}" 
                  data-firstname="{{$package->firstname ?? null}}" 
                  data-firstlastname="{{$package->firstlastname ?? null}}" 
                  data-agent_name_vendor="{{$package->agent_name_vendor ?? null}}" 
                  data-arrival_date="{{$package->arrival_date ?? null}}" 
                  data-agency_name="{{$package->agency_name ?? null}}" 
                  data-wharehouse_name="{{$package->wharehouse_name ?? null}}" 
                  data-arrival_date="{{$package->arrival_date ?? null}}" 
                  data-content="{{$package->content ?? null}}" 
                  data-value="{{$package->value ?? null}}" 
                  data-country_name="{{$package->country_name ?? null}}" 
                  data-destination_country_name="{{$package->destination_country_name ?? null}}" 
                  data-delivery_company_name="{{$package->delivery_company_name ?? null}}" 
                  data-service_type="{{$package->service_type ?? null}}" 
                  data-instruction="{{$package->instruction ?? null}}" 
                  data-instruction_type="{{$package->instruction_type ?? null}}"
                  data-description="{{$package->description ?? null}}"
                  data-status="{{$package->status ?? null}}"

                  data-dangerous_goods="{{$package->dangerous_goods ?? null}}"
                  data-sed="{{$package->sed ?? null}}"
                  data-document="{{$package->document ?? null}}"
                  data-fragile="{{$package->fragile ?? null}}"

                  data-starting_weight="{{$package->starting_weight ?? 0}}"
                  data-final_weight="{{$package->final_weight ?? 0}}"
                  data-volume="{{$package->volume ?? 0}}"
                  data-length_weight="{{$package->length_weight ?? 0}}"
                  data-high_weight="{{$package->high_weight ?? 0}}"
                  data-width_weight="{{$package->width_weight ?? 0}}"
                  data-guide="{{$package->guide ?? 0}}"
                  data-id_tula="{{$package->id_tula ?? 0}}"
                  data-id_paddle="{{$package->id_paddle ?? 0}}"
                  
                  data-toggle="modal" data-target="#showModal" title="Mostrar"><i class="fa fa-search"></i></a>  
              </td>
             
            </tr>
            @endforeach
            <tfoot>
            <tr>
              <td class="text-center">
              </td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>Total</td>
              <td>{{$cubic_foot ?? 0}}</td>
              <td>{{$starting_weight ?? 0}}</td>
              <td>{{$volume ?? 0}}</td>
              <td></td>
              <td></td>
              <td></td>
              <td>
               </td>
            </tr>
          </tfoot>
          @endisset
          

          </table>
        </div>
      </div>
    </div>
</div>
    </div>
  </div>
</div>

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
          <form action="{{ route('packages.delete') }}" method="post">
              @csrf
              @method('DELETE')
              <input id="id_package_modal" type="hidden" class="form-control @error('id_package_modal') is-invalid @enderror" name="id_package_modal" readonly required autocomplete="id_package_modal">
                     
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

<div class="modal fade bd-example-modal-lg" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      @isset($package)
      <br>
      <div class="row">
      <div class="offset-sm-1 col-sm-6">
        <h6 id="id_modal"></h6>
      </div>
      </div>
    @endisset
  
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-11 label-align-left" id="client_modal" style="font-size: x-small" for="id_client"></label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-11 label-align-left"  id="direction_modal" style="font-size: x-small" for="id_direccion"> </label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-11 label-align-left"  id="name_agency_client_modal" style="font-size: x-small" > </label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-11 label-align-left" id="agent_name_modal" style="font-size: x-small" for="first-name"> </label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-11 label-align-left" id="agent_shipper_name_modal" style="font-size: x-small" for="first-name"> </label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-6 label-align-left" id="arrival_date_modal" style="font-size: x-small">  </label>
      <label class="col-form-label col-sm-5 label-align-left" id="arrival_date_check_in_modal" style="font-size: x-small">  </label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-6 label-align-left " id="agency_name_modal" style="font-size: x-small" for="first-name"> </label>
      <label class="col-form-label col-sm-5 label-align-left " id="wharehouse_name_modal" style="font-size: x-small" for="id_wharehouse"></label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-6 label-align-left " id="content_modal" style="font-size: x-small" for="content"> </label>
      <label class="col-form-label col-sm-5 label-align-left " id="value_modal" style="font-size: x-small" for="value"></label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-6 label-align-left " id="country_name_modal" style="font-size: x-small" for="id_origin_country"> </label>
      <label class="col-form-label col-sm-5 label-align-left " id="destination_country_name_modal" style="font-size: x-small" for="id_destination_country"> </label>
    </div>
    <div class="row"> 
      <label class="col-form-label offset-sm-1 col-sm-6 label-align-left " id="tracking_modal" style="font-size: x-small" for="id_delivery_company"></label>
      <label class="col-form-label col-sm-5 label-align-left " id="delivery_company_name_modal" style="font-size: x-small" for="id_delivery_company"></label>
    </div>
    <div class="row"> 
      <label class="col-form-label offset-sm-1 col-sm-6 label-align-left " id="service_type_modal" style="font-size: x-small" for="service_type"> </label>
      <label class="col-form-label col-sm-5 label-align-left " id="instruction_modal" style="font-size: x-small" for="instruction"> </label>
    </div>

    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-6 label-align-left " id="description_modal" style="font-size: x-small" for="description"> </label>
      <label class="col-form-label col-sm-5 label-align-left " id="status_modal" style="font-size: x-small" for="description"></label>
     
    </div>
    <br>
    <div class="form-group row">
      <div class="offset-sm-1 col-sm-2">
       
          <input type="checkbox" id="dangerous_goods_modal" style="font-size: x-small" disabled value="dangerous_goods" data-parsley-mincheck="2" /> Merc. Peligrosa:
        
      </div> 
      <div class="col-sm-1">
       
          <input type="checkbox" id="sed_modal" style="font-size: x-small" disabled value="sed" data-parsley-mincheck="2" /> SED:
        
      </div> 
      <div class="col-sm-2">
       
          <input type="checkbox" id="document_modal" style="font-size: x-small" disabled value="document" data-parsley-mincheck="2" /> Documento:
        
      </div> 
      <div class="col-sm-2">
       
          <input type="checkbox" id="fragile_modal" style="font-size: x-small" disabled value="fragile" data-parsley-mincheck="2" /> Fragil:
        
      </div> 
      <label class="col-form-label col-sm-4 label-align-left " id="number_transport_guide_modal" style="font-size: x-small" for="number_transport_guide"><strong>N° Guía Transporte:</strong> {{$package_modal->number_transport_guide ?? ''}}</label>
    </div>
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-2 label-align-left " id="starting_weight_modal" style="font-size: x-small" > </label>
      <label class="col-form-label col-sm-2 label-align-left " id="final_weight_modal" style="font-size: x-small" > </label>
      <label class="col-form-label col-sm-2 label-align-left " id="volume_modal" style="font-size: x-small" > </label>
      <label class="col-form-label col-sm-5 label-align-left " id="weight_modal" style="font-size: x-small" > </label>
    </div>
    
    <div class="row">
      <label class="col-form-label offset-sm-1 col-sm-2 label-align-left " id="_modal" style="font-size: x-small" > </label>
      <label class="col-form-label col-sm-2 label-align-left " id="_modal" style="font-size: x-small" > </label>
      <label class="col-form-label col-sm-2 label-align-left " id="_modal" style="font-size: x-small" ><strong>Paleta:</strong> {{$package_modal->id_paddle ?? ''}}</label>
      <label class="col-form-label col-sm-2 label-align-left " id="_modal" style="font-size: x-small" ><strong>Ruta:</strong> </label>
      <label class="col-form-label col-sm-2 label-align-left " id="_modal" style="font-size: x-small" ><strong>Consolidado:</strong> </label>
    </div>

    <table style="width: 50%;">
      <tr>
        <th id="_modal" style="text-align: center; font-weight: bold; width: 79%; border-bottom-color: white;">CONCEPTO	</th>
        <th id="_modal" style="text-align: center; font-weight: bold; width: 21%;">MONTO</th>
      </tr> 
      <tr>
        <th id="_modal" style="text-align: center; font-weight: bold; width: 79%; border-bottom-color: white;">ENVIO INTERNACIONAL</th>
        <th id="_modal" style="text-align: center; font-weight: normal; width: 21%;"></th>
      </tr> 
      <tr>
        <th id="_modal" style="text-align: center; font-weight: bold; width: 21%;">TARIFA NACIONAL</th>
        <th id="_modal" style="text-align: center; font-weight: normal; width: 79%; border-bottom-color: white;"></th>
      </tr> 
      <tr>
        <th id="_modal" style="text-align: center; font-weight: bold; width: 21%;">TOTAL CARGOS..</th>
        <th id="_modal" style="text-align: center; font-weight: normal; width: 79%; border-bottom-color: white;"></th>
      </tr> 


    </table>
    <br>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <a href="{{ route('packages.create',$package->id) }}" type="submit" class="btn btn-info offset-sm-1" >Mas info</a>
      </div>
      <div class="col-sm-2">
        <a href="{{ route('packages.create',$package->id) }}" type="submit" class="btn btn-success offset-sm-1" >Editar</a>
      </div>
      <div class="col-sm-1">
        <a href="{{ route('packages.create',$package->id) }}" type="submit" class="btn btn-danger offset-sm-1" >Regresar</a>
      </div>
    </div>

    </div>
  </div>
</div>

@endsection

@section('validation')

<script>


    $(document).on('click','#btnViewModal',function(){
     
        document.getElementById('id_modal').innerHTML = "<strong>Identificación del paquete:</strong> "+$(this).attr('data-id');
        document.getElementById('client_modal').innerHTML = "<strong>Cliente:</strong> "+$(this).attr('data-casillero')+" "+$(this).attr('data-firstname')+" "+$(this).attr('data-firstlastname');
        document.getElementById('tracking_modal').innerHTML = "<strong>Tracking:</strong> "+$(this).attr('data-tracking');
        document.getElementById('direction_modal').innerHTML = "<strong>Dirección:</strong> "+$(this).attr('data-direction')+" "+$(this).attr('data-urbanization_received');
        document.getElementById('name_agency_client_modal').innerHTML = "<strong>Agencia:</strong> "+$(this).attr('data-name_agency_client');
        document.getElementById('agent_shipper_name_modal').innerHTML = "<strong>Vendedor:</strong> "+$(this).attr('data-agent_shipper_name');
        document.getElementById('agent_name_modal').innerHTML = "<strong>Agente Vendedor:</strong> "+$(this).attr('data-agent_name');
        document.getElementById('agency_name_modal').innerHTML = "<strong>Ubicación Oficina:</strong> "+$(this).attr('data-agency_name');
        document.getElementById('arrival_date_modal').innerHTML = "<strong>Fecha de Llegada:</strong> "+$(this).attr('data-arrival_date');
        document.getElementById('status_modal').innerHTML = "<strong>Estatus:</strong> "+$(this).attr('data-status');
        document.getElementById('wharehouse_name_modal').innerHTML = "<strong>Almacen:</strong> "+$(this).attr('data-wharehouse_name');
        document.getElementById('content_modal').innerHTML = "<strong>Contenido:</strong> "+$(this).attr('data-content');
        document.getElementById('value_modal').innerHTML = "<strong>Valor:</strong> "+$(this).attr('data-value');
        document.getElementById('country_name_modal').innerHTML = "<strong>Origen:</strong> "+$(this).attr('data-country_name');
        document.getElementById('destination_country_name_modal').innerHTML = "<strong>Destino:</strong> "+$(this).attr('data-destination_country_name');
        document.getElementById('delivery_company_name_modal').innerHTML = "<strong>Entregado por:</strong> "+$(this).attr('data-delivery_company_name');
        document.getElementById('service_type_modal').innerHTML = "<strong>Tipo Servicio:</strong> "+$(this).attr('data-service_type');
        document.getElementById('instruction_modal').innerHTML = "<strong>Instrucciones:</strong> "+$(this).attr('data-instruction')+" "+$(this).attr('data-instruction_type');
        document.getElementById('description_modal').innerHTML = "<strong>Descrip/Coment:</strong> "+$(this).attr('data-description');
        document.getElementById('status_modal').innerHTML = "<strong>Estatus:</strong> "+$(this).attr('data-status');

        if($(this).attr('data-dangerous_goods') == true){
          document.getElementById("dangerous_goods_modal").checked = true;
        }
        if($(this).attr('data-sed') == true){
          document.getElementById("sed_modal").checked = true;
        }
        if($(this).attr('data-document') == true){
          document.getElementById("document_modal").checked = true;
        }
        if($(this).attr('data-fragile') == true){
          document.getElementById("fragile_modal").checked = true;
        }

        document.getElementById('starting_weight_modal').innerHTML = "<strong>Peso inicial:</strong> "+$(this).attr('data-starting_weight');
        document.getElementById('final_weight_modal').innerHTML = "<strong>Peso Final:</strong> "+$(this).attr('data-final_weight');
        document.getElementById('volume_modal').innerHTML = "<strong>Volumen:</strong> "+$(this).attr('data-volume');
        document.getElementById('weight_modal').innerHTML = "<strong>Dimensiones:</strong> "+$(this).attr('data-length_weight')+" "+$(this).attr('data-width_weight')+" "+$(this).attr('data-high_weight');
        document.getElementById('guide_modal').innerHTML = "<strong>Guía:</strong> "+$(this).attr('data-guide');
        document.getElementById('id_tula_modal').innerHTML = "<strong>Tula:</strong> "+$(this).attr('data-id_tula');
        document.getElementById('id_paddle_modal').innerHTML = " "+$(this).attr('data-id_paddle');
        
        
        
     });




    function searchIndex(){
      document.getElementById("formSearch").submit();
    }


    $(document).on('click','.delete',function(){
         
         let id_package = $(this).attr('data-id-package');
 
         $('#id_package_modal').val(id_package);
     });

  
   
    
</script>
@if(isset($shipping_type))
<script>
  if("{{$shipping_type}}" == 'Todos'){
    document.getElementById("myCheck").checked = "true";
  }
  if("{{$shipping_type}}" == 'Aéreo'){
    document.getElementById("Aereo").checked = "true";
  }
  if("{{$shipping_type}}" == 'Marítimo'){
    document.getElementById("Maritimo").checked = "true";
  }
  if("{{$shipping_type}}" == 'Marítimo Express'){
    document.getElementById("MaritimoExpress").checked = "true";
  }
  if("{{$shipping_type}}" == 'Terrestre'){
    document.getElementById("Terrestre").checked = "true";
  }
</script>
@else
<script>
  
  document.getElementById("myCheck").checked = "true";

</script>
@endif

  @isset($packages)
    @foreach ($packages as $package)
      <script>

        if("{{$package->status}}" == "(1) Recibido en Origen"){
          document.getElementById("tr{{$package->id}}").style.color = "black";
        }
        if("{{$package->status}}" == "(2) Embalado Para Despacho"){
          document.getElementById("tr{{$package->id}}").style.color = "green";
        }
        if("{{$package->status}}" == "(3) En Transporte Internacional"){
          document.getElementById("tr{{$package->id}}").style.color = "#D7837F";
        }
        if("{{$package->status}}" == "(4) Recibido Destino Principal"){
          document.getElementById("tr{{$package->id}}").style.color = "blue";
        }
        if("{{$package->status}}" == "(5) En Ruta de Entrega"){
          document.getElementById("tr{{$package->id}}").style.color = "#7FFFD4";
        }
        if("{{$package->status}}" == "(7) Entregado Cliente"){
          document.getElementById("tr{{$package->id}}").style.color = "#FF8C00";
        }
        if("{{$package->status}}" == "(8) Entregado a Transporte"){
          document.getElementById("tr{{$package->id}}").style.color = "#FF1493";
        }
        if("{{$package->status}}" == "(9) Retenido / Hold"){
          document.getElementById("tr{{$package->id}}").style.color = "#DC143C";
        }
        if("{{$package->status}}" == "(10) Devuelto a la oficina"){
          document.getElementById("tr{{$package->id}}").style.color = "#FF7F50";
        }
        if("{{$package->status}}" == "(11) Cliente no contactado"){
          document.getElementById("tr{{$package->id}}").style.color = "#D2691E";
        }
        if("{{$package->status}}" == "(32) En Transporte a Destino"){
          document.getElementById("tr{{$package->id}}").style.color = "#8A2BE2";
        }
        if("{{$package->status}}" == "(34) En Aduana"){
          document.getElementById("tr{{$package->id}}").style.color = "#800000";
        }
        if("{{$package->status}}" == "(66) Extraviado"){
          document.getElementById("tr{{$package->id}}").style.color = "#32CD32";
        }
        if("{{$package->status}}" == "(88) En Abandono"){
          document.getElementById("tr{{$package->id}}").style.color = "black";
        }
        if("{{$package->status}}" == "(89) Devolucion al Proveedor"){
          document.getElementById("tr{{$package->id}}").style.color = "#FFFF00";
        }

        
      </script>
    @endforeach
  @endisset
@endsection

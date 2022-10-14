@extends('clients.layouts.dashboard')

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


       
          <div class="col-sm-4 offset-sm-4 h5">
            Lista de Paquetes en Transito
          </div>
          
        
          <div class="clearfix"></div>
       
      </div>
      <div class="x_content">
          <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
      
        <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Paquete</th>
              <th>Tracking</th>
              <th>Destinatario</th>
              <th>Descripción</th>
              <th>Peso/Vol</th>
              <th>Tipo de Envío</th>
              <th>Envío</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          @isset($package_trackings)
            @foreach ($package_trackings as $package_tracking)
            <tr>
              <td>{{$package_tracking->id}}</td>
              <td>
                <a href="{{ route('packages.createByTracking',$package_tracking->tracking) }}"  title="Mostrar">{{ $package_tracking->tracking }}</a>
              </td>
              <td>{{$package_tracking->client_recipients['name'] ?? ''}}</td>
              <td>{{$package_tracking->description ?? ''}}</td>
              <td></td>
              <td>{{$package_tracking->instruction ?? ''}}</td>
              <td></td>
              <td>{{$package_tracking->status ?? ''}}</td>
              <td>
                <a href="#" id="btnViewModal" class="search" 
                  data-tracking="{{$package_tracking->tracking ?? null}}" 
                  data-shipper="{{$package_tracking->shippers['name'] ?? null}}" 
                  data-client="{{$package_tracking->clients['firstname'] ?? null}}" 
                  data-agent_vendor="{{$package_tracking->vendors['name'] ?? null}}" 
                  data-arrival_date="{{date_format(date_create($package_tracking->arrival_date ?? null),"Y-m-d")}}" 
                  data-check_in="{{date_format(date_create($package_tracking->arrival_date ?? null),"H:i")}}" 
                  data-office_location="{{$package_tracking->office_locations['direction'] ?? null}}" 
                  data-wharehouse="{{$package_tracking->wharehouses['name']  ?? null}}" 
                  data-content="{{$package_tracking->content ?? null}}" 
                  data-value="{{$package_tracking->value ?? null}}" 
                  data-origin_country="{{$package_tracking->origin_countries['name'] ?? null}}"
                  data-destination_country="{{$package_tracking->destination_countries['name'] ?? null}}" 
                  data-delivery_company="{{$package_tracking->delivery_companies['description'] ?? null}}" 
                  data-number_transport_guide="{{$package_tracking->number_transport_guide ?? null}}" 
                  data-service_type="{{$package_tracking->service_type ?? null}}" 
                  data-instruction="{{$package_tracking->instruction ?? null}}" 
                  data-instruction_type="{{$package_tracking->instruction_type ?? null}}" 
                  
                  data-toggle="modal" data-target="#viewModal" title="Ver"><i class="fa fa-search text-primary"></i></a>  
                <a href="{{ route('historial_status.viewPackage',$package_tracking->id) }}"  title="Ver Historial de Status"><i class="fa fa-question"></i></a>
              </td>
            </tr>
            @endforeach
          @endisset
          

          </table>
        </div>
      </div>
    </div>
</div>
    </div>
  </div>
</div>

<div class="modal fade modal-danger viewModal" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Información del Paquete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
      
      
      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align " for="tracking">Tracking </label>
        <div class="col-sm-4">
          <input type="text" id="tracking" name="tracking" required="required" class="form-control " >
        </div>
        <label class="col-form-label col-sm-3 label-align " for="id_agent_shipper">Shipper: </label>
        <div class="col-sm-3">
          <input type="text" id="shipper" name="shipper" required="required" class="form-control " >
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align " for="id_client">Cliente</label>
        <div class="col-sm-4">
          <input type="text" id="client" name="client" required="required" class="form-control " >
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align " for="first-name">Agente Vendedor:</label>
        <div class="col-sm-4">
          <input type="text" id="agent_vendor" name="agent_vendor" required="required" class="form-control " >
        </div>
      
      </div>
   
      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align">Fecha Llegada:
        </label>
        <div class="col-sm-4">
          <input id="arrival_date" name="arrival_date" class="date-picker form-control"  required="required" type="date" >
        </div>
        <label class="col-form-label col-sm-3 label-align">Hora Llegada:
        </label>
        <div class="col-sm-3 ">
            <input id="check_in" name="check_in" class="date-picker form-control"  type="time" required="required" >     
          </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align " for="first-name">Ubicación Oficina:</label>
        <div class="col-sm-4">
          <input type="text" id="office_location" name="office_location" required="required" class="form-control " >
        </div>
        <label class="col-form-label col-sm-3 label-align " for="id_wharehouse">Almacen:</label>
        <div class="col-sm-3">
          <input type="text" id="wharehouse" name="wharehouse" required="required" class="form-control " >
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align " for="content">Contenido:</label>
        <div class="col-sm-4">
          <input type="text" id="content" name="content" required="required" class="form-control " >
        </div>
        <label class="col-form-label col-sm-3 label-align " for="value">Valor:</label>
        <div class="col-sm-3">
          <input type="text" id="value" name="value" required="required" class="form-control" >
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align " for="id_origin_country">País de Origen:</label>
        <div class="col-sm-4">
          <input type="text" id="origin_country" name="origin_country" required="required" class="form-control " >
        </div>
        <label class="col-form-label col-sm-3 label-align " for="id_destination_country">País de Destino:</label>
        <div class="col-sm-3">
          <input type="text" id="destination_country" name="destination_country" required="required" class="form-control " >
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align " for="id_delivery_company">Entregado por:</label>
        <div class="col-sm-4">
          <input type="text" id="delivery_company" name="delivery_company" required="required" class="form-control " >
        </div>
        <label class="col-form-label col-sm-3 label-align " for="number_transport_guide">N° Guía Transporte:</label>
        <div class="col-sm-3">
          <input type="text" id="number_transport_guide" name="number_transport_guide" required="required" class="form-control">
        </div>
      </div>

      <div class="item form-group">
        <label class="col-form-label col-sm-1 label-align " for="service_type">Tipo Servicio:</label>
        <div class="col-sm-4">
          <input type="text" id="service_type" name="service_type" required="required" class="form-control " >
        </div>
        <label class="col-form-label col-sm-3 label-align " for="instruction">Instrucciones:</label>
        <div class="col-sm-2">
          <input type="text" id="instruction" name="instruction" required="required" class="form-control " >
        </div>
        <div class="col-sm-2">
          <input type="text" id="instruction_type" name="instruction_type" required="required" class="form-control " >
        </div>
      </div>




    </div>
    </div>
  </div>
</div>

@endsection


@section('validation')

<script>
    $(document).on('click','#btnViewModal',function(){
         $('#tracking').val($(this).attr('data-tracking'));
         $('#shipper').val($(this).attr('data-shipper'));
         $('#client').val($(this).attr('data-client'));
         $('#agent_vendor').val($(this).attr('data-agent_vendor'));
         $('#arrival_date').val($(this).attr('data-arrival_date'));
         $('#check_in').val($(this).attr('data-check_in'));
         $('#office_location').val($(this).attr('data-office_location'));
         $('#wharehouse').val($(this).attr('data-wharehouse'));
         $('#content').val($(this).attr('data-content'));
         $('#value').val($(this).attr('data-value'));
         $('#origin_country').val($(this).attr('data-origin_country'));
         $('#destination_country').val($(this).attr('data-destination_country'));
         $('#delivery_company').val($(this).attr('data-delivery_company'));
         $('#number_transport_guide').val($(this).attr('data-number_transport_guide'));
         $('#service_type').val($(this).attr('data-service_type'));
         $('#instruction').val($(this).attr('data-instruction'));
         $('#instruction_type').val($(this).attr('data-instruction_type'));
     });
</script>
@endsection
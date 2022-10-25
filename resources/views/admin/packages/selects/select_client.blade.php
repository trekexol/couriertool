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
        <div class="col-sm-8">
          <h2>Seleccionar Cliente</h2>
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
      
                  <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;"></th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                      </tr>
                    </thead>
                    @isset($clients)
                      @foreach ($clients as $client)
                      <tr>
                        <td class="text-center">
                          <a href="{{ route('packages.createWithClient',[$client->id,$id_package ?? null]) }}"  title="Seleccionar"><i class="fa fa-check"></i></a>
                        </td>
                        <td>{{$client->type_cedula ?? ''}} {{$client->cedula ?? ''}}</td>
                        <td>{{$client->firstname ?? ''}} {{$client->firstlastname ?? ''}}</td>
                        <td>{{$client->direction ?? ''}}</td>
                        <td>{{$client->phone_room ?? ''}}</td>
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

@endsection


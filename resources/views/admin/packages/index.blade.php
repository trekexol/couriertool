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
          <h2>Listado de Paquetes</h2>
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
          @isset($packages)
            @foreach ($packages as $package)
            <tr>
              <td class="text-center">
                <a href="{{ route('packages.create',$package->id) }}"  title="Seleccionar">{{$package->id}}</a>
              </td>
              <td>{{$package->tracking ?? ''}}</td>
              <td>{{$package->clients['firstname'] ?? ''}} {{$package->clients['firstlastname'] ?? ''}}</td>
              <td>{{$package->clients['type_cedula'] ?? ''}}{{$package->clients['cedula'] ?? ''}}</td>
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
  </div>
</div>

@endsection

@section('validation')

<script>
   
</script>
@endsection

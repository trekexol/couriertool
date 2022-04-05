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
          <h2>Listado de Tulas</h2>
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
              <th>Agente</th>
              <th>Destino</th>
              <th>Referencia</th>
              <th>Peso</th>
              <th>PV</th>
              <th>Guía</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          @isset($tulas)
            @foreach ($tulas as $tula)
            <tr>
              <td class="text-center">
                <a href="{{ route('tulas.create',$tula->id) }}"  title="Seleccionar">{{$tula->id}}</a>
              </td>
              <td>{{$tula->agents['name'] ?? ''}}</td>
              <td>{{$tula->states['name'] ?? ''}}</td>
              <td>{{$tula->reference ?? ''}}</td>
              <td>{{$tula->weight ?? ''}}</td>
              <td>{{$tula->volume ?? ''}}</td>
              <td></td>
              <td>{{$tula->status ?? ''}}</td>
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

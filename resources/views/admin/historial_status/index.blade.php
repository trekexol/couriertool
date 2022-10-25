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
            <div class="col-md-8 col-sm-8 h5">
              Registrar en el Historial de Status
            </div>
            
            <ul class="col-sm-1 nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
                <form method="POST" action="{{ route('historial_status.store') }}" id="form" data-parsley-validate class="form-horizontal form-label-left">
                  @csrf
                        <input type="hidden" id="id_package" name="id_package" value="{{$id_package}}">
                        <div class="item form-group form-horizontal form-label-left">
                          <label class="col-form-label col-sm-1 label-align " for="service_type">Status:</label>
                          <div class="col-sm-4">
                              <select class="select2_group form-control" name="status" required>
                                @if (isset($historia))
                                  <option >{{ $historia->status }}</option>
                                  <option disabled value="">--------------------</option>
                                @else
                                  <option value="">Seleccione una Opción</option>
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
                          </div>
                        </div>
                        <div class="item form-group form-horizontal form-label-left">
                          <label class="col-form-label col-sm-1 label-align " for="service_type">Descripción:</label>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="description_status" rows="3">{{$historia->description_status ?? ''}}</textarea>
                          </div>
                        </div>
                        <div class="item form-group form-horizontal form-label-left">
                          <label class="col-form-label col-sm-1 label-align " for="service_type">N° Guía Transporte:</label>
                          <div class="col-sm-8">
                            <input type="text" id="number_guide_transport" name="number_guide_transport" class="form-control" value="{{$historia->number_guide_transport ?? ''}}">
                          </div>
                        </div>

                        <div id="contenedor"></div>
                        <br>
                        <div class="form-row">
                            <div class="col-sm-2">
                              @if (isset($historia))
                                <a href="#" onclick="update()" class="btn btn-success offset-sm-1" id="enviar">Actualizar</a>
                              @else
                                <button class="btn btn-primary offset-sm-1" id="enviar">Registrar</button>
                              @endif
                            </div>
                            <div class="col-sm-2">
                              <a href="{{route($return ?? 'packages.index')}}" class="btn btn-success offset-sm-1" id="enviar">Volver</a>
                            </div>
                        </div>

                    </form>
                </div>
              </div>
          </div>

  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
          <div class="col-sm-4 h5">
            Historial de Status
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
              <th>Status</th>
              <th>Descripción</th>
              <th>N° Guía Transporte:</th>
              <th></th>
            </tr>
          </thead>
          @isset($historial_status)
            @foreach ($historial_status as $historial_statu)
            <tr>
              <td>
                {{$historial_statu->status ?? ''}}
              </td>
              <td>{{$historial_statu->description_status ?? ''}}</td>
              <td>{{$historial_statu->number_guide_transport ?? ''}}</td>
              <td>
                <a href="{{ route('historial_status.edit',$historial_statu->id) }}"  title="Editar"><i class="fa fa-edit"></i></a>
                <a href="#" class="delete" data-id-historial_statu={{$historial_statu->id}} data-toggle="modal" data-target="#deleteModal" title="Eliminar"><i class="fa fa-trash text-danger"></i></a>  
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
          <form action="{{ route('historial_status.delete') }}" method="post">
              @csrf
              @method('DELETE')
              <input id="id_historial_statu_modal" type="hidden" class="form-control @error('id_historial_statu_modal') is-invalid @enderror" name="id_historial_statu_modal" readonly required autocomplete="id_historial_statu_modal">
              <input type="hidden" id="id_package_modal" name="id_package_modal" value="{{$id_package}}">
                             
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
      $(document).on('click','.delete',function(){
          
          let id_historial_statu = $(this).attr('data-id-historial_statu');
  
          $('#id_historial_statu_modal').val(id_historial_statu);
      });
  </script>

  @isset($historia)
    <script>
        function update(){
          document.getElementById("form").action = "{{ route('historial_status.update',$historia->id) }}";
          document.getElementById("form").submit();
        }
        
    </script>
  @endisset


@endsection
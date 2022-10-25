<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="{{asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('build/css/custom.min.css')}}" rel="stylesheet">

     <!-- Bootstrap -->
     <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

     <!-- Datatables -->
     <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
     <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
     <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
     <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
     <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
 
     <!-- Select 
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
     <link href="{{asset('select/select2/dist/css/select2.min.css')}}" rel="stylesheet" />

    

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><span>CourierTool</span></a>
            </div>

            
            @include('admin.layouts.dashboard_sidebar')

         
        </div>

        <!-- top navigation -->
        @include('admin.layouts.dashboard_topbar')
        <!-- /top navigation -->
        <!-- Logout Modal-->
        
        <!-- page content -->
        @yield('content')
      
          <!-- /top tiles -->

         
        <!-- /page content -->

        
        <footer>
          <div class="pull-right">
           
          </div>
          <div class="clearfix"></div>
        </footer>
       
        <!-- /footer content -->
      </div>
     
    </div>
    
  </div>
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Seguro que desea Cerrar Sesión?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <div class="modal-body">Seleccione "Cerrar Sesión" si desea salir de CourierTool</div>
          <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
              <a class="btn btn-primary" href="{{ route('logout') }}"onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              Cerrar Sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
      </div>
    </div>
  </div>
    <!-- jQuery -->
    <script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('vendors/nprogress/nprogress.js')}}"></script>
    <!-- Chart.js -->
    <script src="{{asset('vendors/Chart.js/dist/Chart.min.js')}}"></script>
    <!-- gauge.js -->
    <script src="{{asset('vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('vendors/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <script src="{{asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('vendors/flot.curvedlines/curvedLines.js')}}"></script>
    <!-- DateJS -->
    <script src="{{asset('vendors/DateJS/build/date.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('build/js/custom.js')}}"></script>
    
    <!-- SELECT MULTIPLE 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->
    <script src="{{asset('select/select2/dist/js/select2.min.js') }}"></script>
	
   <!-- TERMINA AQUI -->


    <script src="{{asset('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
	
     <!-- Datatables -->
     <script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
     <script src="{{asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
     <script src="{{asset('vendors/jszip/dist/jszip.min.js')}}"></script>
     <script src="{{asset('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
     <script src="{{asset('vendors/pdfmake/build/vfs_fonts.js')}}"></script>

    <!-- Para las mascaras -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>

      <script>
       var $MENU_TOGGLE = $('#menu_toggle');
       
          
          $BODY.toggleClass('nav-md nav-sm');

          setContentHeight();

   
      </script>

        
    @yield('validacion_time')
     @yield('eo')
     @yield('country')
     @yield('validation')
     
  </body>
</html>

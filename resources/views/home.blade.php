@extends('layouts.app')
@include('layouts.menu')   
@section('content')

 @include('layouts.barrasup') 
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                @if(isset($emp))
                  <h3>{{$emp}}</h3>
                @endif
                <p>Empresas</p>
              </div>
              <div class="icon">
                <i class="icon ion-android-exit"></i>
              </div>
              <a href="#" id="emptbl" class="small-box-footer">Ver Empresas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                @if(isset($car))
                  <h3 style="color:white !important;">{{$car}}</h3>
                @endif
                <p style="color:white !important;">Carteras</p>
              </div>
              <div class="icon">
                <i class="icon ion-briefcase"></i>
              </div>
              <a href="#" id="cartbl" class="small-box-footer" style="color:white !important;">Ver Carteras <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                @if(isset($age))
                  <h3>{{$age}}</h3>
                @endif
                <p>Agentes a evaluar</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" id="evatbl" class="small-box-footer">Ver Agentes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                 @if(isset($pau))
                  <h3>{{$pau}}</h3>
                @endif
                <p>Pautas</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" id="audtbl" class="small-box-footer">Ver Pauta <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="col-md-12" id='divtblhome' style="display:none">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">EMPRESAS</h3>
            </div>
            <div class="card-body p-0">
              <table class="table" id='tbl_emp_home'>
                <thead>
                  <tr>
                    <th>Paìs</th>
                    <th>RUT</th>
                    <th>Nombre</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-12" id='divtblhomecar' style="display:none">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">SOLO CARTERAS ACTIVAS</h3>
            </div>
            <div class="card-body p-0">
              <table class="table" id='tbl_car_home'>
                <thead>
                  <tr>
                    <th>Pais</th>
                    <th>Empresa</th>
                    <th>Pauta</th>
                    <th>Nombre de cartera</th>
                    <th>Tipo de Cartera</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-12" id='divtblhomeag' style="display:none">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">AGENTES</h3>
            </div>
            <div class="card-body p-0">
              <table class="table" id="tbl_eval_home">
                <thead>
                  <tr>
                    <th>Cartera</th>
                    <th>Nombre agente</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>

         <div class="col-md-12" id='divtblhomeaud' style="display:none">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">PAUTAS</h3>
            </div>
            <div class="card-body p-0">
              <table class="table" id="tbl_aud_home">
                <thead>
                  <tr>
                    <th>Nombre Pauta</th>
                    <th>Descripción</th>
                    <th>Vigente</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        

        <div class="row" style="display:none">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
              <!-- solid sales graph -->
            <div class="card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Sales Graph
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <input type="text"  data-readonly="true" value="20" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">Mail-Orders</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <input type="text"  data-readonly="true" value="50" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <input type="text"  data-readonly="true" value="30" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">In-Store</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

    

           
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('layouts.footer') 
</body>



@include('layouts.script')

<!--mostrar tabla de empresas-->
<script type="text/javascript">
$(document).on('click','#emptbl',function(e) {
    
    $("#divtblhome").css('display', 'block');
    $("#divtblhomeag").css('display', 'none');
    $("#divtblhomecar").css('display', 'none');
    $("#divtblhomeaud").css('display', 'none');

    $("#divtblhome").show();
    e.preventDefault();
    var inp_tabla    = "emp_home";
    var url          = "{{route('empresastbl')}}";
    $("#tbl_"+inp_tabla+"_processing.dataTables_processing").show();
    $("#tbody-"+inp_tabla+"").empty();


    var id_tabla      = "tbl_"+inp_tabla;
    var sourceURL =url; 
    var dataTable;
    var oSettings;  
       
     dataTable= $('#'+id_tabla+'').DataTable( {
      destroy: true,
      dom: "<'row'<'col-lg-4'l><'col-lg-4'B><'col-lg-4'f>>rtip",

      "processing": true,
      "paging": true,
      "searching": true,
      "info": true,
       scrollY: '30vh',
       select: 'single',

      "ajax": {  
          "url": sourceURL,
          "dataSrc": "arrays",
      },
      "columns": [
            {"data":"nombre_pais"},
            {"data":"rutEmpresa"},
            {"data":"nombre_empresa"},
      ],
    // "columnDefs": [ 
    // {
    //   "targets": 0,
    //   "data": "description",
    //   "render": function ( data, type, full, meta ) {
    //     return '<input type="checkbox" name="" class="cls-chk-'+inp_tabla+'" data-id="'+full.ID_Transf+'" data-estado="'+full.Estado_ID+'">'
    //   }
    // },
    // ],

        "oLanguage": {
          "sLengthMenu": "Mostrando _MENU_ registros por página",
          "sZeroRecords": "Sin registros",
          "sInfoEmpty": "Mostrando 0 al 0 de 0 Registros",
          "sInfoFiltered": "(filtrando de _MAX_ total registros)",
          "sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
          "sSearch": "" ,
          "sSearchPlaceholder": "Buscar...",
                "sLoadingRecords": "Cargando...<i class='fa fa-spinner fa-spin'></i>",
                "oPaginate": {
                    "sFirst":   "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious":"Anterior"
                },  
        } ,     
    } );


  return false;    
});
</script>

<!--mostrar tabla de Carteras-->
<script type="text/javascript">
$(document).on('click','#cartbl',function(e) {
    //alert('SI ENTRO');
    $("#divtblhome").css('display', 'none');
    $("#divtblhomeag").css('display', 'none');
    $("#divtblhomecar").css('display', 'block');
    $("#divtblhomeaud").css('display', 'none');


    $("#divtblhomecar").show();
    e.preventDefault();
    var inp_tabla    = "car_home";
    var url          = "{{route('carterastbl')}}";
    $("#tbl_"+inp_tabla+"_processing.dataTables_processing").show();
    $("#tbody-"+inp_tabla+"").empty();

    var id_tabla      = "tbl_"+inp_tabla;
    var sourceURL =url; 
    var dataTable;
    var oSettings;  
       
     dataTable= $('#'+id_tabla+'').DataTable( {
      destroy: true,
      dom: "<'row'<'col-lg-4'l><'col-lg-4'B><'col-lg-4'f>>rtip",
      "processing": true,
      "paging": true,
      "searching": true,
       scrollY: '30vh',
      "info": true,
       select: 'single',

      "ajax": {  
          "url": sourceURL,
          "dataSrc": "arrays",
      },
      "columns": [
            {"data":"nombre_pais"},
            {"data":"nombre_empresa"},
            {"data":"nombre_pauta"},
            {"data":"nombre_cartera"},
            {"data":"tipo_cartera"},
      ],
    // "columnDefs": [ 
    // {
    //   "targets": 0,
    //   "data": "description",
    //   "render": function ( data, type, full, meta ) {
    //     return '<input type="checkbox" name="" class="cls-chk-'+inp_tabla+'" data-id="'+full.ID_Transf+'" data-estado="'+full.Estado_ID+'">'
    //   }
    // },
    // ],

        "oLanguage": {
          "sLengthMenu": "Mostrando _MENU_ registros por página",
          "sZeroRecords": "Sin registros",
          "sInfoEmpty": "Mostrando 0 al 0 de 0 Registros",
          "sInfoFiltered": "(filtrando de _MAX_ total registros)",
          "sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
          "sSearch": "" ,
          "sSearchPlaceholder": "Buscar...",
                "sLoadingRecords": "Cargando...<i class='fa fa-spinner fa-spin'></i>",
                "oPaginate": {
                    "sFirst":   "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious":"Anterior"
                },  
        } ,     
    } );


  return false;    
});
</script>

<!--mostrar tabla de Evaluadores-->
<script type="text/javascript">
$(document).on('click','#evatbl',function(e) {
    //alert('SI ENTRO');
    $("#divtblhome").css('display', 'none');
    $("#divtblhomeag").css('display', 'block');
    $("#divtblhomecar").css('display', 'none');
    $("#divtblhomeaud").css('display', 'none');
    $("#divtblhomeag").show();
    e.preventDefault();
    var inp_tabla    = "eval_home";
    var url          = "{{route('evaluadorestbl')}}";
    $("#tbl_"+inp_tabla+"_processing.dataTables_processing").show();
    $("#tbody-"+inp_tabla+"").empty();



    var id_tabla      = "tbl_"+inp_tabla;
    var sourceURL =url; 
    var dataTable;
    var oSettings;  
       
     dataTable= $('#'+id_tabla+'').DataTable( {
      destroy: true,
      dom: "<'row'<'col-lg-4'l><'col-lg-4'B><'col-lg-4'f>>rtip",
      "processing": true,
      "paging": true,
      "searching": true,
      "info": true,
       scrollY: '30vh', 
       select: 'single',

      "ajax": {  
          "url": sourceURL,
          "dataSrc": "arrays",
      },
      "columns": [
            {"data":"nombre_cartera"},
            {"data":"nombre_agente"},
           
      ],
    // "columnDefs": [ 
    // {
    //   "targets": 0,
    //   "data": "description",
    //   "render": function ( data, type, full, meta ) {
    //     return '<input type="checkbox" name="" class="cls-chk-'+inp_tabla+'" data-id="'+full.ID_Transf+'" data-estado="'+full.Estado_ID+'">'
    //   }
    // },
    // ],

        "oLanguage": {
          "sLengthMenu": "Mostrando _MENU_ registros por página",
          "sZeroRecords": "Sin registros",
          "sInfoEmpty": "Mostrando 0 al 0 de 0 Registros",
          "sInfoFiltered": "(filtrando de _MAX_ total registros)",
          "sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
          "sSearch": "" ,
          "sSearchPlaceholder": "Buscar...",
                "sLoadingRecords": "Cargando...<i class='fa fa-spinner fa-spin'></i>",
                "oPaginate": {
                    "sFirst":   "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious":"Anterior"
                },  
        } ,     
    } );


  return false;    
});
</script>

<script type="text/javascript">
$(document).on('click','#audtbl',function(e) {
    //alert('SI ENTRO');
    $("#divtblhome").css('display', 'none');
    $("#divtblhomeag").css('display', 'none');
    $("#divtblhomecar").css('display', 'none');
    $("#divtblhomeaud").css('display', 'block');
    $("#divtblhomeaud").show();
    e.preventDefault();
    var inp_tabla    = "aud_home";
    var url          = "{{route('audiostbl')}}";
    $("#tbl_"+inp_tabla+"_processing.dataTables_processing").show();
    $("#tbody-"+inp_tabla+"").empty();



    var id_tabla      = "tbl_"+inp_tabla;
    var sourceURL =url; 
    var dataTable;
    var oSettings;  
       
     dataTable= $('#'+id_tabla+'').DataTable( {
      destroy: true,
      dom: "<'row'<'col-lg-4'l><'col-lg-4'B><'col-lg-4'f>>rtip",
      "processing": true,
      "paging": true,
      "searching": true,
      "info": true,
       scrollY: '30vh', 
       select: 'single',

      "ajax": {  
          "url": sourceURL,
          "dataSrc": "arrays",
      },
      "columns": [
            {"data":"nombre_pauta"},
            {"data":"descripcion"},
            {"data":"vigen_pauta"},
           
      ],
    // "columnDefs": [ 
    // {
    //   "targets": 0,
    //   "data": "description",
    //   "render": function ( data, type, full, meta ) {
    //     return '<input type="checkbox" name="" class="cls-chk-'+inp_tabla+'" data-id="'+full.ID_Transf+'" data-estado="'+full.Estado_ID+'">'
    //   }
    // },
    // ],

        "oLanguage": {
          "sLengthMenu": "Mostrando _MENU_ registros por página",
          "sZeroRecords": "Sin registros",
          "sInfoEmpty": "Mostrando 0 al 0 de 0 Registros",
          "sInfoFiltered": "(filtrando de _MAX_ total registros)",
          "sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
          "sSearch": "" ,
          "sSearchPlaceholder": "Buscar...",
                "sLoadingRecords": "Cargando...<i class='fa fa-spinner fa-spin'></i>",
                "oPaginate": {
                    "sFirst":   "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious":"Anterior"
                },  
        } ,     
    } );


  return false;    
});
</script>


@endsection

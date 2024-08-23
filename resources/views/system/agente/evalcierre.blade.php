@extends('layouts.app')
@include('layouts.menu')   
@section('content')
@include('layouts.barrasup')
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-info">
              <div class="card-header">
                <div class="form-group">
                  <h3 class="card-title col-md-2">Cierre de Evaluación</h3>
                </div>
              </div>
              <div class="col-md-12" id='msj_tblcierre'>
              </div>
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Cartera</label>
                      <select class="form-control" id="cierre_cartera">
                        @if(isset($cmbasignaciones))
                          <option value="0" data-codigo="0">Seleccione...</option>
                          @foreach ($cmbasignaciones as $value)  
                            <option value="{{$value->cartera_id}}">{{$value->nombre_cartera}}</option>
                          @endforeach  
                        @endif                     
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Agente</label>
                      <select class="form-control" name="cierre_agente" id="cierre_agente">
                          <option value="">Seleccione...</option>                   
                      </select>
                    </div>
                  </div>                  
                </div> 
              </div> 
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Audios Evaluados del periodo</h3>
                <button type="button" class="btn btn-block btn-success pull-right" id="nameage">Cerrar Evaluacion para</button>
              </div>
              <div class="col-md-12" id='divtblcierre' style="display:block;">
              </div>  
              <div class="card-body">
                <table class="table table-striped table-bordered table-condensed" id='tbl_cierre_eval'>
                  <thead>
                    <tr>
                      <th>Evaluado</th>
                      <th>Rut Cliente</th>
                      <th>Envío</th>
                      <th>Fehca Evaluación</th>
                      <th>Nota</th>
                      <th>Observación</th>
                      <th>Nombre Audio</th>
                      <th>Duracion</th>
                      <th>Pauta</th>
                    </tr>
                  </thead>
                  <tbody id='tbody-cierre_eval'>
                  </tbody>
                </table>
              </div>
            </div>
          </div>        
        </div>      
        <!-- /////////////////// MODAL FINALIZA ETAPA DE EVALUACION ////////////////// -->
        <div class="modal fade" id="modal-cierraeval" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Cierra Proceso de Evaluación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal();">
                <span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <p>¡¡¡ ATENCION !!!  Se realizara el Cierre de la evaluación, este proceso es difinitivo. ¿ Desea continuar ?
                    </p> 
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="obscierre">Ingrese Observación:</label>
                      <textarea class="form-control" rows="3" id="obscierre" placeholder="Observacion..."></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <label for="fecha_cierre">Fecha de Cierre:</label> 
                    <input type="text" class="form-control fecha" id="fecha_cierre" disabled>
                  </div>
                </div>
              </div>
              <div class="modal-footer" >
                <button type="button" class="btn btn-danger pull-left" onclick="cerrar_modal();" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="ejecuta_cierre();" class="btn btn-success">Continuar</button>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" id="contnoevaluados">
        <input type="hidden" id="contsi">  
      </section>
      <!-- /.content -->    
    </div> 
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar --> 
  </div>  
</body>
@include('layouts.footer')
@include('layouts.script')
<script type="text/javascript">
  $(function(){
    $('#nameage').attr('disabled', true);
    $("#fecha_cierre").datepicker({
      dateFormat: 'dd/mm/yy',
      firstDay: 1
    }).datepicker("setDate", new Date());
  }); 
</script>
<!-- COMBO DE CARTERA -->
<script type="text/javascript">
  $('#cierre_cartera').on('change', function(){
    var cartera = $('#cierre_cartera').val();
    $('#cierre_agente').val(0);
    if(cartera!=0){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('ajaxagente') }}",
        type: 'POST',
        data:{cartera:cartera},
        dataType: 'JSON',
        xhrFields: {withCredentials: true},
        success: function (data) {
          //console.log(data.cmbcarteras);
          $("#cierre_agente").html('');   
            var _html = '';
                _html += '<option value="0">Seleccione...</option>' ;
                data.cmbcarteras.forEach(e=>{
                  _html += '<option value="'+e.agente_id+'">'+e.nombre_agente+'</option>' ;
                })
                $("#cierre_agente").html(_html);    
        },
        error: function(xhr,status,jqXHR){
          $("#cierre_agente").html('error')
        }
      });
    }else{
      $("#cierre_agente").html('<option value="0">Seleccione...</option>');
    } 
  });
</script>
<!-- COMBO DE AGENTE -->
<script type="text/javascript">
  $('#cierre_agente').on('change', function(e){
    var idagente = $('#cierre_agente').val();
    var idagentetext = $('select[name="cierre_agente"] option:selected').text();

    if(idagente!=0){
      $('#nameage').html('Cerrar Evaluacion para '+idagentetext);
      e.preventDefault();
      var inp_tabla    = "cierre_eval";
      var contsi       = 0;
      var url          = "{{route('ajaxtraeval')}}";
      $("#tbl_"+inp_tabla+"_processing.dataTables_processing").show();
      $("#tbody-"+inp_tabla+"").empty();
      var id_tabla     = "tbl_"+inp_tabla;
      var sourceURL =url+"?idagente="+idagente;  
      var dataTable;
      var oSettings;  
      $("#contnoevaluados").val('S'); 
      
      const table= $('#'+id_tabla+'').DataTable( { 
        destroy: true,
        dom: "<'row'<'col-lg-4'l><'col-lg-4'B><'col-lg-4'f>>rtip",

        "processing": true,
        "paging": true,
        "searching": true,
        "info": true,
        "fixedHeader":    true,
        scrollY: '40vh',
        select: 'single',

        "ajax": {  
          "url": sourceURL,
          "dataSrc": "array",
        },
        "columns": [
            {"width": "10%","data":"grabacion_id"},
            {"width": "50%","data":"rut_cliente"},
            {"width": "10%","data":"num_envio"},
            {"width": "10%","data":"fecha_evaluacion"},
            {"width": "10%","data":"nota"},
            {"width": "10%","data":"obs"},
            {"width": "10%","data":"nombre_graba"},
            {"width": "10%","data":"tiempo"},
            {"width": "10%","data":"nombre_pauta"},

        ],
        "columnDefs": [ 
        {
          "targets": 0,
          "data": "description",
          "render": function ( data, type, full, meta ) {
            if(full.st_evalua == 1){
              $("#contsi").val(1);
              return '<td><button type="button" class="btn btn-block btn-success btn-sm evasi">SI</button></td>';
            }else{
              $("#contnoevaluados").val("N");
              return '<td><button type="button" class="btn btn-block btn-warning btn-sm evano">NO</button></td>';
            }
          }  
        },
        ],
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
      });
      $('#nameage').attr('disabled', false);
    }else{
      $('#nameage').html('');
      $("#msj_tblcierre").html('No existe dato momentaneamente');
    } 
  });  
</script>
<!-- COMBO DE AUDIO -->


<script type="text/javascript"> 

function cerrar_modal(){
  $("#modal-grabafinal").css('display', 'none');
  $("#modal-grabafinal").modal("hide");
}

$('#nameage').on('click', function(){
  var cont   = $("#contnoevaluados").val();
  var contsi = $('#contsi').val();
  console.log(contsi);
  if(cont !='N' && contsi>0 ){
    $("#modal-cierraeval").modal('show');
  }else{
    alert('No se puede realizar un cierre, no existe periodo a cerrar o Aun existen audios a evaluar.');
  }
  
});

$('#ver_eva_completo').on('click', function(){
   alert('Entro a ver la evaluacion');
});

function ejecuta_cierre(){
  var idagente  = $('#cierre_agente').val();
  var fecha     = $('#fecha_cierre').val();
  var obscierre = $('#obscierre').val();
  obscierre
  //console.log(fecha);
  if(idagente!=0){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('ejecutacierre') }}",
        type: 'POST',
        data:{idagente:idagente,fecha:fecha,obscierre:obscierre},
        dataType: 'JSON',
        xhrFields: {withCredentials: true},
        success: function (data) {
          //console.log(data);
          cerrar_modal()
          $("#msj_tblcierre").html('');
          $('#nameage').attr('disabled', true);  
          $("#cierre_agente").trigger('change');  
          if(data.resp =='S'){
              $('#contsi').val(0);
              $('#nameage').attr('disabled', true);
              $("#msj_tblcierre").html('<div class="alert alert-success alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"><i class="fa fa-fw fa-check-circle"></i> <span>Se ha cerrado el periodo correctamente</span></div>');
          }else{
            $("#msj_tblcierre").html('<div class="alert alert-danger alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"><i class="fa fa-fw fa-check-circle"></i> <span>Ha ocurrido un error en el cerrado de periodo.</span></div>');
          } 
              
        },
        error: function(xhr,status,jqXHR){
          $("#msj_tblcierre").html('error')
        }
      });
    }else{
      $("#msj_tblcierre").html('No existe agente');
    } 
};

function cerrar_modal(){
  $("#modal-cierraeval").css('display', 'none');
  $("#modal-cierraeval").modal("hide");
}


</script>
@endsection

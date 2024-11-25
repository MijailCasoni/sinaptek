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
            <div class="card card-info" style="padding-left: 0px;padding-right: 0px;">
              <div class="card-header" style="padding-bottom: 0px;">
                <div class="form-group">
                  <h3 class="card-title col-md-4">Informe de Evaluación</h3>
                  <h3 class="card-title col-md-2" id="tit_informe"></h3>
                </div>
              </div>
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                  <!--Input cartera-->
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="info_cartera">Cartera</label>
                      <select class="form-control" id="info_cartera">
                        @if(isset($cmbasignaciones))
                          <option value="0" data-codigo="0">Seleccione...</option> 
                          @foreach ($cmbasignaciones as $value)  
                            <option value="{{$value->cartera_id}}">{{$value->nombre_cartera}}</option>
                          @endforeach  
                        @endif                     
                      </select>
                    </div>
                  </div>
                  <!--input Agente-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for ="info_agente">Agente</label> 
                      <select class="form-control" id="info_agente" name = "info_agente">
                        <option value="0" data-codigo="0">Seleccione...</option>                   
                      </select>
                    </div>
                  </div>
                  <!--input Agente-->
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for ="info_entrega">Entrega</label> 
                      <select class="form-control" id="info_entrega" name = "info_entrega">
                        <option value="0" data-codigo="0">Seleccione...</option>                   
                      </select>
                    </div>
                  </div>
                  <!--MES-->
                  <div class="col-md-2">
                    <label for="mes_ini">Mes</label> 
                    <select class="form-control" id="cmb_mes"> 
                      <?php 
                        $allMonths=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                        $now = new DateTime();
                        $thisMonth=$now->format('n');
                        $Month=12;
                        $rangeMonths = array_slice($allMonths, 0, $Month);                      
                        foreach ($rangeMonths as $k=>$month){
                          $v=$k+1;
                          if($v == $thisMonth){
                            echo '<option value="'.$v.'" selected>'.$month.'</option>';
                          }else{
                            echo '<option value="'.$v.'">'.$month.'</option>';
                          }
                        }
                      ?>
                    </select>
                  </div>
                  <!--YEAR-->
                  <div class="col-md-1">
                    <label for="year_ini">Año</label>
                    <select class="form-control" id="cmb_year">
                      <?php 
                        $date = (new DateTime)->format("Y");
                        $year = date("Y");
                        for ($i=2022; $i<=$year; $i++){
                          if($year == $date){
                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                          }else{
                            echo '<option value="'.$i.'">'.$i.'</option>';
                          }
                          
                        }
                      ?>
                    </select>
                  </div>
                  <!--Botón search-->
                  <div class="col-md-2" style="padding-top:  32px;">
                    <button type="button" class=" btn btn-primary " id="button_buscar"> Buscar </button>
                  </div>
                </div>
              </div>
            </div>      
            <div class="card card-info">
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                  <div id="ver"></div> 
                </div>
              </div>    
            </div>
        </div>       
      </section>
      <!-- /.content -->
    </div>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>     
    <!-- /.control-sidebar -->
  </div>
  @include('layouts.footer')  
</body>
@include('layouts.script')
<script type="text/javascript">
$("#button_buscar").on("click", function(e){

  var cart_info  = $("#info_cartera").val();
  var agent_info = $("#info_agente").val();
  var info_entrega = $("#info_entrega").val();
  var agent_nom  = $('select[id="info_agente"] option:selected').text();
  var cmb_mes    = $("#cmb_mes").val();
  var cmb_year   = $("#cmb_year").val();
  var sumAccion  = 0;
  var cont       = 0;
  var error      = 0;
  var _html      = '';

  $('#nomageeval').html('<b>  '+agent_nom+'</b>');
  
  if (cart_info == " " || cart_info == 0 ){
      error = 1;
  }else if (agent_info == " " || agent_info == 0 ){
      error = 1;
  }else if (info_entrega == " " || info_entrega == 0 ){
      error = 1;
  }else if (cmb_mes == " " || cmb_mes == 0 ){
      error = 1;
  }else if (cmb_year == " " || cmb_year == 0 ){
      error = 1;
  }

  if (error == 0){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('ajaxbuscarinforme') }}",
        type: 'POST',
        data:{cart_info:cart_info,
              agent_info:agent_info,
              info_entrega:info_entrega,
              cmb_mes:cmb_mes,
              cmb_year:cmb_year,
                },
        dataType: 'JSON',
        xhrFields: {withCredentials: true}, 
        beforeSend: function () {
              $("#ver").html('<div class="alert alert-warning" role="alert" style="padding-top: 20px;">Procesando...<i class="fa fa-spinner fa-lg fa-spin" aria-hidden="true"></i></div>');
        },
        success: function (data) {
          //console.log(data);   
          if(data.resp == 'N'){
            $('#ver').html('<div class="alert alert-warning" role="alert" style="padding-top: 20px;"><strong>No hay registros para la busqueda realizada, utilice otros parametros de busqueda.</strong></div>');
          }else{
            var filas        = data.arraybody.length;
            var itemrut      = '';
            var rut          = [];
            var nota         = [];
            var contac3      = [];
            var notafinalaux = 0;
            var notafinal    = 0;
            var sw           = 0;
            var texto        = '';

            //console.log(data.informes);//audios de la tabla grabacion
            //console.log(data.informes2);//trae datos de la tbl evalua grab
            //console.log(data.arraybody);
            //console.log(data.arraynota);

            data.informes.forEach(contac=>{
              contac3.push(contac.contac3);
            });
            data.arraybody.forEach(h=>{
              var sumAccion = 0;
              h.forEach(item => {  
                sumAccion = sumAccion + item.nota_accion;
                if(itemrut != item.rut_cliente){
                  rut.push(item.rut_cliente);
                }
                itemrut = item.rut_cliente;
              });
              nota.push(sumAccion); 
            });
            //console.log(rut+' - '+ nota+' - '+ contac3+')
            _html += `<table class="table display" id='tbl_informe' style="padding-bottom: 10px;">          
                          <thead>
                            <tr>
                              <td style ="background-color: #3e93ad;color:white">
                              </td>
                              <td style ="background-color: #3e93ad;color:white">
                              </td>
                              <td style ="background-color: #3e93ad;color:white">Evaluado: ${agent_nom}</td>
                              <td style ="background-color: #3e93ad;color:white">Fecha de evaluación:</td>`;   
                              for (var i = 0; i <= filas - 1; i++) {
                                _html += `<td style ="background-color: #3e93ad;color:white;text-align: center;">RUT: <div><b>${rut[i]}<b></div></td>`;
                              }                        
                  _html += `</tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th width="12%" style="text-align: center;">% Habilidad</th>
                              <th width="10%" style="text-align: center;">% Nivel</th>
                              <th width="20%">Atributos</th>
                              <th width="35%">Acciones</th>`;
                              for (var i = 0; i <= filas - 1; i++) {
                                _html += `<th style="text-align: center;">Nota</th>`;
                              }
                  _html += `</tr>`; 
                            data.informes2.forEach(e => {  
                              _html += `<tr>
                                          <td style="text-align: center;">${e.Ponderacion_Item}</td>
                                          <td style="text-align: center;">${e.ponderacion}</td>
                                          <td>${e.nombre_atributo}</td>
                                          <td>${e.nombre_accion}</td>`;
                                          data.arraybody.forEach(e => {  
                                            _html += `<td style="text-align: center;">${e[sw].nota_accion}</td>`;  
                                          });
                               _html += `</tr>`;
                                          
                              sw++;
                            });
                      
                  _html += `<tr style ="background-color: #3e93ad;color:white">
                              <td style ="background-color: #3e93ad;color:white"></td>
                              <td style ="background-color: #3e93ad;color:white"></td>
                              <td style ="background-color: #3e93ad;color:white"></td>
                              <td style ="background-color: #3e93ad;color:white"><b>NOTA PARCIAL</b></td>`;
                              for (var i = 0; i <= filas - 1; i++) {
                                _html += `<td style ="background-color: #3e93ad;color:white;text-align: center;"><b>${nota[i]}</b></td>`;
                                 notafinalaux  = (notafinalaux + nota[i]);
                              }   
                              notafinal = Math.round(notafinalaux/data.arraybody.length);
                  _html += `</tr>
                            <td style ="background-color: #043c70;color:white"></td>
                            <td style ="background-color: #043c70;color:white"></td>
                            <td style ="background-color: #043c70;color:white"></td>`;
                  _html += `<td style ="background-color: #043c70;color:white"><b>NOTA FINAL ${notafinal} `; 
                              if(notafinal < 74){
                                texto = 'MUY MALO';
                              }else if(notafinal > 74 && notafinal < 85){
                                texto = 'MALO';
                              }else if(notafinal > 84 && notafinal < 95){
                                texto = 'BUENO';
                              }else if(notafinal > 94 && notafinal < 99){
                                texto = 'MUY BUENO';
                              }else if(notafinal = 100){
                                texto = 'EXCELENTE';
                              }
                  _html += `${texto}</b></td>`;                      
                              for (var i = 0; i <= data.arraybody.length - 1; i++) {
                                _html += `<td style ="background-color: #043c70;color:white"></td>`;
                              }
                   
                _html += `</tbody>
                      </table>`;   

                      _html += `<div class="col-md-6">
                                  <div class="card card-info" style="padding-left: 0px;padding-right: 0px;">
                                    <table class="table" id='tbl_informe_eva' style="padding-bottom: 10px;">          
                                      <thead style ="background-color:black;color:white">
                                        <td colspan="3" scope="colgroup" style ="background-color:black;color:white">TABLA DE EVALUACION</td>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td>0%</td>
                                          <td>74%</td>
                                          <td>MUY MALO</td>
                                        </tr>
                                        <tr>
                                          <td>75%</td>
                                          <td>84%</td>
                                          <td>MALO</td>
                                        </tr>
                                        <tr>
                                          <td>85%</td>
                                          <td>94%</td>
                                          <td>BUENO</td>
                                        </tr>
                                        <tr>
                                          <td>95%</td>
                                          <td>99%</td>
                                          <td>MUY BUENO</td>
                                        </tr>
                                        <tr>
                                          <td>=</td>
                                          <td>100%</td>
                                          <td>EXCELENTE</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>  
                                </div>`;      
                  $('#ver').html(_html);
                  cargadatatable();
          }  
        }  
      });
  }else{
     alert("Debe llenar todos los datos" + error);
  }
});

function cargadatatable(){
  // $('#tbl_informe_eva').css("display", "block");
  $('#tbl_informe').DataTable({      
    "bPaginate": false,
    "bInfo": false,
    "paging": false,
    "ordering": false,
    "searching": false,
      dom: 'Bfrtip',
      buttons: [{
             extend:'excelHtml5',
             // extend:'pdfHtml5',
            title: "Evaluación de Pauta"
        },{
             //extend:'excelHtml5',
            extend:'pdfHtml5',
            title: "Evaluación de Pauta"
        }]
  });         
}
</script>
<!-- COMBO DE CARTERA -->
<script type="text/javascript">
$('#info_cartera').on('change', function(){
    var cartera = $('#info_cartera').val();
  
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
          $("#info_agente").html('');   
            var _html = '';
                _html += '<option value="0">Seleccione...</option>' ;
                data.cmbcarteras.forEach(e=>{
                  _html += '<option value="'+e.agente_id+'">'+e.nombre_agente+'</option>' ;
                })
                $("#info_agente").html(_html);    
        },
        error: function(xhr,status,jqXHR){
          $("#info_agente").html('error')
        }
      });
    }else{
      $("#info_agente").html('<option value="0">Seleccione...</option>');
    } 
});
$('#info_agente').on('change', function(){
    var info_agente = $('#info_agente').val();
  
    if(info_agente!=0){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('ajaxinfcartera') }}",
        type: 'POST',
        data:{info_agente:info_agente},
        dataType: 'JSON',
        xhrFields: {withCredentials: true}, 
        success: function (data) {
        //console.log(data.cmbcarteras);
          $("#info_entrega").html('');   
            var _html = '';
                _html += '<option value="0">Seleccione...</option>' ;
                data.cmbentrega.forEach(e=>{
                  _html += '<option value="'+e.num_envio+'">'+e.num_envio+'</option>' ;
                })
                $("#info_entrega").html(_html);    
        },
        error: function(xhr,status,jqXHR){
          $("#info_entrega").html('error')
        }
      });
    }else{
      $("#info_entrega").html('<option value="0">Seleccione...</option>');
    } 
});



</script> 
@endsection
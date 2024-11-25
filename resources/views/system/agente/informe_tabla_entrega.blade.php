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
                  <h3 class="card-title col-md-4">Informe de Promedio</h3>
                  <h3 class="card-title col-md-2" id="tit_informe"></h3>
                </div>
              </div>
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                  <!--Input cartera-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="info_cartera_entr">Cartera</label>
                      <select class="form-control" id="info_cartera_entr">
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
                  <!-- <div class="col-md-3">
                    <div class="form-group">
                      <label for ="info_agente">Agente</label> 
                      <select class="form-control" id="info_agente" name = "info_agente">
                        <option value="0" data-codigo="0">Seleccione...</option>                   
                      </select>
                    </div>
                  </div> -->
                  <!--MES-->
                  <div class="col-md-2">
                    <label for="mes_ini">Mes</label> 
                    <select class="form-control" id="cmb_mes_ent"> 
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
                  <div class="col-md-2">
                    <label for="year_ini">Año</label>
                    <select class="form-control" id="cmb_year_ent">
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
                    <button type="button" class=" btn btn-primary " id="button_buscar_inf_ent"> Buscar </button>
                  </div>
                </div>
              </div>
            </div>      
            <div class ="col-md-12" id="info-ente-men"></div>
            <div class="card card-info">
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                  <div id="verent"></div> 
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
$("#button_buscar_inf_ent").on("click", function(e){
  var carteraent   = $('#info_cartera_entr').val();
  var cmb_mes_ent  = $('#cmb_mes_ent').val();
  var cmb_year_ent = $('#cmb_year_ent').val();
  if(carteraent == 0 || cmb_mes_ent == 0 || cmb_year_ent == 0){
    $('#info-ente-men').html('<div class="alert alert-warning" role="alert" style="padding-top: 20px;"><strong>Debe llenar todos los campos.</strong></div>');
  }else{
      $('#info-ente-men').html('');
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('ajaxinformeentr') }}",
        type: 'POST',
        data:{carteraent:carteraent,cmb_mes_ent:cmb_mes_ent,cmb_year_ent:cmb_year_ent},
         dataType: 'JSON',
         xhrFields: {withCredentials: true}, 
         beforeSend: function () {
               $("#verent").html('<div class="alert alert-warning" role="alert" style="padding-top: 20px;">Procesando...<i class="fa fa-spinner fa-lg fa-spin" aria-hidden="true"></i></div>');
         },
         success: function (data) { 
         $("#info-ente-gral").html(''); 
          if(data.resp == 'N'){
            $('#ver').html('<div class="alert alert-warning" role="alert" style="padding-top: 20px;"><strong>No hay registros para la busqueda realizada, utilice otros parametros de busqueda.</strong></div>');
          }else{
            var filas        = data.array.length;
            var agent        = [];
            var notas        = [];
            var idnot        = 0;
            var countnota    = 1;
            var contador     = 0;
            var num          = 0;
            var _html        = '';
            var nom_h        = '';
            var nom_aux      = '';
            var cabecera     = 0;  
            var sw = 0;    

            data.array.forEach(item=>{
              //nom_h = item.nombre_agente
              if(cabecera > item.entrega){
                cabecera = cabecera;
              }else{
                cabecera = item.entrega;
              }            
            });
            //console.log(data.array);
            data.array.forEach(ver1=>{
              if(nom_h  != ver1.nombre_agente){
                 nom_h  = ver1.nombre_agente;
                 var obx    = new Object();
                 obx.nombre = ver1.nombre_agente;
                 agent.push(obx);
              }              
            });    

            _html += `<table class="table display" id='tbl_informe_entrega' style="padding-bottom: 10px;">          
                          <thead>
                            <tr>
                              <td style ="background-color: #3e93ad;color:white;text-align: center;">Ejecutivo</td>`;   
                                for (var i = 1; i <= cabecera; i++) {
                                  _html += '<td style ="background-color: #3e93ad;color:white;text-align: center">Eval '+i+'</td>';
                                } 
                            _html += `<td style ="background-color: #3e93ad;color:white;text-align: center;">Promedio</td>`;  
                  _html += `</tr>
                          </thead>
                          <tbody>`; 
                          //console.log(notas);                        
                          data.array.forEach(h=>{                                                  
                            var divprom    = 0;
                            var contador   = 1; 
                            var prom       = 0; 
                            
                            if(nom_aux  != h.nombre_agente){
                               nom_aux  = h.nombre_agente;
                                _html += `<tr>`;
                                _html += `<td style="text-align: center;">${h.nombre_agente}</td>`;
                                data.array.forEach(nota=>{ 
                                  if(nom_aux  == nota.nombre_agente){  
                                    if(nota.nota_promedio == 0){
                                      _html += `<td style="text-align: center;"></td>`;
                                    }else{
                                      _html += `<td style="text-align: center;">${nota.nota_promedio}</td>`;
                                      prom = prom + nota.nota_promedio;
                                      divprom++;
                                    }
                                    contador++; 
                                  } 
                                  
                                }); 
                                //console.log(divprom);
                                
                                while (contador <= cabecera) {
                                  _html += `<td style="text-align: center;"></td>`;
                                  contador++;
                                }
                                var promfinal = prom / divprom;
                                _html += `<td style="text-align: center;"><b>${getOneDecimal(promfinal)}</b></td>`;  
                                _html += `</tr>`; 
                            }
                        });                                  
                _html += `</tbody>
                      </table>`;   
      
                  $('#verent').html(_html);
                  cargadatatable();
          }  
         },
      }); 
  }
 
          
});

function getOneDecimal(num) {
  return Math.floor(num * 10) / 10;
}

function cargadatatable(){
  //$('#tbl_informe_entrega').css("display", "block");
  $('#tbl_informe_entrega').DataTable({      
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
@endsection
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
                  <h3 class="card-title">Evalua Audios</h3>
                  <h3 class="card-title col-md-4" id="tit_audio"></h3>
                  <h3 class="card-title col-md-3" id="tit_emp_audio"></h3>
                  <h3 class="card-title col-md-3" id="tit_pauta_audio"></h3>
                </div>  
              </div>
              <div class="col-md-12" style="margin-top: 4px; margin-bottom: 4px;" id="mensajebodyeval"></div>
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sl_cartera_audio">Cartera</label>
                      <select class="form-control" name="sl_cartera_audio" id="sl_cartera_audio">
                        @if(isset($cmbasignaciones))
                          <option value="0" data-codigo="0">Seleccione...</option>
                          @foreach ($cmbasignaciones as $value)  
                            <option value="{{$value->cartera_id}}">{{$value->nombre_cartera}}</option>
                          @endforeach  
                        @endif                     
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sl_agente_audio">Agente</label>
                      <select class="form-control" id="sl_agente_audio">
                        <option value="0" data-codigo="0">Seleccione...</option>                   
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label  for="sl_audio_general">Audio</label>
                      <select class="form-control" id="sl_audio_general">
                        <option value="0" data-codigo="0">Seleccione...</option>                 
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer" style="padding-right: 0px;padding-bottom: 1px;padding-top: 1px;padding-left: 0px;">
                <div class="info-box mb-3 bg-navy form-group" id="divescuchaaudio" style="min-height: 50px;display: none; margin-bottom: 0px !important;">
                  <div class="col-md-12" style="margin-top: 4px; margin-bottom: 4px;" id="mensajeDesplaza">
                  </div>
                </div>
              </div>
            </div>    
          </div>
        </div>    
        <div class="row" id="evaluacioncard" style="display: none;padding-left:15px;padding-right:15px;">              
          <div class="card card-secondary" style="padding-left: 0px;padding-right: 0px; margin-bottom: 0px;">
            <div class="card-header">            
              <div class="col-md-12">
                <div class="row mb-4">
                  <div class="col" id="nombreaudio" style="margin-right: 5px;"></div>
                  <div class="col-md-1" style="padding-right: 0; width: 65px;">NOTA:</div>
                  <div class="col-md-1" id="notaaudio" style="width: auto;"></div>
                  <div class="col-md-0" id="" style="width:3px"></div>
                  <div class="col-md-2" style="background-color: #cd8532; width: 150px;">
                    <div class="form-check custom-switch-off-danger custom-switch-on-success">
                      <input class="form-check-input"  id="erroraudio" type="checkbox" value="2">
                      <b><label class="form-check-label" for="erroraudio" style="color:white;">Error audio</label></b>
                    </div>
                  </div>
                  <div class="col-md-1" id="" style="width: 5px;"></div>
                  <div class="col-md-2" style="background-color: darkblue;">
                    <div class="form-check custom-switch-off-danger custom-switch-on-success">
                      <input class="form-check-input"  id="checkbox3ero" type="checkbox" value="option1">
                      <b><label class="form-check-label" for="checkbox3ero" style="color:white;">Contacto 3ero</label></b>
                    </div>
                  </div>
                  <div class="col-md-2" id="divevaluado" style="background-color: darkred;">
                  </div> 
                </div>
              </div>
            </div>
            <div class="body" id="bodyall">
              <!-- PRIMERA FILA SIN CHECK -->
              <div class="card" id="togle" style="margin-bottom: 0px;">
                <div class="card-header border-transparent" style="background-color: darkgray;">
                  <h3 id='encabezadoitem1' class="card-title"></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fa fa-minus" style="padding-top: 12px;"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0" style="display: block;">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th style="text-align: center;">% Niveles</th>
                          <th>Item a evaluar</th>                              
                          <th>SI</th>
                          <th>NO</th>
                        </tr>
                      </thead>
                      <tbody id="tbody1">                
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- FIN PRIMERA FILA -->
              <!-- SEGUNDA FILA SIN CHECK -->
              <div class="card collapse-card" id="togle1" style="margin-bottom: 0px;">
                <div class="card-header border-transparent" style="background-color: darkgray;">
                  <h3 id='encabezadoitem2' class="card-title"></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fa fa-minus" style="padding-top: 12px;"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0" style="display: block;">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th style="text-align: center;">% Niveles</th>
                          <th>Item a evaluar</th>                              
                          <th>SI</th>
                          <th>NO</th>
                        </tr>
                      </thead>
                      <tbody id="tbody2">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- FIN SEGUNDA FILA -->
              <!-- SEGUNDA FILA ESPECIAL A SIN CHECK -->
              <div class="card collapse-card" id="togle2" style="margin-bottom: 0px;">
                <div class="card-header border-transparent" style="background-color: darkgray;">
                  <h3 id='encabezadoitem3' class="card-title"></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fa fa-minus" style="padding-top: 12px;"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0" style="display: block;">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th style="text-align: center;">% Niveles</th>
                          <th>Item a evaluar</th>                              
                          <th>SI</th>
                          <th>NO</th>
                        </tr>
                      </thead>
                      <tbody id="tbody3">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- FIN SEGUNDA ESPECIAL A FILA -->
              <!-- SEGUNDA FILA ESPECIAL B SIN CHECK -->
              <div class="card collapse-card togle3" id="togle3" style="margin-bottom: 0px; display: none;">
                <div class="card-header border-transparent" style="background-color: darkgray;">
                  <h3 id='encabezadoitem4' class="card-title"></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fa fa-minus" style="padding-top: 12px;"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0 contacto3ro" id="contacto3ro" style="display: block;">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th style="text-align: center;">% Niveles</th>
                          <th>Item a evaluar</th>                              
                          <th>SI</th>
                          <th>NO</th>
                        </tr>
                      </thead>
                      <tbody id="tbody4">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- FIN SEGUNDA ESPECIAL B FILA -->
              <!-- TERCERA FILA SIN CHECK -->
              <div class="card collapse-card" id="togle4">
                <div class="card-header border-transparent" style="background-color: darkgray;">
                  <h3 id='encabezadoitem5' class="card-title"></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fa fa-minus" style="padding-top: 12px;"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0" style="display: block;">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th style="text-align: center;">% Niveles</th>
                          <th>Item a evaluar</th>                              
                          <th>SI</th>
                          <th>NO</th>
                        </tr>
                      </thead>
                      <tbody id="tbody5">
                      </tbody>
                    </table>
                  </div>
                </div>
                  </div>
                  <!-- FIN TERCERA FILA -->  
                </div>
                <div class="card-footer">
                  <div class="form-group" style="margin-bottom: 0px;">
                    <button type="submit" class="btn btn-success float-right" name="btn-success" id="btn-success-items1-ff">Guardar Evaluación</button>
                  </div> 
                </div>  
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
  <!-- /////////////////// MODAL FINALIZA EVALUACION ////////////////// -->
  <div class="modal fade" id="modal-grabafinal" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Graba Evaluación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ejecuta_cerrar();">
          <span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <p>Se realizara la grabación final de la evaluación</p> 
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="observacion">Ingrese Observación:</label>
                <textarea class="form-control" rows="3" id="observacion" placeholder="Observacion..."></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <label for="fecha_evalua">Fecha de Evaluacion<label> 
              <input type="text" class="form-control fecha" id="fecha_evalua" disabled>
              <label class="fa fa-calendar text-primary" for="fecha_evalua" style="position: absolute; right:90px; top:35px;"></label>
            </div>
            <div class="col-md-4">
              <input type="checkbox" id="sendEmailCheckbox">  ADVERTENCIA¡</input>
              </select>
              <label for="emailSended">Enviar nota advertencia a:</label>
              <select id="emailSended" class="form-control">
                <option value="1">Correo de Mauricio</option>
              </select>
            
          </div>
          </div>
        </div>
        <div class="modal-footer" >
          <button type="button" class="btn btn-danger pull-left" onclick="ejecuta_cerrar();" data-dismiss="modal">Cerrar</button>
          <button type="button" onclick="ejecuta_evalua();" class="btn btn-success">Grabar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /////////////////// MODAL Error audio ////////////////// -->
  <div class="modal fade" id="modal-erroraudio" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Graba Error en audio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ejecuta_cerrar_erroraudio();">
          <span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <p>Se realizara la grabación que este audio esta con error y no se puede evaluar.</p> 
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="obserror">Ingrese Observación:</label>
                <textarea class="form-control" rows="3" id="obserror" placeholder="Observacion..."></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <label for="fecha_erroraud">Fecha de observación<label> 
              <input type="text" class="form-control fecha" id="fecha_erroraud" disabled>
              <label class="fa fa-calendar text-primary" for="fecha_erroraud" style="position: absolute; right:90px; top:35px;"></label>
            </div>
          </div>
        </div>
        <div class="modal-footer" >
          <button type="button" class="btn btn-danger pull-left" onclick="ejecuta_cerrar_erroraudio();" data-dismiss="modal">Cerrar</button>
          <button type="button" onclick="ejecuta_grabaerroraudio();" class="btn btn-success">Grabar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <input type="hidden" id="cuentabody">
  <input type="hidden" id="timeaudio">  
</body>
@include('layouts.footer')  
@include('layouts.script') 
<!-- COMBO DE CARTERA -->
<script type="text/javascript">
  $('#sl_cartera_audio').on('change', function(){
    var cartera     = $('#sl_cartera_audio').val();
    var carteratext = $('select[name="sl_cartera_audio"] option:selected').text();
    $("#tit_emp_audio").html('CARTERA: <b>'+carteratext+'</b>');
    $('#sl_agente_audio').val(0);
    $('#sl_audio_general').val(0);
    $('#divescuchaaudio').css('display','none');
    $('#evaluacioncard').css('display','none');
    //console.log(cartera);
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
          $("#sl_agente_audio").html(''); 
          var largoarr = data.cmbcarteras.length; 
          if(largoarr){
            var _html = '';
                _html += '<option value="">Seleccione...</option>' ;
                data.cmbcarteras.forEach(e=>{
                  _html += '<option value="'+e.agente_id+'">'+e.nombre_agente+'</option>' ;
                })
                $("#sl_agente_audio").html(_html);   
          }else{
            $("#sl_agente_audio").html('<option value="">Sin datos</option>');
          }      
        },
        error: function(xhr,status,jqXHR){
          $("#sl_agente_audio").html('error')
        }
      });
    }else{
      $("#sl_agente_audio").html('<option value="">Seleccione...</option>');
    } 
  });
</script>
<!-- COMBO DE AGENTE -->
<script type="text/javascript">
  $('#sl_agente_audio').on('change', function(){
    var idagente = $('#sl_agente_audio').val();
    $('#sl_audio_general').val(0);
    $('#divescuchaaudio').css('display','none');
    $('#evaluacioncard').css('display','none');
    //console.log(idagente);
    if(idagente!=0){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('ajaxaudio') }}",
        type: 'POST',
        data:{idagente:idagente},
        dataType: 'JSON',
        xhrFields: {withCredentials: true},
        success: function (data) {
          $("#sl_audio_general").html('');   
            var _html = '';
                _html += '<option value="0">Seleccione...</option>' ;
                data.cmbaudios.forEach(e=>{
                  if(e.st_evalua == 0){
                    var color = '#e1bcba';
                  }
                  if(e.st_evalua == 1){
                    var color = '#bae1ba';
                  }
                  if(e.st_evalua == 2){
                    var color = '#cd8532';
                  }
                  _html += '<option value="'+e.grabacion_id+'" id="'+e.grabacion_id+'" data-nomagen="'+e.nombre_agente+'" data-nomaudio="'+e.nombre_graba+'" data-cartera="'+e.cartera_id+'" data-path="'+e.path+'" data-st_evalua="'+e.st_evalua+'" data-pauta="'+e.pauta_id+'" data-nompauta="'+e.nombre_pauta+'" data-nota="'+e.nota+'" style="background-color:'+color+';">'+e.nombre_graba+'</option>' ;
                })
                $("#sl_audio_general").html(_html);    
        },
        error: function(xhr,status,jqXHR){
          $("#sl_audio_general").html('error')
        }
      });
    }else{
      $("#sl_audio_general").html('<option value="0">Seleccione...</option>');
    } 
  });  
</script>
<!-- COMBO DE AUDIO -->
<script type="text/javascript">
  $('#sl_audio_general').on('change', function(){
    $("tbody").html('');
    $('#tit_pauta_audio').html('');
    $('#tit_audio').html('');
    var idaudio   = $('#sl_audio_general').val();
    var nomaudio  = $("#sl_audio_general").find(':selected').data("nomaudio");
    var nomagente = $("#sl_audio_general").find(':selected').data("nomagen");
    var cartera_id= $("#sl_audio_general").find(':selected').data("cartera");
    var pauta_id  = $("#sl_audio_general").find(':selected').data("pauta");
    var nompauta  = $("#sl_audio_general").find(':selected').data("nompauta");
    var path      = $("#sl_audio_general").find(':selected').data("path");
    var st_evalua = $("#sl_audio_general").find(':selected').data("st_evalua");
    var nota      = $("#sl_audio_general").find(':selected').data("nota");
    
    if(idaudio!=0){
      $('#tit_pauta_audio').html('PAUTA: <b>'+nompauta+'</b>');
      $('#tit_audio').html('AUDIO:<b>'+nomaudio+'</b>'); 
      $('#tit_pauta_audio').html('PAUTA: <b>'+nompauta+'</b>');
      $('#tit_audio').html('AUDIO:<b>'+nomaudio+'</b>');
      $('#btn-success-items1-ff').attr("disabled", false);
      $("#divescuchaaudio").css("display", "block");
      $("#mensajeDesplaza").html("<div class='col-md-12'><audio controls loop autoplay class='col-md-4' id='audiocalcula' preload='metadata'><source src='https://sinaptek.com/sinaptek/public/audios/"+path+"/"+nomaudio+"' type='audio/mp3'></audio><MARQUEE class='col-md-8' style='padding-bottom: 16px;font:bold;'><FONT COLOR=white>Audio Seleccionado: "+nomaudio+" / Agente: "+nomagente+"</FONT></MARQUEE></div>");
      //get_grilla(idaudio, nomaudio, nomagente)
      $('#nombreaudio').html('Audio: '+nomaudio);
      $('#evaluacioncard').css('display','block');

      if(st_evalua == 1){
        $('#erroraudio').attr('checked',false);
        $('#erroraudio').attr('disabled',true);
        var estado = '<b>EVALUADO</b>';
        $('#divevaluado').html(estado).css('background-color','green'); 
        $('#notaaudio').html(nota).css('background-color','grey'); 
        $('#btn-success-items1-ff').attr('disabled',true);
        $('#checkbox3ero').attr('disabled',true);  
        $("#mensajebodyeval").html('<div class="alert alert-success alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive" style="margin-bottom: 0px;><i class="fa fa-fw fa-check-circle"></i> <span>Este audio ya ha sido evaluado con una nota de '+nota+'%, si desea cambiar esta nota, informe a su supervisor.</span></div>');
          //llama_llenado_eva(idaudio,cartera_id);
      }else{  
        $('#erroraudio').attr('disabled',false); 
        if(st_evalua == 2){
          $('#erroraudio').attr('checked',true);
        }else{
          $('#erroraudio').attr('checked',false);
        } 
        $("#mensajebodyeval").html('');
        var estado = '<b>NO EVALUADO</b>';
        $('#divevaluado').html(estado).css('background-color','red');
        $('#notaaudio').html(nota).css('background-color','grey');
        $('#btn-success-items1-ff').attr('disabled',false);
        $('#checkbox3ero').attr('disabled',false);
        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "{{ route('ajaxaudioevalua') }}",
          type: 'POST',
          data:{idaudio:idaudio,cartera_id:cartera_id},
          dataType: 'JSON',
          xhrFields: {withCredentials: true},
            success: function (data) {
            //console.log(data);   
            var cont     = 1;
            var contfila = 1;
            var contopt  = 0;
            var cont_tr  = 0;
              data.pautajson.forEach(e=>{
                var _htmlitem = '';
                if(e.posicion == cont){
                  var sumaitem = 0;
                  $("#encabezadoitem"+cont).html(e.nombre_atributo+'  (<b>Habilidad: '+sumaitem+'%</b>)');
                  data.pautajson.forEach(h=>{
                    if(h.posicion == cont){
                       sumaitem = sumaitem + h.ponderacion;
                       let datos = `data-accion="${h.accion_id}" data-atributo="${h.atributo_id}" data-audio="${idaudio}" data-pauta="${h.pauta_id}" data-cont=${contopt} data-item="${h.nombre_accion}" data-nota="${h.ponderacion}"`;
                      _htmlitem +=`<tr id="trdatos${cont_tr}" ${datos}>
                                      <td style="text-align: center;width:12%"><span class="badge badge-success">${h.ponderacion}%</span></td>
                                      <td style="width:60%">${h.nombre_accion}</td>
                                      <td><div class="custom-control custom-radio">
                                            <input class="custom-control-input rbinput" type="radio" id="customRadio${contfila}" name="radiobuton${contopt}" value="SI">
                                            <label for="customRadio${contfila}" class="custom-control-label rbinput"></label>
                                          </div>
                                      </td>`;
                                      
                                      contfila++;
                        _htmlitem +=` <td><div class="custom-control custom-radio">
                                            <input class="custom-control-input custom-control-input-danger  rbinput" type="radio" id="customRadio${contfila}" name="radiobuton${contopt}" value="NO">
                                            <label for="customRadio${contfila}" class="custom-control-label rbinput"></label>
                                          </div>
                                      </td>
                                   </tr>`;
                                   cont_tr++;
                      $("#tbody"+cont).html(_htmlitem);   
                      $("#encabezadoitem"+cont).html(e.nombre_atributo+'  (<b>Habilidad: '+sumaitem+'%</b>)');            
                      contfila++; 
                      contopt++;           
                    }           
                  });              
                  cont++;
                } 
                $('#cuentabody').val(cont);   
              });
              if(st_evalua == 1){
                $('.rbinput').attr('disabled', true);
              }
            },
            error: function(xhr,status,jqXHR){
              $("#sl_audio_general").html('error')
            }
        }); 
        let audio1 = document.getElementById("audiocalcula");
        audio1.addEventListener('loadedmetadata', function(e) {
          convertir(audio1.duration);
          function convertir(duracuion) {
            const segundos = (Math.round(duracuion % 0x3C)).toString();
            const horas    = (Math.floor(duracuion / 0xE10)).toString();
            const minutos  = (Math.floor(duracuion / 0x3C ) % 0x3C).toString();
            var time=`${horas}:${minutos}:${segundos}`;
            $('#timeaudio').val(time);
          }
        });
      } 
      fn_erroraudio();     
    }else{
      $("#divescuchaaudio").css("display", "none");
      $('#divevaluado').html('NO EXITE AUDIO');
    };   

  }); 
</script> 

<!--Contacto a terceros-->
<script type="text/javascript"> 
$('#checkbox3ero').on('change',function() {
  if($('#checkbox3ero').is(':checked')) { 
    $("#togle3").css("display", "block");
    $("#togle2").css("display", "none");
    $("#customRadio8").prop("disabled",true);
    $("#customRadio7").prop("checked",true);
    // $("#customRadio33").prop("disabled",true);
    // $("#customRadio34").prop("checked",true);
    $("#customRadio35").prop("disabled",true);
    $("#customRadio36").prop("checked",true);
    $("#trdatos3").hide();
    //$("#togle4").hide();

  }else{
    $("#togle3").css("display", "none");
    $("#togle2").css("display", "block");
    $("#customRadio8").prop("disabled",false);
    $("#customRadio7").prop("checked",false);
    // $("#customRadio33").prop("disabled",false);
    // $("#customRadio34").prop("checked",false);
     $("#customRadio35").prop("disabled",false);
    $("#customRadio36").prop("checked",false);
    $("#trdatos3").show();
    $("#togle4").show();
  }
});

function ejecuta_cerrar(){
  $("#modal-grabafinal").css('display', 'none');
  $("#modal-grabafinal").modal("hide");
}

function ejecuta_cerrar_erroraudio(){
  $("#modal-erroraudio").css('display', 'none');
  $("#modal-erroraudio").modal("hide");
}


// Esta es la sección del botón de guardar que debe mandar o a error audio o a guardar mdoficación 

$('#btn-success-items1-ff').on('click', function() {
  $("#fecha_evalua").datepicker({
    dateFormat: 'dd/mm/yy',
    firstDay: 1
  }).datepicker("setDate", new Date());
  $("#fecha_erroraud").datepicker({
    dateFormat: 'dd/mm/yy',
    firstDay: 1
  }).datepicker("setDate", new Date());
  let cuentabody = $('#cuentabody').val();
  let cont     = 1;
  let especial = 0;
  let array    = [];
  let recorre  = 0;
  let indexrec = 0;
  let error    = 1;
  let notafinal= 0;
  let item     = '';
  let selectedItemsText = "Usted debe revisar los siguientes items:\n";
  let selectedItems = $('input[type="radio"]:checked'); // Obtener todos los radio buttons seleccionados

  $('#checkbox3ero').is(':checked')?especial=1:especial=0;
  if (selectedItems.length > 0) {  // Verificar si al menos un radio button está seleccionado
    while (cuentabody > 1) {
      
        let contchek = 0;
        let filas    = $("#tbody"+cont+" tr").length;
          // alert(filas+'-'+contchek);
        while(contchek < filas){
            let datos    = new Object();
            datos.cont      = $("#trdatos"+indexrec).data('cont');
            datos.accion    = $("#trdatos"+indexrec).data('accion');
            datos.atributo  = $("#trdatos"+indexrec).data('atributo');
            datos.audio     = $("#trdatos"+indexrec).data('audio');
            datos.pauta     = $("#trdatos"+indexrec).data('pauta');
            datos.item      = $("#trdatos"+indexrec).data('item');
            datos.ponde     = $("#trdatos"+indexrec).data('nota');
            let item        = $("#trdatos"+indexrec).data('item');
            let audio       = $("#trdatos"+indexrec).data('audio');
            let pauta       = $("#trdatos"+indexrec).data('pauta');
            let datode      = $('input[name=radiobuton'+indexrec+']:checked').val();
            if(especial === 0 && cont != 4 || especial === 1 && cont != 3){
              if(datode  === undefined){
                let error = 0;
                let itemName = item; // Obtener el nombre del ítem
                selectedItemsText += "- " + itemName + "\n";
              }else{
                 datos.evaluacion= datode; 
              }
            }else if(especial === 0 && cont === 4 || especial === 1 && cont === 3){  
                datos.evaluacion='NO';
            }   
            array.push(datos);
            contchek++;
            indexrec++;
        }            
      cuentabody=cuentabody-1;
      cont++;
    };
    if(error === 0){
      alert(selectedItemsText);
    }else{
        if($('#erroraudio').is(':checked')) {
        $("#modal-erroraudio").css('display', 'block');
        $("#modal-erroraudio").modal("show");
      }else { 
        $("#modal-grabafinal").css('display', 'block');
        $("#modal-grabafinal").modal("show");
      }     
    }
    }else{
      alert("No se ha evaluado ningún ítem.");    
    }
})


function ejecuta_evalua(){ 
  var cuentabody = $('#cuentabody').val();
  var cont     = 1;
  var especial = 0;
  var array    = [];
  var recorre  = 0;
  var indexrec = 0;
  var error    = 1;
  var notafinal= 0;
  var item     = '';
  var agente   = $('#sl_agente_audio').val();
  var audio    = $('#sl_audio_general').val();
  var fecha_act= $('#fecha_evalua').val();
  var observacion= $('#observacion').val();
  var selectedItemsText = "Usted debe revisar los siguientes items:\n";
  var selectedItems = $('input[type="radio"]:checked'); // Obtener todos los radio buttons seleccionados

  $('#checkbox3ero').is(':checked')?especial=1:especial=0;
  $('#checkbox3ero').is(':checked')?st_evalua=1:especial=0;
  if (selectedItems.length > 0) {  // Verificar si al menos un radio button está seleccionado
     while (cuentabody > 1) {
      
        var contchek = 0;
        var filas    = $("#tbody"+cont+" tr").length;
          // alert(filas+'-'+contchek);
        while(contchek < filas){
            var datos    = new Object();
            datos.cont      = $("#trdatos"+indexrec).data('cont');
            datos.accion    = $("#trdatos"+indexrec).data('accion');
            datos.atributo  = $("#trdatos"+indexrec).data('atributo');
            datos.audio     = $("#trdatos"+indexrec).data('audio');
            datos.pauta     = $("#trdatos"+indexrec).data('pauta');
            datos.item      = $("#trdatos"+indexrec).data('item');
            datos.ponde     = $("#trdatos"+indexrec).data('nota');
            var item        = $("#trdatos"+indexrec).data('item');
            var audio       = $("#trdatos"+indexrec).data('audio');
            var pauta       = $("#trdatos"+indexrec).data('pauta');
            var datode      = $('input[name=radiobuton'+indexrec+']:checked').val();
            if(especial === 0 && cont != 4 || especial === 1 && cont != 3){
              if(datode  === undefined){
                var error = 0;
                var itemName = item; // Obtener el nombre del ítem
                selectedItemsText += "- " + itemName + "\n";
              }else{
                 datos.evaluacion= datode; 
              }
            }else if(especial == 0 && cont == 4 || especial == 1 && cont == 3){  
                datos.evaluacion='NO';
            }   
            array.push(datos);
            contchek++;
            indexrec++;
        }            
      cuentabody=cuentabody-1;
      cont++;
    };
    //console.log(array);
    if(error === 0){
      alert(selectedItemsText);
    }else{
        array.forEach(h=>{
          if(h.evaluacion == 'SI'){
            notafinal = notafinal+h.ponde;  
          }  
        });
        var time = $('#timeaudio').val();
        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "{{ route('ajaxaudioevaluagraba') }}",
          type: 'POST',
          dataType: 'json',
          data: {notafinal:notafinal, array:JSON.stringify(array), audio:audio, pauta:pauta, time:time, fecha_act:fecha_act, observacion:observacion, especial:especial, agente:agente},
          beforeSend: function (data){
            //console.log(array);
            ejecuta_cerrar_erroraudio();
            $('#btn-success-items1-ff').attr("disabled", true);
            $('#checkbox3ero').attr('disabled',true);
            $('#notaaudio').html(notafinal)
            $("#mensajebodyeval").html('<div role="alert" aria-busy="true" aria-live="assertive">Realizando grabado de evaluación, espere un momento... <i class="fa fa-spinner fa-lg fa-spin" aria-hidden="true"></i></div>');
          },
          success: function (data) { 
            $('#sl_agente_audio').trigger('change');
            $("#mensajebodyeval").html('<div class="alert alert-success alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"><i class="fa fa-fw fa-check-circle"></i> <span>Se ha grabado la evaluación del audio correctamente, con una nota final de '+notafinal+'</span></div>');
            //$("audio").pause();
            $('#checkbox3ero').prop('checked', false);
            ejecuta_cerrar();
            //$('#bodyall').html('');
            window.scrollTo(0, 0);
          },  
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo grabar evaluación consulte TI. ",tipo:"Error",label:"Error",id_div:"bodyall"});    
          }
        });   
    } 
  } else {
    alert("No se ha evaluado ningún ítem.");
  }
};



//<!-- crear un ajax al sql. Tbl grabación, numero 2,  campo st_evalua -->



function ejecuta_grabaerroraudio(){
  var agente   = $('#sl_agente_audio').val();
  var audio    = $('#sl_audio_general').val();
  var fecha_act= $('#fecha_erroraud').val();
  var obs      = $('#obserror').val();
  var error    = 1;

  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: "{{ route('ajaxaudiofail') }}",
    type: 'POST',
    dataType: 'json',
    data: {agente:agente, audio:audio, fecha_act:fecha_act, obs:obs},
      
      beforeSend: function (data){
            ejecuta_cerrar_erroraudio();
            // $('#btn-success-items1-ff').attr("disabled", true);
            // $('#erroraudio').attr('disabled',true);
            $("#mensajebodyeval").html('<div role=  "alert" aria-busy="true" aria-live="assertive">Realizando grabado de evaluación, espere un momento... <i class="fa fa-spinner fa-lg fa-spin" aria-hidden="true"></i></div>');
          },
          success: function (data) { 
            $('#sl_agente_audio').trigger('change');
            if(data.ejec == true){
              $("#mensajebodyeval").html('<div class="alert alert-success alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"><i class="fa fa-fw fa-check-circle"></i> <span>Su evaluación se guardará con error de audio, por favor continue con el siguiente audio</span></div>');
            }else{
              $("#mensajebodyeval").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> No se pudo grabar evaluación consulte TI. </div>');  
            }
            
            
            
          },  
          error: function (data){ 
             $("#mensajebodyeval").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> No se pudo grabar evaluación consulte TI. </div>');  
          }

      });
}
</script>


<!--Creación de vistas de tabla de forma dinámica-->
<script type="text/javascript">
  function llama_llenado_eva(idaudio,cartera_id){
     $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "{{ route('ajaxevaluatrae') }}",
          type: 'POST',
          data:{idaudio:idaudio,cartera_id:cartera_id},
          dataType: 'JSON',
          xhrFields: {withCredentials: true},
            success: function (data) {
            //console.log(data);   
            var cont     = 1;
            var contfila = 1;
            var contopt  = 0;
            var cont_tr  = 0;
              data.pautajson.forEach(e=>{
                var _htmlitem = '';
                if(e.posicion == cont){
                  var sumaitem = 0;
                  $("#encabezadoitem"+cont).html(e.nombre_atributo+'  (<b>Habilidad: '+sumaitem+'%</b>)');
                  data.pautajson.forEach(h=>{
                    if(h.posicion == cont){
                       sumaitem = sumaitem + h.ponderacion;
                       let datos = `data-accion="${h.accion_id}" data-atributo="${h.atributo_id}" data-audio="${idaudio}" data-pauta="${h.pauta_id}" data-cont=${contopt} data-item="${h.nombre_accion}" data-nota="${h.ponderacion}"`;
                      _htmlitem +=`<tr id="trdatos${cont_tr}" ${datos}>
                                      <td style="text-align: center;width:12%"><span class="badge badge-success">${h.ponderacion}%</span></td>
                                      <td style="width:60%">${h.nombre_accion}</td>
                                      <td><div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="customRadio${contfila}" name="radiobuton${contopt}" value="SI" disabled>
                                            <label for="customRadio${contfila}" class="custom-control-label"></label>
                                          </div>
                                      </td>`;
                                      
                                      contfila++;
                        _htmlitem +=` <td><div class="custom-control custom-radio">
                                            <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio${contfila}" name="radiobuton${contopt}" value="NO" disabled>
                                            <label for="customRadio${contfila}" class="custom-control-label"></label>
                                          </div>
                                      </td>
                                   </tr>`;
                                   cont_tr++;
                      $("#tbody"+cont).html(_htmlitem);   
                      $("#encabezadoitem"+cont).html(e.nombre_atributo+'  (<b>Habilidad: '+sumaitem+'%</b>)');            
                      contfila++; 
                      contopt++;           
                    }           
                  });              
                  cont++;
                } 
                $('#cuentabody').val(cont);   
              });

              //Ocultamiento de "trdatos3" por contacto a terceros
              if ($('#checkbox3ero').is('checked')){
                $("#trdatos3").hide();
              }else{
                $("#trdatos").show();
              }

            },
            error: function(xhr,status,jqXHR){
              $("#sl_audio_general").html('error')
            }
      }); 
        let audio1 = document.getElementById("audiocalcula");
        audio1.addEventListener('loadedmetadata', function(e) {
          convertir(audio1.duration);
          function convertir(duracuion) {
            const segundos = (Math.round(duracuion % 0x3C)).toString();
            const horas    = (Math.floor(duracuion / 0xE10)).toString();
            const minutos  = (Math.floor(duracuion / 0x3C ) % 0x3C).toString();
            var time=`${horas}:${minutos}:${segundos}`;
            $('#timeaudio').val(time);
          }
        });   
  }
</script>

//fail de audio

<script type="text/javascript"> 
$('#erroraudio').on('change',function() {
    fn_erroraudio();
});

function fn_erroraudio(){
  if($('#erroraudio').is(':checked')) {
    $("#customRadio1").prop("disabled",true);
    $("#customRadio2").prop("checked",true);
    $("#customRadio3").prop("disabled",true);
    $("#customRadio4").prop("checked",true);
    $("#customRadio5").prop("disabled",true);
    $("#customRadio6").prop("checked",true);
    $("#customRadio7").prop("disabled",true);
    $("#customRadio8").prop("checked",true);
    $("#customRadio9").prop("disabled",true);
    $("#customRadio10").prop("checked",true);
    $("#customRadio11").prop("disabled",true);
    $("#customRadio12").prop("checked",true);
    $("#customRadio13").prop("disabled",true);
    $("#customRadio14").prop("checked",true);
    $("#customRadio15").prop("disabled",true);
    $("#customRadio16").prop("checked",true);
    $("#customRadio17").prop("disabled",true);
    $("#customRadio18").prop("checked",true);
    $("#customRadio19").prop("disabled",true);
    $("#customRadio20").prop("checked",true);
    $("#customRadio21").prop("disabled",true);
    $("#customRadio22").prop("checked",true); 
    $("#customRadio23").prop("disabled",true);
    $("#customRadio24").prop("checked",true);
    $("#customRadio25").prop("disabled",true);
    $("#customRadio26").prop("checked",true);
    $("#customRadio27").prop("disabled",true);
    $("#customRadio28").prop("checked",true);
    $("#customRadio29").prop("disabled",true);
    $("#customRadio30").prop("checked",true);
    $("#customRadio31").prop("disabled",true);
    $("#customRadio32").prop("checked",true);
    $("#customRadio33").prop("disabled",true);
    $("#customRadio34").prop("checked",true);
    $("#customRadio35").prop("disabled",true);
    $("#customRadio36").prop("checked",true);
    //$("#trdatos3").hide();
    $("#togle").hide();
    $("#togle1").hide();
    $("#togle2").hide();
    $("#togle3").hide();
      $("#togle4").hide();
  }else{
    $("#togle3").css("display", "none");
    $("#togle2").css("display", "block");
    $("#customRadio1").prop("disabled",false);
    $("#customRadio2").prop("checked",false);
    $("#customRadio3").prop("disabled",false);
    $("#customRadio4").prop("checked",false);
    $("#customRadio5").prop("disabled",false);
    $("#customRadio6").prop("checked",false);
    $("#customRadio7").prop("disabled",false);
    $("#customRadio8").prop("checked",false);
    $("#customRadio9").prop("disabled",false);
    $("#customRadio10").prop("checked",false);
    $("#customRadio11").prop("disabled",false);
    $("#customRadio12").prop("checked",false);
    $("#customRadio13").prop("disabled",false);
    $("#customRadio14").prop("checked",false);
    $("#customRadio15").prop("disabled",false);
    $("#customRadio16").prop("checked",false);
    $("#customRadio27").prop("disabled",false);
    $("#customRadio28").prop("checked",false);
    $("#customRadio29").prop("disabled",false);
    $("#customRadio30").prop("checked",false);
    $("#customRadio31").prop("disabled",false);
    $("#customRadio32").prop("checked",false);
    $("#customRadio33").prop("disabled",false);
    $("#customRadio34").prop("checked",false);
    $("#customRadio35").prop("disabled",false);
    $("#customRadio36").prop("checked",false);
    
    $("#togle").show();
    $("#togle1").show();
    $("#togle2").show();
    $("#togle3").show();
    $("#togle4").show ();
  }
}
</script>

<script type="text/javascript">
  document.getElementById('grabarButton').addEventListener('click', function() {
    const agent = document.getElementById('sl_agente_audio').value;
    const audioName = document.getElementById('sl_audio_general').value;
    const observacion = document.getElementById('observacion').value;
    const sendMail = document.getElementById('sendEmailCheckbox').checked;
    
    fetch('/send-evaluation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ agent, audio_name: audioName, observacion })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Correo enviado exitosamente.");
        } else {
            alert("Error al enviar correo: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script> $(document).ready(function()
 { $('#checkbox3ero').change(function() {
  let especial = $(this).is(':checked') ? 1 : 0; if (especial === 1) { $('#togle3').show(); } else { $('#togle3').hide(); } }); }); 
</script>
@endsection

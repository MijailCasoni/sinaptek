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
                  <h3 class="card-title col-md-6">Asignación de Agente</h3>
                  <h3 class="card-title col-md-2" id="tit_informe"></h3>
                </div>
              </div>
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="col-md-12" id="msjcargas"></div>
                    <div class="row">
                      <!--Input Agente-->
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="sl_agente_car">Agente</label>
                          <select class="form-control" id="sl_agente_car">
                            @if(isset($cmbAgentes))
                              <option value="0" data-codigo="0">Seleccione...</option>
                              @foreach ($cmbAgentes as $value)  
                                <option value="{{$value->agente_id}}">{{$value->nombre_agente}}</option>
                              @endforeach  
                            @endif 
                          </select>
                        </div>
                      </div>
                      <!--Input Empresa-->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="sl_empresa_car">Empresa</label>
                          <select class="form-control" id="sl_empresa_car" disabled>
                            @if(isset($cmbEmpresas))
                              <option value="0" data-codigo="0">Seleccione...</option>
                              @foreach ($cmbEmpresas as $value)  
                                <option value="{{$value->empresa_id}}">{{$value->nombre_empresa}}</option>
                              @endforeach  
                            @endif                     
                          </select>
                        </div>
                      </div>
                      <!--Input Cartera-->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="sl_cartera_car_age">Cartera</label>
                          <select class="form-control" id="sl_cartera_car_age" disabled>
                            <option value="0" data-codigo="0">Seleccione...</option>
                          </select>
                        </div>
                      </div>                     
                      <div class="col-md-2">
                        <div class="form-group">
                          <button type="button" id="asignaAgente" class="btn btn-block btn-primary" style="margin-top: 34px;">Asignar</button>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <button type="button" id="creaAgente" class="btn btn-block btn-success" style="margin-top: 34px;">Crear Agente</button>
                        </div>
                      </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-8" id="msje_agent">
                          <div class="alert alert-info alert-dismissible">
                            <div class="col-md-12" id="msje_agent_agent"></div>
                          </div>
                        </div> 
                        <div class="col-md-4 pull-right" id="agent_new" style="display:none;margin-bottom: 10px;">
                          <label for="agent_new_text" style="margin-bottom: 0px;">Nuevo Agente</label>
                          <div class="input-group margin">
                            <input type="text" class="form-control" id="agent_new_text" maxlength="12">
                            <span class="input-group-btn">
                            <button type="button" id="btnguarda" class="btn btn-success btn-flat">Graba</button>
                            </span>
                            <button type="button" id="btncerrar" class="btn btn-danger btn-flat" style="margin-left: 2px;">No</button>
                          </div>
                        </div>
                        <div class="col-md-2">
                           
                        </div>   
                      </div>  
              	</div>
              </div>
            </div>
          </div>
        </div>
      </section>  
    </div>
  </div> 
  @include('layouts.footer')    
</body>
 
@include('layouts.script') 
<script type="text/javascript">
  $(function(){
    $('#asignaAgente').attr('disabled', false);
    $('#creaAgente').attr('disabled', false);
  });
</script>

<script type="text/javascript">
  $('#sl_agente_car').on('click', function(){
    var idAgente   = $('#sl_agente_car').val();
    var agente     = '';
    var cartera    = '';
    if(idAgente == 0){
      $('#sl_empresa_car').val(0);
      $('#sl_empresa_car').attr('disabled', true);
    }else{
      $('#sl_empresa_car').attr('disabled', false);
      $('#msje_agent').css('display', 'block');
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('getdataAgente') }}",
          type: 'POST',
          dataType: 'json',
          data: {idAgente:idAgente},
          beforeSend: function (data){
          },
          success: function (data) { 
            //console.log(data);
            data.msjAge.forEach(e=>{
                  var cartera = e.nombre_cartera;
                  var agente  = e.nombre_agente;
                  $("#msje_agent_agent").html('El Agente: <b>'+agente+'</b> Pertenece a la Cartera: <b>'+cartera+'</b>');
            })  
          },  
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo cargar consulte TI. ",tipo:"Error",label:"Error",id_div:"sl_agente_car"});    
          }
        }); 
    }   
  });

  $('#sl_empresa_car').on('change', function(){
    var idEmpresa = $('#sl_empresa_car').val();
    
    if(idEmpresa == 0){
      $('#sl_cartera_car_age').val(0);
      $('#sl_cartera_car_age').attr('disabled', true);
    }else{
      $('#sl_cartera_car_age').attr('disabled', false);
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('cargacmbcartera') }}",
          type: 'POST',
          dataType: 'json',
          data: {idEmpresa:idEmpresa},
          beforeSend: function (data){
          },
          success: function (data) { 
            //console.log(data);
            var _html = '';
                _html += '<option value="0">Seleccione...</option>' ;
                data.cmbCarteras.forEach(e=>{
                  _html += '<option value="'+e.cartera_id+'">'+e.nombre_cartera+'</option>' ;
                })
                $("#sl_cartera_car_age").html(_html);    
          },  
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo cargar consulte TI. ",tipo:"Error",label:"Error",id_div:"msjcargas"});    
          }
        }); 
    }
  });

  $('#sl_cartera_car_age').on('change', function(){
    var idCartera = $('#sl_cartera_car_age').val();
    
    if(idCartera == 0){
      $('#sl_pauta_car').val(0);
      $('#sl_pauta_car').attr('disabled', true);
    }else{
      $('#sl_pauta_car').attr('disabled', false);
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('cargacmbpauta') }}",
          type: 'POST',
          dataType: 'json',
          data: {idCartera:idCartera},
          beforeSend: function (data){
          },
          success: function (data) { 
            //console.log(data);
            var _html = '';
                _html += '<option value="0">Seleccione...</option>' ;
                data.cmbPautas.forEach(e=>{
                  _html += '<option value="'+e.pauta_id+'">'+e.nombre_pauta+'</option>' ;
                })
                $("#sl_pauta_car").html(_html);  
          },  
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo cargar consulte TI. ",tipo:"Error",label:"Error",id_div:"msjcargas"});    
          }
        }); 
    }
  });

 


  $('#asignaAgente').on('click', function(){
      var idAgente   = $('#sl_agente_car').val();
      var idEmpresa  = $('#sl_empresa_car').val();
      var idcartera  = $('#sl_cartera_car_age').val();
      var idcarteragls = $('select[id="sl_cartera_car_age"] option:selected').text();
      if(idcartera == 0){
          $("#msje_agent_agent").html('<div role="alert" aria-busy="true" aria-live="assertive">No se puede Asignar sin seleccionar una cartera.</div>');
      }else{
        $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('asignaAgente') }}",
          type: 'POST',
          dataType: 'json',
          data: {idAgente:idAgente,idEmpresa:idEmpresa,idcartera:idcartera},
          beforeSend: function (data){
            $("#msje_agent_agent").html('<div role="alert" aria-busy="true" aria-live="assertive">Realizando la asignacion, espere un momento... <i class="fa fa-spinner fa-lg fa-spin" aria-hidden="true"></i></div>');
          },
          success: function (data) { 
            //console.log(data);
            if(data.respuesta == true){
              $("#msje_agent_agent").html('Serealizo la asignación del usuario a la cartera: <b>'+idcarteragls+'</b>');  
            }else{
              $("#msje_agent_agent").html('Error no se pudo asignar al agente');  
            }
            
          },    
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo cargar consulte TI. ",tipo:"Error",label:"Error",id_div:"msjcargas"});    
          }
        });
      }
       
  });


  $('#creaAgente').on('click', function(){
     $('#asignaAgente').attr('disabled', true);
     $('#creaAgente').attr('disabled', true);
     $('#agent_new').css('display', 'block');
     $('#sl_empresa_car').attr('disabled', false);
     $('#sl_agente_car').val(0);
  });  

  $('#btncerrar').on('click', function(){
     $('#asignaAgente').attr('disabled', false);
     $('#creaAgente').attr('disabled', false);
     $('#agent_new').css('display', 'none');
     $('#agent_new_text').val('');
     $('#sl_empresa_car').attr('disabled', true);
     $('#sl_agente_car').val(0);
     $('#sl_cartera_car_age').attr('disabled', true);
     $('#sl_empresa_car').val(0);
     $('#sl_cartera_car_age').val(0);
  });  
  

  $('#btnguarda').on('click', function(){
      var nomAge     = $('#agent_new_text').val();
      var idEmpresa  = $('#sl_empresa_car').val();
      var idcartera  = $('#sl_cartera_car_age').val();
      var idcarteragls = $('select[id="sl_cartera_car_age"] option:selected').text();
      if(idcartera == 0){
          $("#msje_agent_agent").html('<div role="alert" aria-busy="true" aria-live="assertive">No se puede crear un usuario sin seleccionar una cartera.</div>');
      }else if(nomAge == ''){    
        $("#msje_agent_agent").html('<div role="alert" aria-busy="true" aria-live="assertive">Debe ingresar un agente nuevo.</div>');  
      }else{
        $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('creaAgente') }}",
          type: 'POST',
          dataType: 'json',
          data: {idEmpresa:idEmpresa,idcartera:idcartera,nomAge:nomAge},
          beforeSend: function (data){
            $("#msje_agent_agent").html('<div role="alert" aria-busy="true" aria-live="assertive">Realizando la asignacion, espere un momento... <i class="fa fa-spinner fa-lg fa-spin" aria-hidden="true"></i></div>');
          },
          success: function (data) { 
            console.log(data.respuesta);
            if(data.respuesta == 0){
              $("#msje_agent_agent").html('Serealizo el ingreso de : <b>'+nomAge+' en la cartera'+idcarteragls+'</b>');  
              $('#btncerrar').trigger('click');
              traeagentes();
            }else if(data.respuesta > 0){
              $("#msje_agent_agent").html('Ya existe un agente ingresado con ese nombre.');  
            }else{
              $("#msje_agent_agent").html('Error no se pudo ingresar el agente');
            }
          },    
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo cargar consulte TI. ",tipo:"Error",label:"Error",id_div:"msjcargas"});    
          }
        });
        
      }
       
  });

  function traeagentes(){
      $("#sl_cartera_car_age").val('');
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('getAgente') }}",
          type: 'GET',
          dataType: 'json',
          data: {},
          beforeSend: function (data){
          },
          success: function (data) { 
            console.log(data);
            var _html = '';
                _html += '<option value="0">Seleccione...</option>' ;
                data.cmbAgentes.forEach(e=>{
                  _html += '<option value="'+e.agente_id+'">'+e.nombre_agente+'</option>' ;
                })
                $("#sl_cartera_car_age").html(_html); 
                $("#sl_cartera_car_age").trigger("change"); 
          },  
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo cargar consulte TI. ",tipo:"Error",label:"Error",id_div:"msjcargas"});    
          }
      }); 
  }
  
</script>
@endsection

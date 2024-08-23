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
                  <h3 class="card-title col-md-2">Cargas</h3>
                  <h3 class="card-title col-md-2" id="tit_informe"></h3>
                </div>
              </div>
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="col-md-12" id="msjcargas"></div>
                <div class="row">
                  <!--Input Empresa-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sl_empresa_car">Empresa</label>
                      <select class="form-control" id="sl_empresa_car">
                        @if(isset($cmbEmpresas))
                          <option value="0" data-codigo="0">Seleccione...</option>
                          @foreach ($cmbEmpresas as $value)  
                            <option value="{{$value->empresa_id}}">{{$value->nombre_empresa}}</option>
                          @endforeach  
                        @endif                     
                      </select>
                    </div>
                  </div>
                  <!--Input datos-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sl_cartera_car">Cartera</label>
                      <select class="form-control" id="sl_cartera_car" disabled>
                        <option value="0" data-codigo="0">Seleccione...</option>
                      </select>
                    </div>
                  </div>
                  <!--Input Pauta-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sl_pauta_car">Pauta</label>
                      <select class="form-control" id="sl_pauta_car" disabled>
                        <option value="0" data-codigo="0">Seleccione...</option>
                      </select>
                    </div>
                  </div>
                  <!--Input Agente-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sl_agente_car">Agente</label>
                      <select class="form-control" id="sl_agente_car" disabled>
                        <option value="0" data-codigo="0">Seleccione...</option>
                      </select>
                    </div>
                  </div>
                  <!--Input datos-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="info_path">Ingreso de path</label>
                      <input type="text" id="ingresoPath" class="form-control" maxlength="15">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="info_entrga">N° Entrega</label>
                      <select class="form-control" id="sl_cantent">
                        <option value="0">Seleccione...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5 Especial</option>
                        <option value="6">6 Especial</option>
                        <option value="7">7 Especial</option>
                      </select>  
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Fechas de Entrega:</label>
                      <input type="text" class="form-control fecha" id="fechaEtapa">
                    </div>
                  </div>  
                  <div class="col-md-6">
                    <label for="info_path">Ingrese Archivo</label>
                    <div class="input-group margin">
                      <input type="file" class="form-control" id="lbl_sel" name="lbl_sel" style="display: block;" enctype="multipart/form-data, application/vnd.ms-excel" readonly>        
                        <button  class="btn btn-warning" id="sc_btn_subir_ex" style="margin-bottom: 7px;" disabled>Procesar</button>
                    </div>
                  </div>
                </div>
                <div id="bodyresp">
                  
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
    var oFileIn = document.getElementById('lbl_sel');     
    if(oFileIn.addEventListener) {
      oFileIn.addEventListener('change', filePicked, false);
    } 
    $(document).on('blur', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });
    $("#fechaEtapa").datepicker({
      dateFormat: 'dd/mm/yy',
      // firstDay: 1
    }).datepicker("setDate", new Date());          
  });
</script>

<script type="text/javascript">

  $('#sl_empresa_car').on('change', function(){
    var idEmpresa = $('#sl_empresa_car').val();
    
    if(idEmpresa == 0){
      $('#sl_cartera_car').val(0);
      $('#sl_cartera_car').attr('disabled', true);
    }else{
      $('#sl_cartera_car').attr('disabled', false);
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
                $("#sl_cartera_car").html(_html);  
          },  
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo cargar consulte TI. ",tipo:"Error",label:"Error",id_div:"msjcargas"});    
          }
        }); 
    }
  });

  $('#sl_cartera_car').on('change', function(){
    var idCartera = $('#sl_cartera_car').val();
    
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

  $('#sl_pauta_car').on('change', function(){
    var idPauta   = $('#sl_pauta_car').val();
    var idCartera = $('#sl_cartera_car').val();
    //console.log(idCartera);
    if(idPauta == 0){
       $('#sl_agente_car').val(0);
      $('#sl_agente_car').attr('disabled', true);
    }else{
      $('#sl_agente_car').attr('disabled', false);
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('cargacmbagente') }}",
          type: 'POST',
          dataType: 'json',
          data: {idCartera:idCartera},
          beforeSend: function (data){
          },
          success: function (data) { 
            //console.log(data);
            var _html = '';
                _html += '<option value="0">Seleccione...</option>' ;
                data.cmbAgentes.forEach(e=>{
                  _html += '<option value="'+e.agente_id+'">'+e.nombre_agente+'</option>' ;
                })
                $("#sl_agente_car").html(_html);  
          },  
          Error: function (data){
            fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo cargar consulte TI. ",tipo:"Error",label:"Error",id_div:"msjcargas"});    
          }
        }); 
    }
  });

  $('#lbl_select').on('click', function(oEvent){
      $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Archivo Leído</div>');
      var conta     =  0;//cantidad de pestañas
      var ver       = '';//nombre de pestaña
      var arr       = [];
      var arr_cab   = [];
      var arr_dat   = [];
  });

  function filePicked(oEvent) {
    oEvent.preventDefault();
    var oFile          = oEvent.target.files[0];
    var sFilename      = oFile.name;
    var reader         = new FileReader();
    var conta          = 0; //cantidad de pestañas
    var cas            = 0; 
    var ver            = ''; //nombre de pestaña
    var cantidad_reg   = 0;
    var cabecera       = [];
    var arr_cab        = [];

    var arr            = [];  
    var arr_dat        = [];
    var oJS            = [];
    var cont           =  0;
        
    reader.onloadstart = function (e) {
      $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Archivo Leído</div>');
    };

    reader.onload = function(e) {
      var data_xlsx = e.target.result;
      var cfb  = XLSX.read(data_xlsx,{type: 'binary', defval:"", cellDates: true, dateNF: 'DD-MM-YYYY'});      
      cfb.SheetNames.forEach(function(sheetName) {
        oJS  = XLSX.utils.sheet_to_json(cfb.Sheets[sheetName]);
          arr.push(oJS);
      });    
  
      conta = (cfb.SheetNames.length);//cantidad de pestañas
      ver   = (cfb.SheetNames);//nombre de pestalas
      cas   = ver[0]; //solo pestaña uno
      datos   = XLSX.utils.sheet_to_json(cfb.Sheets[cas], {defval:"", cellDates: true, dateNF: 'DD-MM-YYYY'}); 
  
      for (key in datos[0]){
        cabecera[cont]=key;
          cont++;
      }
 
      cantidad_reg = arr[0].length;  
      arr_cab.push(datos);
    
    
    };
    reader.readAsBinaryString(oFile);    
    //console.log(arr_cab); 
  

    $('#sc_btn_subir_ex').on('click', function(){
        var empresa       = $('#sl_empresa_car').val();
        var cartera       = $('#sl_cartera_car').val();
        var pauta         = $('#sl_pauta_car').val();
        var agente        = $('#sl_agente_car').val();
        var path          = $('#ingresoPath').val();
        var entrega       = $('#sl_cantent').val();
        var name          = $('#lbl_sel').val();
        var fechaEtapa    = $('#fechaEtapa').val();
        var _html         = '';
        var swcont        = 0;

        // let file = lbl_sel.files[0];
        // console.log(file);
        if(empresa == 0){
          $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Debe Seleccionar la empresa</div>');
        }else if(cartera == 0){
          $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Debe Seleccionar la cartera</div>');
        }else if(pauta == 0){
          $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Debe Seleccionar la pauta</div>');
        }else if(agente == 0){
          $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Debe Seleccionar el agente</div>');
        }else if(path == ''){
          $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Debe Seleccionar la ruta</div>');
        }else if(entrega == 0){
          $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Debe Seleccionar la entrega</div>');
        }else if(fechaEtapa == ''){
          $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Debe Seleccionar una fecha de entrega</div>');
        }else if(name == ''){
          $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Debe Seleccionar el archivo</div>');
        }else{
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('upexcelaudio') }}",
            type: 'POST',
            dataType: 'json',
            data: {datos: JSON.stringify(datos), cantidad_reg:cantidad_reg, cont:cont,cabecera: JSON.stringify(cabecera),nameArch:name, empresa:empresa, cartera:cartera, pauta:pauta, agente:agente, path:path, entrega:entrega, name:name, fechaEtapa:fechaEtapa},
            beforeSend: function (data){
              $("#msjcargas").html('<div class="alert alert-warning alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive"> Realizando la carga, espere un momento... <i class="fa fa-spinner fa-lg fa-spin" aria-hidden="true"></i></div>');
              $("#sc_btn_subir_ex").attr("disabled",true);
              $("#sc_btn_subir_ex").css({'background-color':'#f39c12','border-color':'#e08e0b'});
            },
            success: function (data) { 
              data.respuesta.forEach(e => {
                if(e === true){
                  _html +='<div class="alert alert-success alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive">N° '+swcont+' El audio: <b>'+data.audioaux[swcont]+'</b> fue cargado correctamente.</div>';
                }else{
                  _html +='<div class="alert alert-danger alert-dismissible col-xs-12" role="alert" aria-busy="true" aria-live="assertive">El audio: <b>'+data.audioaux[swcont]+'</b> No fue cargado revise.</div>';
                }   
                swcont++;             
              });
              $("#sc_btn_subir_ex").attr("disabled",false);
              $("#sc_btn_subir_ex").css({'background-color':'#28a745','border-color':'#28a745','color':'white'}); 
              $("#bodyresp").html(_html);
              $("#msjcargas").html('');
            },  
            Error: function (data){
              fn_avisos_js({mensaje:"<b>¡¡¡ ADVERTENCIA !!!</b> No se pudo leer el archivo revise su formato. ",tipo:"Error",label:"Error",id_div:"ver_excel"});    
            }
          }); 
        } 
    });
  } 
  
  $('#lbl_sel').on('change', function(){
      $('#sc_btn_subir_ex').attr('disabled',false); 
  });

</script>
@endsection

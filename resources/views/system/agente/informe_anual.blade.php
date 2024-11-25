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
                  <h3 class="card-title col-md-4">Informe Anual</h3>
                  <h3 class="card-title col-md-2" id="tit_informe"></h3>
                </div>
              </div>
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                  <!--Input cartera-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="info_cuenta_ia">Cartera</label>
                      <select class="form-control" id="info_cuenta_ia">
                        @if(isset($cmbasignaciones))
                          <option value="0" data-codigo="0">Seleccione...</option> 
                          @foreach ($cmbasignaciones as $value)  
                            <option value="{{$value->cartera_id}}">{{$value->nombre_cartera}}</option>
                          @endforeach  
                        @endif                     
                      </select>
                    </div>
                  </div>
              
                 
                  <!--YEAR-->
                  <div class="col-md-2">
                    <label for="cmb_year_ia">Año</label>
                    <select class="form-control" id="cmb_year_ia">
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
                    <button type="button" class=" btn btn-primary " id="button_buscar_inf_anual"> Buscar </button>
                  </div>
                </div>
              </div>
            </div>      
            <div class ="col-md-12" id="info_anual_id"></div>
            <div class="card card-info">
              <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                  <div id="signus"></div> 
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
$("#button_buscar_inf_anual").on("click", function() {
    var carteraent = $('#info_cuenta_ia').val();
    var cmb_year_ent = $('#cmb_year_ia').val();
    var _html = '';
  
   // console.log(carteraent);
   // console.log(cmb_year_ent);
  

    _html += '<h2>Información Anual de Agentes</h2>';
  
    // Agregar encabezados de los meses del año
    _html += '<table border="1">';
    _html += '<thead>';
    _html += '<tr>';
    _html += '<th>Agente</th>';
  
    var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  
    meses.forEach(function(mes) {
        _html += '<th>' + mes + '</th>';
    });
  
    _html += '<th>Promedio</th>';
    _html += '</tr>';
    _html += '</thead>';
    _html += '<tbody>';
  
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('ajaxagenteinfoanual') }}",
        type: 'POST',
        dataType: 'JSON',
        data: { carteraent: carteraent, cmb_year_ent: cmb_year_ent },
        xhrFields: {withCredentials: true}, 
         beforeSend: function () {
               $("#signus").html('<div class="alert alert-warning" role="alert" style="padding-top: 20px;">Procesando...<i class="fa fa-spinner fa-lg fa-spin" aria-hidden="true"></i></div>');
         },
        success: function(data) {
            console.log(data);

            
            let agentesData = {};

            data.ejecucion.forEach(e => {
                if (!agentesData[e.agente]) {
                    agentesData[e.agente] = {
                        nombre_agente: e.nombre_agente, 
                        meses: Array(12).fill('-') 
                    };
                }
                
                
                let indiceMes = e.mes - 1; 
                agentesData[e.agente].meses[indiceMes] = e.promedio;
            });

            // Reiniciar _html para crear la tabla
            _html = `<table class="table display" id='tbl_informe_anual' style="padding-bottom: 10px;">          
                      <thead>
                        <tr>
                          <td style ="background-color: #3e93ad;color:white;text-align: center;">Ejecutivo</td>`;
        
            // Agregar encabezados para los meses
            for (let i = 0; i < meses.length; i++) { // Cambiar 1 a 0 y usar meses.length
                _html += `<td style ="background-color: #3e93ad;color:white;text-align: center"> ${meses[i]}</td>`; // Cambia a "Mes X"
            } 
        
            _html += `<td style ="background-color: #3e93ad;color:white;text-align: center;">Promedio</td>`;  
            _html += `</tr>
                      </thead>
                      <tbody>`; 
        
            Object.values(agentesData).forEach(agente => {
                _html += `<tr>`;
                _html += `<td style="text-align: center;">${agente.nombre_agente}</td>`;

                agente.meses.forEach(valor => {
                    _html += `<td style="text-align: center;">${valor}</td>`;
                });

                let sumaPromedios = agente.meses.reduce((sum, val) => {
                    return val !== '-' ? sum + parseFloat(val) : sum;
                }, 0);
                let cantidadMeses = agente.meses.filter(val => val !== '-').length;
                let promedioGeneral = cantidadMeses > 0 ? (sumaPromedios / cantidadMeses).toFixed(0) : '-';

                _html += `<td style="text-align: center;"><b>${promedioGeneral}</b></td>`;
                _html += `</tr>`;
            });

            _html += `</tbody>
                      </table>`;   
        
            $('#signus').html(_html);
            cargadatanualtable(); // Llama a tu función para inicializar DataTable
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
        },
    });

});

function cargadatanualtable(){
  $('#tbl_informe_anual').DataTable({      
    "bPaginate": false,
    "bInfo": false,
    "paging": false,
    "ordering": false,
    "searching": false,
      dom: 'Bfrtip',
      buttons: [{
             extend:'excelHtml5',
             // extend:'pdfHtml5',
            title: "Informe evaluación anual"
        },{
             //extend:'excelHtml5',
            extend:'pdfHtml5',
            title: "Informe evaluación anual"
        }]
  });         
}

</script>

@endsection
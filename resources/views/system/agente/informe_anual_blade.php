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
                      <label for="info_cuenta">Cartera</label>
                      <select class="form-control" id="info_cuenta">
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
                    <button type="button" class=" btn btn-primary " id="button_buscar_inf_anual"> Buscar </button>
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
$("#button_buscar_inf_anual").on("click", function(e){
  var carteraent   = $('#info_cuenta').val();
  var cmb_mes_ent  = $('#cmb_mes_ent').val();
  var cmb_year_ent = $('#cmb_year_ent').val();
  $(document).ready(function () {
    // Función para cargar datos de agentes y sus promedios mensuales
    function cargarDatosAgentes() {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ route('ajaxcargaragentes') }}", // Ruta a tu controlador
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                // Limpiar el cuerpo de la tabla
                $('#cuerpo-tabla').empty();

                // Crear la tabla
                let tabla = $('<table id="tabla-agentes" class="table">');
                let thead = $('<thead>');
                let tbody = $('<tbody>');

                // Crear encabezados
                let encabezado = `<tr>
                    <th>Agente</th>
                    <th>Enero</th>
                    <th>Febrero</th>
                    <th>Marzo</th>
                    <th>Abril</th>
                    <th>Mayo</th>
                    <th>Junio</th>
                    <th>Julio</th>
                    <th>Agosto</th>
                    <th>Septiembre</th>
                    <th>Octubre</th>
                    <th>Noviembre</th>
                    <th>Diciembre</th>
                    <th>Promedio</th>
                </tr>`;

                // Añadir encabezados a thead
                thead.append(encabezado);
                tabla.append(thead);

                // Procesar los datos y llenar la tabla
                $.each(data.agentes, function (index, agente) {
                    // Inicializar un objeto para almacenar los totales y conteo
                    let total = 0;
                    let conteo = 0;
                    let notasPromedio = [];
                    
                    // Crear fila para el agente
                    let fila = `<tr>
                        <td>${agente.nombre_agente}</td>`;

                    // Llenar los datos por mes
                    for (let mes = 1; mes <= 12; mes++) {
                        let valorMes = agente[`mes_${mes}`] || 0; // Ajusta según cómo vengas los meses
                        fila += `<td>${valorMes}</td>`;
                        total += valorMes; // Sumar al total
                        if (valorMes > 0) conteo++; // Contar si hay valores

                        // Obtener la nota promedio del mes
                        let notaPromedioMes = data.notasPromedio[mes] || 0; // Ajusta según cómo vengas las notas
                        notasPromedio.push(notaPromedioMes); // Almacenar la nota promedio
                    }

                    // Calcular el promedio
                    let promedio = conteo > 0 ? (total / conteo).toFixed(2) : 0;
                    fila += `<td>${promedio}</td>`;
                    fila += `</tr>`;
                    tbody.append(fila); // Añadir la fila del agente al tbody

                    // Añadir fila para las notas promedios
                    let filaNotas = `<tr>
                        <td>Notas Promedio</td>`;
                    for (let mes = 1; mes <= 12; mes++) {
                        let notaPromedioMes = notasPromedio[mes - 1] || 0;
                        filaNotas += `<td>${notaPromedioMes}</td>`;
                    }

                    // Calcular el promedio de notas
                    let promedioNotas = (notasPromedio.reduce((a, b) => a + b, 0) / notasPromedio.length).toFixed(2);
                    filaNotas += `<td>${promedioNotas}</td>`;
                    filaNotas += `</tr>`;
                    tbody.append(filaNotas); // Añadir la fila de notas promedios al tbody
                }

                // Añadir tbody a la tabla
                tabla.append(tbody);

                // Añadir la tabla al DOM
                $('#cuerpo-tabla').append(tabla);
            },
            error: function (xhr, status, error) {
                console.error("Error en la carga de datos: ", error);
                $('#cuerpo-tabla').html('<tr><td colspan="14" class="text-danger">Error al cargar datos.</td></tr>');
            }
        });
    }

    // Evento de clic en el botón Buscar
    $('#btn-buscar').click(function () {
        cargarDatosAgentes(); // Llamar a la función para cargar los datos al hacer clic en Buscar
    });
});
</script>
@endsection
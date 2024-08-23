@extends('layouts.app')

@section('content')

@include('layouts.barrasup')

    <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">Evaluación de audios</h3>
                </div>

                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Seleccione empresa</label>
                                    <select class="form-control" id="sl_emp_audio">
                                        <option value="1">Empresa 1</option>
                                        <option value="2">Empresa 2</option>
                                        <option value="3">Empresa 3</option>
                                        <option value="4">Empresa 4</option>
                                        <option value="5">Empresa 5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Seleccione agente</label>
                                    <select class="form-control" id="sl_agent_audio">
                                        <option value ="" selected >Seleccione...</option>
                                        <option>Agente 1</option>
                                        <option>Agente 2</option>
                                        <option>Agente 3</option>
                                        <option>Agente 4</option>
                                        <option>Agente 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Audio</label>
                                    <select multiple="" class="form-control" id="sl_aud_audio">
                                        <option>Audio 1</option>
                                        <option>Audio 2</option>
                                        <option>Audio 3</option>
                                        <option>Audio 4</option>
                                        <option>Audio 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">Evaluación de audios</h3>
                </div>

                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
                        </div>
                        
                        <div class="card-body">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                        <thead>
                        <tr><th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Rendering engine</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Browser</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Platform(s)</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Engine version</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">CSS grade</th></tr>
                        </thead>
                        <tbody>

                        <tr class="odd">
                        <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                        <td>Firefox 1.0</td>
                        <td>Win 98+ / OSX.2+</td>
                        <td>1.7</td>
                        <td>A</td>
                        </tr><tr class="even">
                        <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                        <td>Firefox 1.5</td>
                        <td>Win 98+ / OSX.2+</td>
                        <td>1.8</td>
                        <td>A</td>
                        </tr><tr class="odd">
                        <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                        <td>Firefox 2.0</td>
                        <td>Win 98+ / OSX.2+</td>
                        <td>1.8</td>
                        <td>A</td>
                        </tr><tr class="even">
                        <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                        <td>Firefox 3.0</td>
                        <td>Win 2k+ / OSX.3+</td>
                        <td>1.9</td>
                        <td>A</td>
                        </tr><tr class="odd">
                        <td class="sorting_1 dtr-control">Gecko</td>
                        <td>Camino 1.0</td>
                        <td>OSX.2+</td>
                        <td>1.8</td>
                        <td>A</td>
                        </tr><tr class="even">
                        <td class="sorting_1 dtr-control">Gecko</td>
                        <td>Camino 1.5</td>
                        <td>OSX.3+</td>
                        <td>1.8</td>
                        <td>A</td>
                        </tr><tr class="odd">
                        <td class="sorting_1 dtr-control">Gecko</td>
                        <td>Netscape 7.2</td>
                        <td>Win 95+ / Mac OS 8.6-9.2</td>
                        <td>1.7</td>
                        <td>A</td>
                        </tr><tr class="even">
                        <td class="sorting_1 dtr-control">Gecko</td>
                        <td>Netscape Browser 8</td>
                        <td>Win 98SE+</td>
                        <td>1.7</td>
                        <td>A</td>
                        </tr><tr class="odd">
                        <td class="sorting_1 dtr-control">Gecko</td>
                        <td>Netscape Navigator 9</td>
                        <td>Win 98+ / OSX.2+</td>
                        <td>1.8</td>
                        <td>A</td>
                        </tr><tr class="even">
                        <td class="sorting_1 dtr-control">Gecko</td>
                        <td>Mozilla 1.0</td>
                        <td>Win 95+ / OSX.1+</td>
                        <td>1</td>
                        <td>A</td>
                        </tr></tbody>
                        <tfoot>
                        <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
                        </tfoot>
                        </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                        </div>
                        
                        </div>
                </div>
            </div>

            <div class="modal fade show" id="modal_audio" style="display: none;" aria-modal="true" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Asignación de audio</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Desea asignar este audio al agente?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_cerrar">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="modal_asignar">Asignar</button>
                        </div>
                    </div>
                </div>
            </div>

 @include('layouts.script')
            <script type="text/javascript">
                $(document).on('change', '#sl_emp_audio', function(){
                    var empresa = $("#sl_emp_audio").val();
                    var agente = $("#sl_agent_audio").val();
                    console.log(empresa + " " + agente );
                        if (empresa == 1 ){
                            $("#sl_agent_audio").html(" <option value="" selected>seleccione...</option><option>Agente 1</option>"
                    + "<option>Agente 2</option>" + "<option>Agente 3</option>" + "<option>Agente 4</option>" + "<option>Agente 5</option>");
                    $("#sl_aud_audio").html("<option>Audio 1</option>"
                                        + "<option>Audio 2</option>"
                                        + "<option>Audio 3</option>"
                                        + "<option>Audio 4</option>"
                                        + "<option>Audio 5</option>");
                        }else if(empresa == 2){
                            $("#sl_agent_audio").html(" <option value="" selected>seleccione...</option><option>Luis 1</option>"
                    + "<option>Luis 2</option>" + "<option>Luis 3</option>" + "<option>Luis 4</option>" + "<option>Luis 5</option>");
                    $("#sl_aud_audio").html("<option>Escucha 1</option>"
                                        + "<option>Escucha 2</option>"
                                        + "<option>Escucha 3</option>"
                                        + "<option>Escucha 4</option>"
                                        + "<option>Escucha 5</option>");
                        }else if(empresa == 3){
                            $("#sl_agent_audio").html("<option  value ="" selected> seleccione...</option>" + "<option>J 1</option>"
                    + "<option>J 2</option>" + "<option>J 3</option>" + "<option>J 4</option>" + "<option>J 5</option>");
                    $("#sl_aud_audio").html("<option>Record 1</option>"
                                        + "<option>Record 2</option>"
                                        + "<option>Record 3</option>"
                                        + "<option>Record 4</option>"
                                        + "<option>Record 5</option>");
                        }});

                        $(document).on('click', '#sl_aud_audio' , function(){
                            alert("cualquier coisa");
                            $("#modal_audio").modal("show");
                        });

                        $(document).on('click', '#modal_cerrar' , function(){
                            
                            $("#modal_audio").modal("hide");
                        });

                        $(document).on('click', '#modal_asignar' , function(){
                            var agente = $("#sl_agent_audio").val();
                            if(agente == " "){
                                alert("debe escoger un agente");
                           }else{
                            alert("se ha asignado al agente:" + agente + "el audio seleccionado")
                           }
                        });





            </script>


@endsection
<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;/*para recibir los POST de un formulario*/
use Illuminate\Support\Facades\DB; /*conexiones Base de Datos*/
use Illuminate\Support\Facades\Config;
use Illuminate\Support\MessageBag;/*mensaje de errores*/
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use PDOException; 
use Log;

class CargasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void 
     */
    public function __construct()
    {
        

   }

    /**
     * Muestra la vista de cargas.
     *
     * @return \Illuminate\View\View
     */
    public function mostrarCargas()
    {
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM `tbl_empresas` WHERE 1;");
            $cmbEmpresas   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $cmbEmpresas = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

        return view('system.agente.cargas')->with('name', 0)
                                           ->with('cmbEmpresas', $cmbEmpresas);
    }


    public function cargacmbcartera(Request $request)
    {
        $idEmpresa = $request->input('idEmpresa');    
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM `tbl_cartera` WHERE empresa_id = $idEmpresa;");
            $cmbCarteras   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $cmbCarteras = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

        return response()->json(['cmbCarteras' => $cmbCarteras]);
    }

    public function cargacmbpauta(Request $request)
    {
        $idCartera = $request->input('idCartera');    
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM `tbl_pauta` WHERE id_cartera_dest = $idCartera;");
            $cmbPautas   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $cmbPautas = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

        return response()->json(['cmbPautas' => $cmbPautas]);
    }


    public function cargacmbagente(Request $request)
    {
        $idCartera = $request->input('idCartera');    
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM `tbl_agente` WHERE cartera_id = $idCartera;");
            //log::debug($sql);
            $cmbAgentes   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $cmbAgentes = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

        return response()->json(['cmbAgentes' => $cmbAgentes]);
    }


      public function cargaAgente(Request $request)
    {
        
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM tbl_agente;");
            $cmbAgentes   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $cmbAgentes = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }    

        try{
            $sql=("SELECT * FROM `tbl_empresas` WHERE 1;");
            $cmbEmpresas   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $cmbEmpresas = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

        return view('system.agente.cargasagente')->with('name', 0)
                                           ->with('cmbEmpresas', $cmbEmpresas)
                                           ->with('cmbAgentes', $cmbAgentes);    

    }    

      public function getAgente(Request $request)
    {
        $idAgente = $request->input('idAgente'); 
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM tbl_agente;");
            $cmbAgentes   = $db->select($sql);  
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $msjCartera = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }    

        return response()->json(['cmbAgentes' => $cmbAgentes]);   

    } 

        public function asignaAgente(Request $request)
    {
        $idAgente  = $request->input('idAgente');
        $idEmpresa = $request->input('idEmpresa');
        $idcartera = $request->input('idcartera'); 
        $db= DB::connection('mysql');
        try{
            $sql=("UPDATE tbl_agente SET cartera_id=$idcartera where agente_id = $idAgente ;");
            $respuesta = $db->statement($sql);  
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $respuesta = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }    

        return response()->json(['respuesta' => $respuesta]);
    } 


       public function getdataAgente(Request $request)
    {
        $idAgente = $request->input('idAgente'); 
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM tbl_agente AS AG, tbl_cartera AS CA where AG.agente_id = $idAgente AND AG.cartera_id = CA.cartera_id;");
            $msjAge   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $msjAge = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }    

        return response()->json(['msjAge' => $msjAge]);

    } 


       public function creaAgente(Request $request)
    {
        $nomAge    = $request->input('nomAge');
        $idEmpresa = $request->input('idEmpresa');
        $idcartera = $request->input('idcartera'); 
        $cuenta    = 0;     
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT COUNT(*) AS contar FROM `tbl_agente` WHERE nombre_agente = LOWER('$nomAge')");
            $result = $db->select($sql);
            foreach($result as $value) {
                $cuenta     = $value->contar;
            }
            if($cuenta == 0){
                try{
                    $sql=("INSERT INTO tbl_agente (cartera_id, nombre_agente, id_audio) VALUES ($idcartera, LOWER('$nomAge'), 0)");
                    $respuesta = $db->statement($sql);  
                    DB::disconnect('mysql');
                }catch(QueryException $ex){
                    $respuesta = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
                } 
            }    
        }catch(QueryException $ex){
            $respuesta = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }      

        return response()->json(['respuesta' => $cuenta]);
    } 


      public function upexcelaudio(Request $request)
    {
        $datos          = json_decode($_POST['datos']);
        $cabecera       = json_decode($_POST['cabecera']);
        $cont           = $request->input('cont');
        $cantidad_reg   = $request->input('cantidad_reg');
        $nameArch       = $request->input('nameArch');
        $extension      = substr($nameArch, strrpos($nameArch, '.')+1);
        $empresa        = $request->input('empresa');
        $cartera        = $request->input('cartera');
        $pauta          = $request->input('pauta');
        // $agente         = $request->input('agente');
        $path           = $request->input('path');
        $entrega        = $request->input('entrega');
        $name           = $request->input('name');
        $fechaAux       = $request->input('fechaEtapa');
        $fechaEtapa     = implode('-',array_reverse(explode('/', $fechaAux)));
        $arr_fecha      = explode('/', $fechaAux);
        $mes            = $arr_fecha[1];
        $year           = $arr_fecha[2];
        $fecha          = date('Y-m-d');
        $sql2           = '';
        $sql3           = array('');
        $respuestas     = array('');
        $auxcont        = 0;
        $nombre_aux     = explode($extension, $nameArch);
        $nombre_final   = $nombre_aux[0].'txt';
        $idage          = 0;
        $audioaux       = array('');
        
        foreach ($datos as $vals){
            $TotalFila = 0;       
            foreach ($vals as $val=>$elements) {
                if ($TotalFila <= $cont){
                    $sql3[$TotalFila] ="".$elements."";
                    
                }
                if ($TotalFila == 2){
                    $db= DB::connection('mysql');
                    try{
                        $sql=("SELECT * FROM tbl_agente where nombre_agente = LOWER('$sql3[2]')");
                        $result   = $db->select($sql); 
                        foreach ($result as $value){
                            $idage= $value->agente_id; 
                        }    
                        DB::disconnect('mysql');
                    }catch(QueryException $ex){
                        $msjAge = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
                    } 
                    $audio = $sql3[0];
                    $rut   = $sql3[1];
                }                
                $TotalFila = $TotalFila+1;                  
            }
            

            $db= DB::connection('mysql');
            try{
                $sql2=("INSERT INTO tbl_grabacion (mandante_id, cartera_id, pauta_id, agente_id, nombre_graba, ruta, fecha_carga, fecha, mes, year, num_envio, rut_cliente) VALUES ($empresa, $cartera, $pauta, $idage, '$audio', '$path', '$fecha', '$fechaEtapa', $mes, $year, $entrega, $rut) ");
               log::debug($sql2);
                $respuesta = $db->statement($sql2);  
                DB::disconnect('mysql');
            }catch(QueryException $ex){
                $respuesta = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
            }   
            $respuestas[$auxcont] =  $respuesta;
            $audioaux[$auxcont]   =  $audio;  
            $auxcont++;
        }    
        

        return response()->json(['respuesta' => $respuestas, 'audioaux' => $audioaux]);
    } 


} 
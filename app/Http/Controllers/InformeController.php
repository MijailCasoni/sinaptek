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
use PDO;
use PDOException; 
use Log;

class InformeController extends Controller
{ 
	
 	public function informes(){
 		$usuario=auth()->user()->name;
        $db= DB::connection('mysql');
        try{
            $sql=("CALL cmb_carteras_asig ('$usuario')");
            $cmbasignaciones   = $db->select($sql); 
            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

         return view('system.agente.informe_tabla')->with('name',$usuario)
                                                   ->with('cmbasignaciones',$cmbasignaciones);

    }


    public function ajaxagenteinfo(Request $request){
        $usuario=auth()->user()->name;
        $db= DB::connection('mysql');
        try{
            $sql=("");
            $cmbasignaciones   = $db->select($sql); 
            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

         return view('system.agente.Informe')->with('name',$usuario)
                                             ->with('cmbasignaciones',$cmbasignaciones);

    }

    public function ajaxbuscarinforme(Request $request){
        $usuario   =auth()->user()->name;
        $cart_info = $request->input('cart_info');
        $agent_info= $request->input('agent_info');
        $fech_init = $request->fech_init;
        $fech_fin  = $request->fech_fin;
        $array     = [];
        $arraynota = [];
        $arraybody = [];
        $informes  = '';
        $informes2 = '';
        $resp      = 'S';
        $h         = 0; 
        $fech_init = implode('',array_reverse(explode('/', $fech_init)));
        $fech_fin = implode('',array_reverse(explode('/', $fech_fin)));
         
        $db= DB::connection('mysql');

         

        try{
            $sql=("SELECT * FROM `tbl_grabacion` WHERE agente_id = '$agent_info' AND st_mostrar = 'N' AND fecha_evaluacion BETWEEN '$fech_init' and '$fech_fin';");
            $informes   = $db->select($sql); 

            foreach ($informes as $value) {  
                $idgrab     = $value->grabacion_id;
                    
                $sql=("SELECT  PA.rut_cliente, PA.nota, GR.grabacion_id,GR.accion_id,GR.nota_accion,AC.nombre_accion, AC.ponderacion, GR.atributo_id, GR.Ponderacion_Item, PI.nombre_atributo FROM tbl_grabacion AS PA, tbl_evalua_grab AS GR, tbl_accion AS AC, tbl_atributo AS PI WHERE PA.grabacion_id = '$idgrab' AND GR.grabacion_id = '$idgrab' AND AC.accion_id = GR.accion_id AND GR.atributo_id = PI.atributo_id; ");
                $informes2    = $db->select($sql);
                $arraybody[]  =  (array) $informes2;
            } 
            //log::debug($array);

            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        if(empty($informes2)){
           $resp = 'N';
        }else{
           $resp = 'S'; 
        }

         return response()->json(['informes2'=>$informes2, 'informes'=>$informes, 'arraybody'=>$arraybody, 'resp'=>$resp, 'arraynota'=>$arraynota]);
    } 



}
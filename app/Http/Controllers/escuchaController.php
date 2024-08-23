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
use Illuminate\Support\Facades\Storage;
use PDO;
use PDOException; 
use Log;

class escuchaController extends Controller
{
     public function index()
    {
        return view('system.agente.escucha');
    }

     public function trae()
    {
        
        $usuario=auth()->user()->name;
        $db= DB::connection('mysql');
        try{
            $sql=("CALL cmb_carteras_asig ('$usuario')");
            $cmbasignaciones   = $db->select($sql); 
            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

        return view('system.agente.escuchadata')->with('name',$usuario)
                                                ->with('cmbasignaciones',$cmbasignaciones);
    }

     public function ajaxagente(Request $request)
    {
        $cartera = $request->input('cartera');
        $usuario = auth()->user()->name;
        
        $db= DB::connection('mysql');
        try{
            $sql=("CALL cmb_agente_audios ('$cartera')");
            $cmbcarteras   = $db->select($sql); 
            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $cmbcarteras = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        
        return response()->json(['cmbcarteras'=>$cmbcarteras]);
    }

      public function ajaxaudio(Request $request)
    {
        $idagente = $request->input('idagente');
        $usuario = auth()->user()->name;
        
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM tbl_grabacion AS GR, tbl_agente AG, tbl_pauta AS PA WHERE GR.agente_id = '$idagente' AND AG.agente_id = '$idagente' AND GR.pauta_id = PA.pauta_id AND GR.st_mostrar = 'S';");
            $cmbaudios   = $db->select($sql); 
            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $cmbaudios = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        
        return response()->json(['cmbaudios'=>$cmbaudios]);
    }
        //$files = Storage::disk('public')->allFiles($directory);
   

    
    public function ajaxaudioevalua(Request $request){
        $idaudio    = $request->input('idaudio');
        $cartera_id = $request->input('cartera_id');
        $usuario    = auth()->user()->name;
        
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM tbl_cartera AS CA, tbl_pauta AS PA, tbl_pauta_atributo AS AP, tbl_atributo AS TB, tbl_atributo_accion AS AC, tbl_accion AS CC WHERE CA.cartera_id = '$cartera_id' AND PA.id_cartera_dest = CA.cartera_id AND AP.pauta_id = CA.pauta_id AND TB.atributo_id = AP.atributo_id AND AC.atributo_id = TB.atributo_id AND CC.accion_id = AC.accion_id;");
            $pautajson   = $db->select($sql); 
            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $pautajson = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        //log::debug($sql);
        
        return response()->json(['pautajson'=>$pautajson]);
    }


    public function ajaxaudioevaluagraba(Request $request){
        $notafinal    = $request->input('notafinal');
        $array        = json_decode($request->input('array'));
        $audio        = $request->input('audio');
        $pauta        = $request->input('pauta');
        $time         = $request->input('time');
        $fecha_act    = $request->input('fecha_act');
        $observacion  = $request->input('observacion');
        $especial     = $request->input('especial'); // 0 no esta marcado el 3ero - 1 si esta marcado tercero
        $usuario      = auth()->user()->name;
        $mes          = date("m");
        $year         = date("Y");    
        $fec_eval     = implode('',array_reverse(explode('/', $fecha_act)));
        $filascont    = 0;
        $pode_sum     = 0;
        $pode_aux     = 0;
        $atributo_aux = 10;
        $mensaje      = '';  
        $db= DB::connection('mysql');
        try{
            $sql=("UPDATE tbl_grabacion SET st_evalua='1',nota='$notafinal',obs='$observacion',tiempo='$time', contac3='$especial', fecha_evaluacion='$fec_eval' WHERE grabacion_id='$audio';");
            //log::debug($sql);
            $ejecucion = $db->statement($sql); 
            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $mensaje = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

        foreach ($array as $value) {
            $grab     = $value->audio;
            $accion   = $value->accion;

            if($atributo_aux == $value->atributo ){
                $pode_sum = 0;
                foreach ($array as $value_pond) {
                    if($value_pond->atributo == $atributo_aux){
                       $pode_sum = $pode_sum+$value_pond->ponde; 
                    }
                }
            }else{
                $pode_sum = 0;
                $atributo_aux = $value->atributo; 
                foreach ($array as $value_pond) {
                    if($value_pond->atributo == $atributo_aux){
                       $pode_sum = $pode_sum+$value_pond->ponde; 
                    }
                }
            }

            $atributo_aux = $value->atributo;
            if($value->evaluacion == 'SI'){
                $ponde_eval = $value->ponde;  
            }else{
                $ponde_eval = 0;  
            } 
            //log::debug($value->evaluacion);
            try{
                $sql=("SELECT * FROM tbl_evalua_grab WHERE grabacion_id = '$grab' AND accion_id = '$accion' ");

                $veraccion = $db->select($sql);
                foreach ($veraccion as $valueacc) {  
                    $idgrab     = $valueacc->evaluagrab_id;
                    $filascont  = 1;
                }    
                //log::debug($sql);
                DB::disconnect('db_scj');
            }catch(QueryException $ex){
                $mensaje = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );  
            }

            if($filascont  == 0){             
                $insert =  $db->table('tbl_evalua_grab')->insert(
                    [
                         'evaluapauta_id'  => $value->pauta
                        ,'grabacion_id'    => $value->audio
                        ,'atributo_id'     => $value->atributo
                        ,'accion_id'       => $value->accion
                        ,'nota_accion'     => $ponde_eval
                        ,'Ponderacion'     => $value->ponde
                        ,'Ponderacion_Item'=> $pode_sum
                    ]
                );
            }
            if($filascont  == 1){           
                try{
                    $sql=("UPDATE tbl_evalua_grab SET evaluapauta_id='$value->pauta',grabacion_id='$value->audio',atributo_id='$value->atributo',accion_id='$value->accion', nota_accion='$ponde' WHERE evaluagrab_id = '$idgrab';");
                        //log::debug($sql);
                        $ejecucion = $db->statement($sql); 
                        DB::disconnect('db_scj');
                }catch(QueryException $ex){
                    $mensaje = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
                }
            }
        }
        return response()->json(['array'=>$array, 'pauta'=>$pauta, 'audio'=>$audio, 'mes'=>$mes, 'year'=>$year, 'time'=>$time, 'msg'=> $mensaje ]);
    }    


     public function evalcierre()
    {
        
        $usuario=auth()->user()->name;
        $db= DB::connection('mysql');
        try{
            $sql=("CALL cmb_carteras_asig ('$usuario')");
            $cmbasignaciones   = $db->select($sql); 
            DB::disconnect('db_scj');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        return view('system.agente.evalcierre')->with('name',$usuario)
                                               ->with('cmbasignaciones',$cmbasignaciones);
    }


     public function ajaxtraeval(Request $request)
    {
        $array     =[];
        $idagente  = $request->input('idagente');
        $usuario   = auth()->user()->name;
        $db        = DB::connection('mysql');

        try{
            $sql=("SELECT * FROM tbl_grabacion AS GR, tbl_pauta AS PA WHERE agente_id = '$idagente' AND  st_mostrar='S' AND GR.pauta_id = PA.pauta_id;");
            $selectgrab   = $db->select($sql); 
            DB::disconnect('db_scj');
            foreach($selectgrab as $value){
              
                $array[] =  (array) $value;

            }
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
            //return view('home')->withErrors($errors);
        }
     
        //dd($cmbempresas);
        return response()->json(['array' => $array]);

    }

    // public function ajaxevaluatrae(Request $request){
    //     $idaudio    = $request->input('idaudio');
    //     $cartera_id = $request->input('cartera_id');
    //     $usuario    = auth()->user()->name;
        
    //     $db= DB::connection('mysql');
    //     try{
    //         $sql=("SELECT * FROM tbl_cartera AS CA, tbl_pauta AS PA, tbl_pauta_atributo AS AP, tbl_atributo AS TB, tbl_atributo_accion AS AC, tbl_accion AS CC, tbl_evalua_grab AS EG WHERE CA.cartera_id = '$cartera_id' AND PA.id_cartera_dest = CA.cartera_id AND AP.pauta_id = CA.pauta_id AND TB.atributo_id = AP.atributo_id AND AC.atributo_id = TB.atributo_id AND CC.accion_id = AC.accion_id AND EG.accion_id = CC.accion_id;");
    //         $pautajson   = $db->select($sql); 
    //         DB::disconnect('db_scj');
    //     }catch(QueryException $ex){
    //         $pautajson = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
    //     }
    //     //log::debug($sql);
        
    //     return response()->json(['pautajson'=>$pautajson]);
    // }

    public function ejecutacierre(Request $request){

        $idagente     = $request->input('idagente');
        $fecha        = $request->input('fecha');
        $mensaje      = ''; 
        $resp         = 'S';  
        $notasuma     = 0;
        $cont         = 0;  
        $tiempotot    = 0;
        $tmo          = 0;
        $array_cierre = [];
        $usuario      = auth()->user()->name;
        $mes          = date("m");
        $year         = date("Y");    
        $fec_cierre   = implode('',array_reverse(explode('/', $fecha)));
        $observacion  = $request->input('obscierre');
            
            $db        = DB::connection('mysql');   
            try{
                $sql=("SELECT * FROM tbl_grabacion WHERE agente_id = '$idagente' AND st_mostrar = 'S' AND st_evalua = '1';");

                $sqlcierre = $db->select($sql);
                foreach ($sqlcierre as $valuecierre) {  
                    $nota       = $valuecierre->nota;
                    $pauta      = $valuecierre->pauta_id;
                    $tiempototal= $valuecierre->tiempo;
                    $array[]    =  (array) $valuecierre;  

                    $notasuma   = $notasuma+$nota;
                    // $tiempotot  = $tiempotot+$tiempototal;
                    $cont       = $cont+1;
                }    
                $notaconsolida  = $notasuma/$cont;
                // $tmo            = $tiempotot/$cont;
                
                $insert =  $db->table('tbl_evalua_pauta')->insert(
                    [
                         'pauta_id'       => $pauta
                        ,'agente_id'      => $idagente
                        ,'supervisor'     => $usuario
                        ,'fecha_evalua'   => $fec_cierre
                        ,'nota_promedio'  => $notaconsolida
                        ,'tiempo_total'   => $tiempotot
                        ,'tmo'            => $tmo
                        ,'obs_final'      => $observacion
                    ]
                );    
                try{
                    $sql=("UPDATE tbl_grabacion SET st_mostrar='N' WHERE agente_id = '$idagente' AND st_mostrar = 'S' AND st_evalua = '1';");
                    //log::debug($sql);
                    $ejecucion = $db->statement($sql); 
                    DB::disconnect('db_scj');
                }catch(QueryException $ex){
                   $resp    = 'N'; 
                   $mensaje = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger'], 'resp' => $resp ] );    
                }
                DB::disconnect('db_scj');
            }catch(QueryException $ex){
                $resp    = 'N'; 
                $mensaje = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger'], 'resp' => $resp ] );  
            }
        return response()->json(['array'=>$array, 'resp'=>$resp, 'pauta'=>$pauta, 'mes'=>$mes, 'year'=>$year,  'msg'=> $mensaje ]);
    } 

}

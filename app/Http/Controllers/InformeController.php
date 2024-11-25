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
            DB::disconnect('mysql');
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
            DB::disconnect('mysql');
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
        $info_entrega= $request->input('info_entrega');
        $cmb_mes   = $request->cmb_mes;
        $cmb_year  = $request->cmb_year;
        $array     = [];
        $arraynota = [];
        $arraybody = [];
        $informes  = '';
        $informes2 = '';
        $resp      = 'S';
        $h         = 0; 
        // $fech_init = implode('',array_reverse(explode('/', $fech_init)));
        // $fech_fin = implode('',array_reverse(explode('/', $fech_fin)));
         
        $db= DB::connection('mysql');

         

        try{
            $sql=("SELECT * FROM `tbl_grabacion` WHERE agente_id = '$agent_info' AND st_mostrar = 'N' AND mes = '$cmb_mes' AND  year ='$cmb_year' AND num_envio ='$info_entrega' AND st_evalua !=2; ");
            $informes   = $db->select($sql); 
            //log::debug($sql);
            foreach ($informes as $value) {  
                $idgrab     = $value->grabacion_id;
                    
                $sql=("SELECT  PA.rut_cliente, PA.nota, GR.grabacion_id,GR.accion_id,GR.nota_accion,AC.nombre_accion, AC.ponderacion, GR.atributo_id, GR.Ponderacion_Item, PI.nombre_atributo FROM tbl_grabacion AS PA, tbl_evalua_grab AS GR, tbl_accion AS AC, tbl_atributo AS PI WHERE PA.grabacion_id = '$idgrab' AND GR.grabacion_id = '$idgrab' AND AC.accion_id = GR.accion_id AND GR.atributo_id = PI.atributo_id; ");
                $informes2    = $db->select($sql);
                $arraybody[]  =  (array) $informes2;

                log::debug($sql);
            } 
            DB::disconnect('mysql');
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

    public function informesentrega(){
        $usuario=auth()->user()->name;
        $db= DB::connection('mysql');
        try{
            $sql=("CALL cmb_carteras_asig ('$usuario')");
            $cmbasignaciones   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

         return view('system.agente.informe_tabla_entrega')->with('name',$usuario)
                                                   ->with('cmbasignaciones',$cmbasignaciones);

    }

    public function infentrega(Request $request){
        $usuario   =auth()->user()->name;
        $cartera = $request->input('cartera');
        $cmb_mes= $request->input('cmb_mes');
        $cmb_year= $request->input('cmb_year');
       
        $array     = [];
        $arraynota = [];
        $arraybody = [];
       
        // $fech_init = implode('',array_reverse(explode('/', $fech_init)));
        // $fech_fin = implode('',array_reverse(explode('/', $fech_fin)));
         
        $db= DB::connection('mysql');

         

        try{
            $sql=("SELECT * FROM `inf_promedio` WHERE cartera = '$agent_info' AND st_mostrar = 'N' AND fecha_evaluacion BETWEEN '$fech_init' and '$fech_fin';");
            $informes   = $db->select($sql); 
            //log::debug($sql.'aqui1');
            foreach ($informes as $value) {  
                $idgrab     = $value->grabacion_id;
                    
                $sql=("SELECT  PA.rut_cliente, PA.nota, GR.grabacion_id,GR.accion_id,GR.nota_accion,AC.nombre_accion, AC.ponderacion, GR.atributo_id, GR.Ponderacion_Item, PI.nombre_atributo FROM tbl_grabacion AS PA, tbl_evalua_grab AS GR, tbl_accion AS AC, tbl_atributo AS PI WHERE PA.grabacion_id = '$idgrab' AND GR.grabacion_id = '$idgrab' AND AC.accion_id = GR.accion_id AND GR.atributo_id = PI.atributo_id; ");
                $informes2    = $db->select($sql);
                $arraybody[]  =  (array) $informes2;
            } 
 
            DB::disconnect('mysql');
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



    public function ajaxinfcartera(Request $request){
        $info_agente = $request->input('info_agente');
        $usuario = auth()->user()->name;
        
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT DISTINCT num_envio FROM tbl_grabacion WHERE agente_id = $info_agente AND st_mostrar = 'N' AND st_evalua = '1' ORDER BY num_envio;");
            $cmbentrega   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $cmbentrega = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        
        return response()->json(['cmbentrega'=>$cmbentrega]);
    }

    public function ajaxinformeentr(Request $request){
        $usuario        =auth()->user()->name;
        $carteraent     = $request->input('carteraent');
        $cmb_mes_ent    = $request->input('cmb_mes_ent');
        $cmb_year_ent   = $request->input('cmb_year_ent');
        $array          = [];
        $count          = 0;
               
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT PM.agente_id, PM.audio_id, PM.cartera_id, PM.nota_promedio, PM.entrega, PM.mes, PM.year, AG.nombre_agente FROM tbl_evalua_pauta AS PM, tbl_agente AS AG WHERE PM.cartera_id = '$carteraent' AND PM.mes = '$cmb_mes_ent' AND PM.year = '$cmb_year_ent' AND AG.agente_id = PM.agente_id ORDER BY nombre_agente,entrega;");

            $ejecucion = $db->select($sql);
            foreach ($ejecucion as $val) {  
                $agente         = $val->agente_id;
                $grabacion      = $val->audio_id;
                $cartera_id     = $val->cartera_id;
                $nota           = $val->nota_promedio;
                $entrega        = $val->entrega;
                $mes            = $val->mes;
                $year           = $val->year;
                $nombre_agente  = $val->nombre_agente;

                $array[]    =  (array) $val;
                $count++;
            }

            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        if($count == 0){
            $resp = 'N';
        }else{
            $resp = 'S';
        }

        return response()->json(['array'=>$array, 'resp'=>$resp]);
    }



    public function informesgneral(Request $request){
        $usuario=auth()->user()->name;
        $db= DB::connection('mysql');
        try{
            $sql=("CALL cmb_carteras_asig ('$usuario')");
            $cmbasignaciones   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

         return view('system.agente.informe_tabla_promediogeneral')->with('name',$usuario)
                                                   ->with('cmbasignaciones',$cmbasignaciones);
    }

     


    public function ajaxinformegral(Request $request){
        $usuario         =auth()->user()->name;
        $carteragral     = $request->input('carteragral');
        $cmb_mes_gral    = $request->input('cmb_mes_gral');
        $cmb_year_gral   = $request->input('cmb_year_gral');
        $array           = [];
        $count           = 0;
               
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT PM.agente, PM.grabacion, PM.cartera_id, PM.nota, PM.periodo, PM.mes, PM.year, AG.nombre_agente FROM inf_promedio AS PM, tbl_agente AS AG WHERE PM.cartera_id = '$carteragral' AND PM.mes = '$cmb_mes_gral' AND PM.year = '$cmb_year_gral' AND AG.agente_id = PM.agente ORDER BY AG.nombre_agente,PM.periodo;");
log::debug($sql);
            $ejecucion = $db->select($sql);
            foreach ($ejecucion as $val) {  
                $agente         = $val->agente;
                $grabacion      = $val->grabacion;
                $cartera_id     = $val->cartera_id;
                $nota           = $val->nota;
                $entrega        = $val->periodo;
                $mes            = $val->mes;
                $year           = $val->year;
                $nombre_agente  = $val->nombre_agente;

                $array[]    =  (array) $val;
                $count++;
            }


            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        if($count == 0){
            $resp = 'N';
        }else{
            $resp = 'S';
        }

        return response()->json(['array'=>$array, 'resp'=>$resp]);
    }


    public function informeanual(Request $request){
        $usuario=auth()->user()->name;
        $db= DB::connection('mysql');
        try{
            $sql=("CALL cmb_carteras_asig ('$usuario')");
            $cmbasignaciones   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

         return view('system.agente.informe_anual')->with('name',$usuario)
                                                   ->with('cmbasignaciones',$cmbasignaciones);
    }
    
    public function ajaxagenteinfoanual(Request $request){
            $usuario        =auth()->user()->name;
            $carteraent     = $request->input('carteraent');
            $cmb_year_ent   = $request->input('cmb_year_ent');
            $array          = [];
            $count          = 0;
               
            $db= DB::connection('mysql');
                try{
                    $sql=("SELECT * FROM inf_anual AS IA, tbl_agente AS AG WHERE IA.cedente = '$carteraent' AND IA.year = '$cmb_year_ent' AND AG.agente_id = IA.agente;");
            log::debug($sql);
            
            $ejecucion = $db->select($sql);
            $meses = [
                        1 => 'Enero',
                        2 => 'Febrero',
                        3 => 'Marzo',
                        4 => 'Abril',
                        5 => 'Mayo',
                        6 => 'Junio',
                        7 => 'Julio',
                        8 => 'Agosto',
                        9 => 'Septiembre',
                        10 => 'Octubre',
                        11 => 'Noviembre',
                        12 => 'Diciembre',
                    ];
                    
            foreach ($ejecucion as $val) {  
                $cedente        = $val->cedente;
                $agente         = $val->agente;
                $promedio       = $val->promedio;
                $mes            = $val->mes;
                $year           = $val->year;
                

                $array[]    =  (array) $val;
                $count++;
            }

            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }
        

        return response()->json(['ejecucion'=>$array, 'ejecu2' =>$ejecucion]);
    }

}
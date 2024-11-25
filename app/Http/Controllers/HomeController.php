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


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countage = 0; 
        $usuario  = auth()->user()->name;

        $db= DB::connection('mysql');
        try{
            $sql =("SELECT count(*) as CTA from tbl_empresas");
            $emp = $db->select($sql); 
            $emp = $emp[0]->CTA;
            

            $sql =("SELECT count(*) as CTA from tbl_cartera AS CA, tbl_asignacion AS AG where CA.cartera_id = AG.cartera_id AND AG.nombre_usuario ='$usuario'");
            $car = $db->select($sql); 
            $car = $car[0]->CTA;           

            $sql=("SELECT count(*) as CTA from tbl_agente as AG, users AS US where US.name = '$usuario' and US.id_cartera = AG.cartera_id;");
            $agente = $db->select($sql); 
            $age = $agente[0]->CTA;

            $sql=("SELECT count(*) as CTA from tbl_pauta;");
            $pauta = $db->select($sql); 
            $pau = $pauta[0]->CTA;
           
            DB::disconnect('mysql'); 
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
            return view('home')->with('name',0)
                               ->with('age',0)
                               ->with('emp',0)
                               ->with('car',0)
                               ->with('pau',0);
        }

        //dd($datos);
        return view('home')->with('name',$usuario)
                           ->with('age',$age)
                           ->with('emp',$emp)
                           ->with('car',$car)
                           ->with('pau',$pau);

             
    }


     public function empresastbl()
    {
        $arrays      =[];
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM `tbl_empresas` as EM, tbl_pais as PS Where EM.pais_id = PS.pais_id;");
            $cmbempresas   = $db->select($sql); 
            DB::disconnect('mysql');
            foreach($cmbempresas as $value){
                $value->rutEmpresa;
                $value->nombre_empresa ;
                $value->nombre_pais;
                $value->nomenclatura;
                $arrays[] =  (array) $value;
            }
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
            //return view('home')->withErrors($errors);
        }
     
        //dd($cmbempresas);
        return response()->json(['arrays' => $arrays]);
    }


    public function carterastbl()
    {
        $usuario  = auth()->user()->name;    
        $arrays   = [];
        $db       = DB::connection('mysql');
        try{
            $sql=("SELECT * FROM `tbl_cartera` AS CA, tbl_pais AS AP, tbl_pauta AS PA, tbl_empresas AS EM, tbl_asignacion AS AG where PA.pauta_id = CA.pauta_id AND CA.empresa_id = EM.empresa_id AND AG.nombre_usuario = '$usuario' AND AG.cartera_id = CA.cartera_id;");
            $cmbcarteras   = $db->select($sql); 
            DB::disconnect('mysql');
            foreach($cmbcarteras as $value){
                
                $arrays[] =  (array) $value;
    }
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
            //return view('home')->withErrors($errors);
        }
     
        
        return response()->json(['arrays' => $arrays]);
    }
   
public function evaluadorestbl()
    {
        $arrays      =[];
        $usuario=auth()->user()->name;
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT US.id_cartera, AG.nombre_agente, CA.nombre_cartera FROM `users` AS US, tbl_agente AS AG, tbl_cartera AS CA WHERE US.name = '$usuario' AND AG.cartera_id = US.id_cartera AND CA.cartera_id = AG.cartera_id;");
            $cmbeval   = $db->select($sql); 
            DB::disconnect('mysql');
            foreach($cmbeval as $value){
                $arrays[] =  (array) $value;
    }
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
            //return view('home')->withErrors($errors);
        }
     
        //dd($cmbempresas);
        return response()->json(['arrays' => $arrays]);
    }

public function audiostbl()
    {
        $arrays      =[];
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM tbl_pauta;");
            $cmbaudios   = $db->select($sql); 
            DB::disconnect('mysql');
            foreach($cmbaudios as $value){
                $value->nombre_pauta;
                $value->descripcion;
                $value->vigen_pauta;
                $arrays[] =  (array) $value;

            }
        }catch(QueryException $ex){
            $errors = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
            //return view('home')->withErrors($errors);
        }
     
        //dd($cmbempresas);
        return response()->json(['arrays' => $arrays]);
    }



}

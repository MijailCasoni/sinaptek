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
    public function cmbEmpresas()
    {
        $db= DB::connection('mysql');
        try{
            $sql=("SELECT * FROM `tbl_empresas` WHERE 1;");
            $cmbEmpresas   = $db->select($sql); 
            DB::disconnect('mysql');
        }catch(QueryException $ex){
            $cmbEmpresas = new MessageBag(['aviso_g' => ["error."] ,'aviso_tipo'=>['alert-danger']] );    
        }

        return response()->json(['cmbEmpresas' => $cmbEmpresas]);
    }

    
   




} 
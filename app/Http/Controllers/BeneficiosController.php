<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Validator;
use Log;

class BeneficiosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAplicados(Request $request)
    {
        
            $validator = Validator::make($request->all(), [
                'cuenta' => 'required|min:12|max:12',
            ]);

            $authToken = $request->header('Authorization');
            try{
                $auth = Crypt::decrypt($authToken);
            }catch(\Throwable $th){
                return response()->json(['mensaje' => 'Se requiere el token de autorización'], 403);
            }
            
            if(!$auth['logged']){
                return response()->json(['mensaje' => 'No tiene permisos para acceder a la API'], 403);
            }

            if ($validator->fails()) {
                return response()->json(['mensaje' => 'Fallo en la petición, la cuenta es requerida con 12 caracteres.'], 400);
            }
            $cuenta = $request->input('cuenta');
            $rfc = $request->input('rfc') ? $request->input('rfc') : '';
            $curp = $request->input('curp') ? $request->input('curp') : '';
            $mensaje = '';


            try {
                $beneficios = DB::connection('ws')->transaction(function($conn) use ($cuenta,$rfc,$curp,$mensaje){
                    $procedure = 'BEGIN 
                    fis.fis_consultas_ws.fis_obt_beneficios_aplicados_p(
                        :par_cuenta,
                        :par_curp,
                        :par_rfc,
                        :par_cursor,
                        :par_mensaje); 
                    END;';
        
                    $cursor = null;
                    $pdo = DB::connection('ws')->getPdo();
                    $stmt = $pdo->prepare($procedure);
                   
                    $stmt->bindParam(':par_cuenta', $cuenta,\PDO::PARAM_STR,20);
                    $stmt->bindParam(':par_curp', $curp,\PDO::PARAM_STR,20);
                    $stmt->bindParam(':par_rfc', $rfc,\PDO::PARAM_STR,15);
                    $stmt->bindParam(':par_cursor', $cursor,\PDO::PARAM_STMT);
                    $stmt->bindParam(':par_mensaje', $mensaje, \PDO::PARAM_STR ,100);
                    $stmt->execute();
                    oci_execute($cursor, OCI_DEFAULT);
                    oci_fetch_all($cursor, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC );
                    oci_free_cursor($cursor);
                    return $array;
                });

            if (!empty($beneficios)) {
                return response()->json(['respuesta' => $beneficios, 'mensaje' => $mensaje, 'estatus' => true], 200);
            } else {
                return response()->json(['respuesta' => [] ,'mensaje' => $mensaje, 'estatus' => false], 404);
            }
        } catch (\Throwable $th) {
            error_log($th);
            Log::info($th);
            return response()->json(['mensaje' => 'Error en el servidor'], 500);
        }
    }
}

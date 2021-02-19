<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;

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

        //$authToken = $request->header('Authorization');
        if ($validator->fails()) {
            return response()->json(['mensaje' => 'Fallo en la petición, la cuenta es requerida con 12 caracteres.'], 400);
        }
        $cuenta = $request->input('cuenta');
        $rfc = $request->input('rfc') ? $request->input('rfc'): '';
        $curp = $request->input('curp') ? $request->input('curp'): '';
        $mensaje = '';

        try {
            
            $procedure = 'BEGIN 
            fis.fis_consultas_ws.fis_obt_beneficios_aplicados_p(
                :par_cuenta,
                :par_curp,
                :par_rfc,
                :par_cursor,
                :par_mensaje); 
            END;';

            $conn = oci_connect(env("DB_USERNAME_PRECAT"), env("DB_PASSWORD_PRECAT"), env("DB_TNS_PRECAT"));

            $stmt = oci_parse($conn, $procedure);
            oci_bind_by_name($stmt, ':par_cuenta', $cuenta);
            oci_bind_by_name($stmt, ':par_curp', $curp);
            oci_bind_by_name($stmt, ':par_rfc', $rfc);
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ":par_cursor", $cursor, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':par_mensaje', $mensaje, 4000);
            oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
            oci_execute($cursor, OCI_COMMIT_ON_SUCCESS);
            oci_free_statement($stmt);
            oci_close($conn);
            oci_fetch_all($cursor, $beneficios, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($cursor);
           
            if(!empty($beneficios)){
                return response()->json($beneficios[0], 200);
            }else{
                return response()->json(['mensaje' => $mensaje], 404);
            }
        } catch (\Throwable $th) {
            error_log($th);
            return response()->json(['mensaje' => 'Error en el servidor'], 500);
        }
    }
}

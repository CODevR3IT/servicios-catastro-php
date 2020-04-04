<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiprediController extends Controller
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

    public function show($registro)
    {
        try {
            $sql = 'CALL RCON.RCON_SIPREDI_PERITO_VALIDACION(:p1,:ret)';

            $res = DB::transaction(function ($conn) use ($sql, $registro) {
                
                $pdo = $conn->getPdo();
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':p1', $registro);
                $stmt->bindParam(':ret', $lista, \PDO::PARAM_STMT);

                $stmt->execute();
                oci_execute($lista, OCI_DEFAULT);
                oci_fetch_all($lista, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
                oci_free_cursor($lista);
                return $array;
            });
            
            if(count($res) > 0){
                return response()->json([
                    'valido' => true,
                    'nombre' => $res[0]['NOMBRE'],
                    'rfc' => $res[0]['RFC']
                ], 200);
            }else{
                return response()->json([
                    'valido' => false,
                    'nombre' => '',
                    'rfc' => ''
                ], 200);
            }
        } catch (\Throwable $th) {
            dd($th);   
            return response()->json(['mensaje' => 'Error en el servidor'], 500);
        }
    }

    //
}

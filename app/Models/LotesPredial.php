<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Log;

class LotesPredial
{
    public function __construct()
    {
    }

    public function cargaVencidos($codError, $file, $folio, $mensaje, $idFile)
    {     
        $procedure = 'BEGIN
        FIS.FIS_METODOSV_PKG.FIS_ADEUDOSVENCIDOS_LOAD_P(
            :P_ARCHIVO,
            :P_FOLIO,
            :P_IDARCHIVO,
            :P_MENSAJE,
            :P_CODRET
        ); END;';        
        $conn = oci_connect(env("DB_USERNAME"),env("DB_PASSWORD"),env("DB_TNS"));        
        $stmt = oci_parse($conn,$procedure);
        // Creates an "empty" OCI-Lob object to bind to the locator
        $myLOB = oci_new_descriptor($conn, OCI_D_LOB);
        
        //oci_bind_by_name($stmt, ":P_ARCHIVO", $myLOB, -1, OCI_B_CLOB);
        oci_bind_by_name($stmt, ":P_ARCHIVO", $file, -1);        
        oci_bind_by_name($stmt,':P_FOLIO',$folio,-1);
        oci_bind_by_name($stmt,':P_IDARCHIVO',$p_idarchivo,300);
        oci_bind_by_name($stmt,':P_MENSAJE',$p_mensaje,300);
        oci_bind_by_name($stmt,':P_CODRET',$p_codret,300);
        
        //oci_bind_by_name($stmt,':P_CODRET',$cursor,-1,OCI_B_CURSOR);                          
        oci_execute($stmt,OCI_DEFAULT);
        //$clob->save($file); 
        oci_commit($conn);
        oci_free_statement($stmt);
        oci_close($conn);
        $respuestaVencido = [
            'CodError' => $p_codret,
            'File' => '',
            'Folio' => $folio,
            'Mensaje' => $p_mensaje,
            'idFile' => $p_idarchivo
        ];
        return $respuestaVencido;
        
        //oci_execute($cursor,OCI_COMMIT_ON_SUCCESS);
        
        /*oci_fetch_all($stmt, $respuesta, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        oci_free_statement($stmt);
        oci_close($conn);
        
        if (count($respuesta) > 0) {
            return $respuesta[0];
        } else {
            return [];
        } */         
    }

    public function cargaVigentes($codError, $file, $folio, $mensaje, $idFile)
    {     
        $procedure = 'BEGIN
        FIS.FIS_METODOSN_PKG.FIS_ADEUDOSVIGENTES_LOAD_P(
            :P_ARCHIVO,
            :P_FOLIO,
            :P_IDARCHIVO,
            :P_MENSAJE,
            :P_CODRET
        ); END;';        
        $conn = oci_connect(env("DB_USERNAME"),env("DB_PASSWORD"),env("DB_TNS"));        
        $stmt = oci_parse($conn,$procedure);
        // Creates an "empty" OCI-Lob object to bind to the locator
        $myLOB = oci_new_descriptor($conn, OCI_D_LOB);
        
        //oci_bind_by_name($stmt, ":P_ARCHIVO", $myLOB, -1, OCI_B_CLOB);
        oci_bind_by_name($stmt, ":P_ARCHIVO", $file, -1);        
        oci_bind_by_name($stmt,':P_FOLIO',$folio,-1);
        oci_bind_by_name($stmt,':P_IDARCHIVO',$p_idarchivo,300);
        oci_bind_by_name($stmt,':P_MENSAJE',$p_mensaje,300);
        oci_bind_by_name($stmt,':P_CODRET',$p_codret,300);
        
        //oci_bind_by_name($stmt,':P_CODRET',$cursor,-1,OCI_B_CURSOR);                          
        oci_execute($stmt,OCI_DEFAULT);
        //$clob->save($file); 
        oci_commit($conn);
        oci_free_statement($stmt);
        oci_close($conn);
        $respuestaVigente = [
            'CodError' => $p_codret,
            'File' => '',
            'Folio' => $folio,
            'Mensaje' => $p_mensaje,
            'idFile' => $p_idarchivo
        ];
        return $respuestaVigente;   
               
    }

    public function cargaAnticipados($codError, $file, $folio, $mensaje, $idFile)
    {     
        $procedure = 'BEGIN
        FIS.FIS_METODOSA_PKG.FIS_PAGOANTICIPADO_LOAD_P(
            :P_ARCHIVO,
            :P_FOLIO,
            :P_IDARCHIVO,
            :P_MENSAJE,
            :P_CODRET
        ); END;';        
        $conn = oci_connect(env("DB_USERNAME"),env("DB_PASSWORD"),env("DB_TNS"));        
        $stmt = oci_parse($conn,$procedure);
        // Creates an "empty" OCI-Lob object to bind to the locator
        $myLOB = oci_new_descriptor($conn, OCI_D_LOB);
        
        //oci_bind_by_name($stmt, ":P_ARCHIVO", $myLOB, -1, OCI_B_CLOB);
        oci_bind_by_name($stmt, ":P_ARCHIVO", $file, -1);        
        oci_bind_by_name($stmt,':P_FOLIO',$folio,-1);
        oci_bind_by_name($stmt,':P_IDARCHIVO',$p_idarchivo,300);
        oci_bind_by_name($stmt,':P_MENSAJE',$p_mensaje,300);
        oci_bind_by_name($stmt,':P_CODRET',$p_codret,300);
        
        //oci_bind_by_name($stmt,':P_CODRET',$cursor,-1,OCI_B_CURSOR);                          
        oci_execute($stmt,OCI_DEFAULT);
        //$clob->save($file); 
        oci_commit($conn);
        oci_free_statement($stmt);
        oci_close($conn);
        $respuestaAnticipado = [
            'CodError' => $p_codret,
            'File' => '',
            'Folio' => $folio,
            'Mensaje' => $p_mensaje,
            'idFile' => $p_idarchivo
        ];
        return $respuestaAnticipado;   
               
    }
    
}
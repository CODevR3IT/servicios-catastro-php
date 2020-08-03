<?php

use App\Models\LotesPredial;

function ProcesaVencidos($codError, $file, $folio, $mensaje, $idFile)
{    
    try {      
        $mensajeError = '';
        $modelLotesPredial = new LotesPredial();        
        $resultadoCarga = $modelLotesPredial->cargaVencidos($codError, $file, $folio, $mensaje, $idFile);
        /*$respuesta = [
            'CodError' => $codError,
            'File' => $file,
            'Folio' => $folio,
            'Mensaje' => $mensaje,
            'idFile' => $idFile
        ]; 
        return $respuesta;  */
        if($resultadoCarga['Mensaje'] != "CARGA EXITOSA DEL ARCHIVO"){
            $mensajeError = $resultadoCarga['Mensaje'];
        }        
        
        if ($mensajeError == '') {
            // return response()->json($adeudos, 200);
            $respuesta = $resultadoCarga;

            return $respuesta;
        } else {
            $respuesta = [
                'File' => '',
                'Folio' => '',
                'Mensaje' => $mensajeError,
                'idFile' => ''
            ];
            return $respuesta;
        }
    } catch (\Throwable $th) {
        error_log($th);
        $respuesta = [
            'File' => '',
            'Folio' => '',
            'Mensaje' => 'Error de Ejecucion',
            'idFile' => ''
        ];
        return $respuesta;
    }
}

function ProcesaVigentes($codError, $file, $folio, $mensaje, $idFile)
{    
    try {      
        $mensajeError = '';
        $modelLotesPredial = new LotesPredial();        
        $resultadoCarga = $modelLotesPredial->cargaVigentes($codError, $file, $folio, $mensaje, $idFile);
        
        if($resultadoCarga['Mensaje'] != "CARGA EXITOSA DEL ARCHIVO"){
            $mensajeError = $resultadoCarga['Mensaje'];
        }        
        
        if ($mensajeError == '') {
            // return response()->json($adeudos, 200);
            $respuesta = $resultadoCarga;

            return $respuesta;
        } else {
            $respuesta = [
                'File' => '',
                'Folio' => '',
                'Mensaje' => $mensajeError,
                'idFile' => ''
            ];
            return $respuesta;
        }
    } catch (\Throwable $th) {
        error_log($th);
        $respuesta = [
            'File' => '',
            'Folio' => '',
            'Mensaje' => 'Error de Ejecucion',
            'idFile' => ''
        ];
        return $respuesta;
    }
}

function ProcesaAnticipados($codError, $file, $folio, $mensaje, $idFile)
{    
    try {      
        $mensajeError = '';
        $modelLotesPredial = new LotesPredial();        
        $resultadoCarga = $modelLotesPredial->cargaAnticipados($codError, $file, $folio, $mensaje, $idFile);
        
        if($resultadoCarga['Mensaje'] != "CARGA EXITOSA DEL ARCHIVO"){
            $mensajeError = $resultadoCarga['Mensaje'];
        }        
        
        if ($mensajeError == '') {
            $respuesta = $resultadoCarga;

            return $respuesta;
        } else {
            $respuesta = [
                'File' => '',
                'Folio' => '',
                'Mensaje' => $mensajeError,
                'idFile' => ''
            ];
            return $respuesta;
        }
    } catch (\Throwable $th) {
        error_log($th);
        $respuesta = [
            'File' => '',
            'Folio' => '',
            'Mensaje' => 'Error de Ejecucion',
            'idFile' => ''
        ];
        return $respuesta;
    }
}
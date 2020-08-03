<?php

namespace App\Http\Controllers;


class LotesPredialController extends Controller
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

    public function server()
    {
        $server = new \nusoap_server();

        $server->configureWSDL('MasivoService', false, url('PRO/Fiscal/Lotes/MasivoService'));
          
        $server->register(
            'ProcesaVencidos',
            [
                'CodError' => 'xsd:int',
                'File' => 'xsd:base64Binary',
                'Folio' => 'xsd:string',
                'Mensaje' => 'xsd:string',
                'idFile' => 'xsd:int'
            ],
            [
                'CodError' => 'xsd:int',
                'File' => 'xsd:base64Binary',
                'Folio' => 'xsd:string',
                'Mensaje' => 'xsd:string',
                'idFile' => 'xsd:int'
            ]
        );
        
        $server->register(
            'ProcesaVigentes',
            [
                'CodError' => 'xsd:int',
                'File' => 'xsd:base64Binary',
                'Folio' => 'xsd:string',
                'Mensaje' => 'xsd:string',
                'idFile' => 'xsd:int'
            ],
            [
                'CodError' => 'xsd:int',
                'File' => 'xsd:base64Binary',
                'Folio' => 'xsd:string',
                'Mensaje' => 'xsd:string',
                'idFile' => 'xsd:int'
            ]
        );

        $server->register(
            'ProcesaAnticipados',
            [
                'CodError' => 'xsd:int',
                'File' => 'xsd:base64Binary',
                'Folio' => 'xsd:string',
                'Mensaje' => 'xsd:string',
                'idFile' => 'xsd:int'
            ],
            [
                'CodError' => 'xsd:int',
                'File' => 'xsd:base64Binary',
                'Folio' => 'xsd:string',
                'Mensaje' => 'xsd:string',
                'idFile' => 'xsd:int'
            ]
        );

        
        $rawPostData = file_get_contents("php://input");
        return response($server->service($rawPostData), 200, ['Content-Type' => 'text/xml; charset=ISO-8859-1']);
    }
}
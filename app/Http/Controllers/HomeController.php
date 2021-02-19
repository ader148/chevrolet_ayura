<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;

class HomeController extends Controller
{
    private $vehiculos;
    private $sedes;
    private $servicios;

    public function __construct(IClientMethod $clientMethod = null)
    {
        $this->sedes = $this->getAllSedes();
        $this->vehiculos = $this->getAllVehicles();
        $this->servicios = $this->getAllServices();
    }

    public function index()
    {
        
        $vehiculos = $this->vehiculos;
        $sedes = $this->sedes;
        $servicios = $this->servicios;

        return view('layouts/app', compact(['vehiculos', 'sedes', 'servicios']));
    }

    public function getHeaders()
    {
        $data = [
            'Content-Type' => 'application/json',
        ];
        return $data;
    }

    /**
     * [Obtener todos los vehiculos]
     * @return [array]
     */
    public function getAllVehicles()
    {
        try {
            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_vehiculos';

            $response = $client->get($endpoint);

            $data = json_decode($response->getBody());

            $vehicles = [];
            foreach ($data as $vehicle) {
                $vehicles[$vehicle->_ID] = $vehicle->title;
            }

            return $vehicles;
            
        } catch (Exception $e) {
            //buscar como registrar el error
            return [];
        }  
    }

    /**
     * [getVehicle Obtener datos de un vechiculo por id]
     * @param  [int] $id_vehicle [id del vehiculo]
     * @return [json]   [datos de un vehiculo]
     */
    public function getVehicle($id_vehicle)
    {
        try {
            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_vehiculos/'.$id_vehicle;

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());

            return response()->json($body, 200);
            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }

    /**
     * [getAllSedes Obtener todas las sedes]
     * @return [array]
     */
    public function getAllSedes()
    {
        try {
            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_sedes';

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());
            
            $sedes = [];
            foreach ($body as $sede) {
                $sedes[$sede->_ID] = [
                    'name' => $sede->title,
                    'dias' => $sede->dias_disponibles,
                    'horario' => $this->getHorario($sede)
                ];
            }
            return $sedes;
            
        } catch (Exception $e) {
            return [];
        }  
    }

    /**
     * [getSede Obtener una sede por id]
     * @param  [int] $id_sede [Id de la sede]
     * @return [json]         [Datos de una sede]
     */
    public function getSede($id_sede)
    {
        try {
            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_sedes/'.$id_sede;

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());

            return response()->json($body, 200);
            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }

    /**
     * [getAllServices Obtener todas los servicios]
     * @return [array]
     */
    public function getAllServices()
    {
        try {
            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_servicios';

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());

            $servicios = [];
            foreach ($body as $servicio) {
                $servicios[$servicio->_ID] = $servicio->title;
            }

            return $servicios;
            
        } catch (Exception $e) {
            return [];
        }    
    }

    /**
     * [getService Obtener un servicio por id]
     * @param  [int] $id_service [Id del servicio]
     * @return [json]         [Datos de un servicio]
     */
    public function getService($id_service)
    {
        try {
            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_servicios'.$id_service;

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());

            return response()->json($body, 200);
            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }

    /**
     * [getAllReservations Obtener todas las reservaciones]
     * @return [array]
     */
    public function getAllReservations()
    {
        try {
            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_reservas';

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());

            return response()->json($body, 200);
            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * [getReservation Obtener una reservacion por id]
     * @param  [int] $id_reservation [Id de la reservacion]
     * @return [json]         [Datos de una reservacion]
     */
    public function getReservation($id_reservation)
    {
        try {
            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_reservas/'.$id_reservation;

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());

            return response()->json($body, 200);
            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }

    public function storeReservation(Request $request)
    {   
        try {
            $now = Carbon::now();
            $data = $request->all();
            
            $credenciales = env('WP_USER').':'.env('WP_PASSWORD');
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic '. base64_encode($credenciales)
                ]
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_reservas';

            $body = [
                'fecha_y_hora'  => $now->format('Y-m-d H:i:s'),
                'id_sede'       => $data['sede'],
                'id_servicio'   => $data['servicio'],
                'id_vehiculo'   => $data['vehiculo'], 
                'cct_author_id' => $data['nombre'],
                'placa'         => $data['placa'],
                'cct_created'   => $now->format('Y-m-d H:i:s')
            ];


            $response = $client->post($endpoint,
                ['body' =>  json_encode($body) ]
            );

            $result = json_decode($response->getBody());

            return redirect('/')->with('success','Registro Exitoso');

            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getHorario($sede)
    {
        $horasDisponibles = [];

        if ($sede->sede_con_horario_continuo == 'true') {
            
            $inicio = explode(":",$sede->hora_de_apertura_horario_continuo);
            $fin = explode(":",$sede->hora_de_cierre_horario_continuo);

            for ($hora = $inicio[0]; $hora < $fin[0] ; $hora++) { 
                array_push($horasDisponibles, $hora.':00');
            }
        }else{
            
            $inicioManana = explode(":",$sede->hora_de_apertura_manana);
            $finManana = explode(":",$sede->hora_de_cierre_manana);

            $inicioTarde = explode(":",$sede->hora_de_apertura_tarde);
            $finTarde = explode(":",$sede->hora_de_cierre_tarde);


            for ($horaManana = $inicioManana[0]; $horaManana < $finManana[0] ; $horaManana++) { 
                array_push($horasDisponibles, $horaManana.':00');
            }

            for ($horaTarde = $inicioTarde[0]; $horaTarde < $finTarde[0] ; $horaTarde++) { 
                array_push($horasDisponibles, $horaTarde.':00');
            }
        }

        return $horasDisponibles;
    }

}

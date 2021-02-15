<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;

class HomeController extends Controller
{
    public function getHeaders()
    {
        $data = [
            'Content-Type' => 'application/json',
        ];
        return $data;
    }

    public function index()
    {
    	$client = new Client([
            'headers' => $this->getHeaders()
        ]);

        $endpoint= 'http://ecommerce.test/api/v1/authenticate';

        $body = '{ "username": "root", "password": "root12345678" }';

        $response = $client->post($endpoint,
            ['body' => $body ]
        );

        $result = json_decode($response->getBody());
        
    	return view('welcome');
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

            $body = json_decode($response->getBody());

            return response()->json($body, 200);
            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
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

            return response()->json($body, 200);
            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
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

            return response()->json($body, 200);
            
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
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

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_servicios/'.$id_service;

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
           
           $credenciales = 'zeroadmin:DhTm Ssn3 sLAi UCVK DAuS 16UN';
           $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic '. base64_encode($credenciales)
                 ]
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_reservas';

            $body = [
                'fecha_y_hora' => '2021-02-15 21:00:00',
                'id_sede' => 5,
                'id_servicio' => 1,
                'id_vehiculo' => 1, 
                'cct_author_id' => 'test',
                'cct_created' => '2021-02-15 21:00:00'
            ];


            $response = $client->post($endpoint,
                ['body' =>  json_encode($body) ]
            );

            $result = json_decode($response->getBody());
        
            return response()->json($body, 200);
            
        } catch (Exception $e) {
            dd('error' , $e->getMessage());
            return response()->json($e->getMessage(), 500);
        }

    }

}

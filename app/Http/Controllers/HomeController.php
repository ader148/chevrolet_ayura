<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\mensajeReservacion;
use App\Mail\Reservation;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;
use DateTime;

class HomeController extends Controller
{
    public function index()
    {
        $sedes = $this->getAllSedes();
        $vehiculos = $this->getAllVehicles();
        $servicios = $this->getAllServices();

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

            return $body->title;
            
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
                    'name' => $sede->title
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

            $sede = [
                'name' => $body->title,
                'dias' => $body->dias_disponibles,
                'horario' => $this->getHorario($body)
            ];

            return $sede;
            
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

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_servicios/'.$id_service;

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());

            return $body->title;

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
                'fecha_y_hora'  => $data['fecha'],
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

            if ($result->success) {
                $vehiculo = $this->getVehicle($data['vehiculo']);
                $sede = $this->getSede($data['sede']);
                $servicio = $this->getService($data['servicio']);

                $correo['cliente'] = $data['nombre'];
                $correo['tlf'] = $data['phone']; 
                $correo['vehiculo'] = $vehiculo;
                $correo['placa'] = $data['placa'];
                $correo['sede'] = $sede['name'];
                $correo['servicio'] = $servicio;
                $correo['fecha'] = $data['fecha'];

                Mail::to(['box1488@gmail.com', 'ader1481@gmail.com'])->send(new Reservation($correo));

                return redirect('/')->with('success','Registro Exitoso');
            }
            return back()->with('error','Error inesperado inténtelo de nuevo');
        } catch (Exception $e) {
            dd($e->getMessage());
            return back()->with('error','Error inesperado inténtelo de nuevo');
        }
    }

    public function getHoursAvailableBySede($id_sede, $fecha)
    {
        try {

            $horarios = [];
            $date = new Carbon($fecha); 
            $date->locale('es'); 
            $sede = $this->getSede($id_sede);
            
            if (!in_array($date->isoFormat('dddd'), $sede['dias'])) {
                return response()->json([], 200);
            }

            $client = new Client([
                'headers' => $this->getHeaders()
            ]);

            $endpoint= 'https://experiencia.ayuramotorchevrolet.co/wp-json/jet-cct/citas_reservas?id_sede='.$id_sede;

            $response = $client->get($endpoint);

            $body = json_decode($response->getBody());

            foreach ($body as $reservacion) {                
                $dt = new DateTime("@$reservacion->fecha_y_hora");  
                $fechaReservacion = $dt->format('Y-m-d');
                
                if ($fechaReservacion == $fecha) {
                 unset($sede['horario'][(int)$dt->format('H')]);
             }
         }

         return response()->json($sede['horario'], 200);

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
            $numeroHora = (int)($hora);
            $hour = ($numeroHora < 10) ? '0'.$numeroHora.':00' : $numeroHora.':00' ;
            $horasDisponibles[$numeroHora] = $hour;
        }
    }else{

        $inicioManana = explode(":",$sede->hora_de_apertura_manana);
        $finManana = explode(":",$sede->hora_de_cierre_manana);

        $inicioTarde = explode(":",$sede->hora_de_apertura_tarde);
        $finTarde = explode(":",$sede->hora_de_cierre_tarde);


        for ($horaManana = $inicioManana[0]; $horaManana < $finManana[0] ; $horaManana++) { 
            $numeroHora = (int)($horaManana);
            $hour = ($numeroHora < 10) ? '0'.$numeroHora.':00' : $numeroHora.':00' ;
            $horasDisponibles[$numeroHora] = $hour;
        }

        for ($horaTarde = $inicioTarde[0]; $horaTarde < $finTarde[0] ; $horaTarde++) { 
            $numeroHora = (int)($horaTarde);
            $hour = ($numeroHora < 10) ? '0'.$numeroHora.':00' : $numeroHora.':00' ;
            $horasDisponibles[$numeroHora] = $hour;
        }
    }

    return $horasDisponibles;
}

}

//[ 8:00 , 9:00 , 15:00 ] formatao de horas  para horario  disponible 
// y validar  si la sede tiene ese  sia  como laborable. para consultar  horario
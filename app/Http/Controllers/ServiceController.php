<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Czim\Service\Requests\ServiceSoapRequest;
use Czim\Service\Services\SoapService;
use GuzzleHttp\Client;

class ServiceController extends Controller
{
    


    public function getActores(){

        // Set up defaults
    $defaults = new \Czim\Service\Requests\ServiceSoapRequestDefaults();

    $defaults->setLocation('http://192.168.11.13:8080/WebCine/WSActores?WSDL');

    // Instantiate service, with a to-array interpreter
    $service = new SoapService(
        $defaults,
        new \Czim\Service\Interpreters\BasicSoapXmlAsArrayInterpreter()
    );

    // Prepare a specific request
    $request = new ServiceSoapRequest();

    
    // Perform the call, which will return a ServiceReponse object
    $response = $service->call('listarActores', $request);
    
    $actores = $response['data']['return'];

    return $actores;
    }


        public function getMovie(int $idPelicula){
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', 'http://127.0.0.1:8000/api/movie/'.$idPelicula);

           return  $response->getBody();
        }

        public function getTodos()
        {
            $client = new Client();
            $response = $client->get('https://jsonplaceholder.typicode.com/todos');
            return json_decode($response->getBody());
        }
    
}

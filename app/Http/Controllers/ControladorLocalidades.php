<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GeoAPI;

class ControladorLocalidades extends Controller
{
    // Por defecto muestro las provincias y comunidades
    public function index()
    {
        $provincias=$this->get_provincias ();
        $comunidades=$this->get_comunidades ();
        return view ("index", ['comunidades'=>$comunidades, 'provincias'=>$provincias]);
    }
    /**
     * @param Request $datos solicitud post
     * Analiza los diferentes submit, y en función realiza la acción
     * Retorna una vista
     * Por defecto siempre entrega comunidades y provincias
     * Si se ha seleccionado provincias de una comunidad
     * Si se ha seleccionado municipios de una provincia
     */

    public function gestionar_accion(Request $datos)
    {
        //En cualquier caso necesito todas la comunidades
        $comunidades=$this->get_comunidades ();

        //Inicializamos variables para la vista a null
        $name_comunidad=null;
        $municipios=null;
        $name_provincia=null;
        switch ($datos->submit) {
            case "Mostrar provincias de comunidad seleccionada":
                $name_comunidad=$datos->name_comunidad[$datos->comunidad];
                $provincias=$this->get_provincias ($datos->comunidad);
                break;
            case "Mostrar municipios":
//                Necesito CPRO
                $provincias=$this->get_provincias ($datos->comunidad);

                $name_provincia=$datos->name_provincia[$datos->provincia];
                $municipios=$this->get_municipios ($datos->provincia);
                break;
            case "Mostrar todas las provincias":
                $provincias=$this->get_provincias ();
                break;
        }
        return view ("index", ['comunidades'=>$comunidades,
            'name_comunidad'=>$name_comunidad,
            'provincias'=>$provincias,
            'name_provincia'=>$name_provincia,
            'municipios'=>$municipios]);
    }

    /**
     * @return mixed array asociativo provincia[CPRO]=PRO
     * Por ejemplo provincia[50]="Zaragoza" (2 primeros dígitos del cp)
     * Si paso una comunidad me retorna las provincias de esa comunidad
     * Si no, retorna todas las provincias del estado Español
     */
    private function get_provincias($comunidad=null)
    {
        if (isset($comunidad))
            $response=Http::get ("https://apiv1.geoapi.es/provincias?CCOM=$comunidad&key=5668b0a9c33dd361f47b118ef5f2b0eea8e41d5d5a9138dad4a6b943599cecf9");
        else
            $response=Http::get ('https://apiv1.geoapi.es/provincias?key=5668b0a9c33dd361f47b118ef5f2b0eea8e41d5d5a9138dad4a6b943599cecf9');

        $jsonData=$response->json ();
        $datos=$jsonData["data"];
        foreach($datos as $dato){
            $provincias[$dato["CPRO"]]=$dato["PRO"];
        }

        return $provincias;

    }
    /**
     * @return mixed array asociativo comunidad[CCOM]=COM
     * Por ejemplo comunidad[02]="Aragon"
     */
    private function get_comunidades()
    {
        $response=Http::get ('https://apiv1.geoapi.es/comunidades?key=5668b0a9c33dd361f47b118ef5f2b0eea8e41d5d5a9138dad4a6b943599cecf9');
        $jsonData=$response->json ();
        $datos=$jsonData["data"];
        foreach($datos as $dato){
            $comunidades[$dato["CCOM"]]=$dato["COM"];
        }
        return $comunidades;
    }


    /**
     * @return mixed array asociativo municipio[CMUM]=DMUN50
     * Por ejemplo municipio['045']="BELCHITE"
     */
    private function get_municipios($provincia)
    {
        $response=Http::get ("https://apiv1.geoapi.es/municipios?CPRO=$provincia&key=5668b0a9c33dd361f47b118ef5f2b0eea8e41d5d5a9138dad4a6b943599cecf9");

        $jsonData=$response->json ();
        $datos=$jsonData["data"];
        foreach($datos as $dato){
            $municipios[$dato["CMUM"]]=$dato["DMUN50"];
        }
        var_dump ($municipios);
        return $municipios;
    }
}

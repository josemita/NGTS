<?php

class NGTS{

    protected $cities;
    protected $connections;

    public function __construct($cities, $connections)
    {
        $this->cities       = $cities;
        $this->connections  = $connections;
    }

    //A partir del nombre de dos ciudades obtenemos las posibles rutas de un origen a un destino
    public function get_routes_with_name($origen, $destino){
      
        $origen           = array_search($origen, $this->cities);
        $destino          = array_search($destino, $this->cities);


        if($origen === false || $destino  === false){
           return false;
        }
        $this->ruta     = array($origen);
        $this->valor    = 0;
        $routes    = array();
        $this->get_routes($origen, $destino, $routes);

        return $routes;
       
       
     
    }

    //Obtenemos las rutas entre dos indices
    public function get_routes($punto1, $punto2, &$routes, &$route = array()){
      
        $origin_connections = $this->connections[$punto1];
     
        foreach ($origin_connections as $city => $cost) {
        
            if(!in_array($city , $this->ruta) && $cost > 0){
                $this->ruta[] = $city;
                if($city == $punto2){
                    $routes[]  = $this->ruta;
                    array_splice($this->ruta, array_search($city, $this->ruta ));
                }else{
                    $this->get_routes($city, $punto2, $routes, $route);
                }
            }
        }
        array_splice($this->ruta, count($this->ruta)-1);

    }

    //Dadas unas rutas obtenemos la de coste minimo
    public function short_route($routes){
        $min_route = NULL;
        $min_cost = NULL;

        foreach($routes as $route){
            $cost =  $this->get_cost_route($route);
            if(!isset($min_cost) || $cost < $min_cost){
                $min_route = $route;
                $min_cost = $cost;
            }
        }

        return array('route' => $min_route, 'cost' => $min_cost);

    }
    
    //Mostramos el coste de una ruta por pantalla
    public function print_route($route, $all_route = true){

        foreach($route['route'] as $index => $city){
            if($all_route)
                echo $this->cities[$city] . '->';
            else{
                if($index == 0 || $index == count($route['route'])-1){
                    echo $this->cities[$city]  . '->';
                }
            }
            
        }

        echo 'Coste: '.$route['cost'];
        echo "<br>";
    }

    //Obtenemos el coste de una ruta
    protected function get_cost_route($route){
        $valor = 0;
        foreach ($route as $index => $city){
             if($index > 0){
                 $valor += $this->connections[$city][$route[$index-1]];
             }
         }
        return $valor;
     }

}
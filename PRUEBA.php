<?php

include_once('NGTS.php');


$cities=['Logroño','Zaragoza','Teruel','Madrid','Lleida','Alicante','Castellón','Segovia','Ciudad Real'];

$connections=[
        [0,4,6,8,0,0,0,0,0],
        [4,0,2,0,2,0,0,0,0],
        [6,2,0,3,5,7,0,0,0],
        [8,0,3,0,0,0,0,0,0],
        [0,2,5,0,0,0,4,8,0],
        [0,0,7,0,0,0,3,0,7],
        [0,0,0,0,4,3,0,0,6],
        [0,0,0,0,8,0,0,0,4],
        [0,0,0,0,0,7,6,4,0]];


//Creamos el objeto NGTS (Next Generation Transport Service)
$ngts = new NGTS($cities, $connections);

//Pintamos la ruta mas corta de Logroño a Castellón (se podrian elegir dos ciudades cualesquiera)
$routes = $ngts->get_routes_with_name('Logroño', 'Ciudad Real');
if($routes){
	$route = $ngts->short_route($routes);
	$ngts->print_route($route);
}



//Pintamos las rutas desde un punto a todos los demas
$punto_origen = 'Madrid';

foreach($cities as $city){
	if($city != $punto_origen){
		$routes = $ngts->get_routes_with_name($punto_origen, $city);
		$route = $ngts->short_route($routes);
		$ngts->print_route($route, false);
	}
}

?>
<?php

include_once "../model/pokemones.php";

// Obtener los datos enviados desde JavaScript
$datosPokemon = json_decode(file_get_contents('php://input'), true);



$pokemon = new \modelo\Pokemones();

$responses = array();

foreach ($datosPokemon as $datos) {
  $pokemon->setId($datos['id']);
  $pokemon->setNombrePo($datos['nombrePo']);
  $pokemon->setPrecioPo($datos['precioPo']);
  $pokemon->setCantidadPo($datos['cantidadPo']);
  $pokemon->setDescripPo($datos['descripPo']);

  $response = $pokemon->agregarPokemon();

  $responses[] = $response;

}

echo json_encode($response);

unset($pokemon);

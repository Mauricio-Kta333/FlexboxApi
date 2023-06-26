<?php

include_once "../model/pedido.php";

$datosPokemon = json_decode(file_get_contents('php://input'), true);

$pedidoMP = new \modelo\Pedidos();

$responses = array();

foreach ($datosPokemon['pokemones'] as $datos) {
    $idPedido = $datosPokemon['pedido']['id'];
    
    $pedidoMP->setIdPo($datos['id']);
    $pedidoMP->setCantidadPo($datos['cantidad']);
    $pedidoMP->setIdPed($idPedido); // Agrega el ID del pedido al objeto Pedido

    $response = $pedidoMP->agregarDatosPokemones();

    $responses[] = $response;
}


header('Content-Type: application/json');
echo json_encode($response);

unset($pedidoMP);


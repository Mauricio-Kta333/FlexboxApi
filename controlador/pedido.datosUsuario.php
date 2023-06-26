<?php

include_once "../model/pedido.php";

$datosPokemon = json_decode(file_get_contents('php://input'), true);

$pedidoMP = new \modelo\Pedidos();

$responses = array();

foreach ($datosPokemon['pokemones'] as $datos) {
  $codigoPedido = rand(1000, 5000);

  $pedidoMP->setCodigoPed($codigoPedido);
  $pedidoMP->setIdUsuario($datosPokemon['usuario']['id']);
  $pedidoMP->setNombre($datosPokemon['usuario']['nombre']);
  $pedidoMP->setDireccion($datosPokemon['usuario']['direccion']);
  $pedidoMP->setTelefono($datosPokemon['usuario']['telefono']);
  $pedidoMP->setTotalPedido($datosPokemon['total']);

  $idPedido = $pedidoMP->agregarDatosUsuarios(); // Obtener el idPedido generado

  $responses[] = array('idPedido' => $idPedido);
  

}

// Verificar si ocurrieron errores al agregar los pedidos
$errors = array_filter($responses, function ($response) {
  return strpos($response['idPedido'], 'Error') !== false;
});

if (empty($errors)) {
  // Todos los pedidos se agregaron correctamente
  $responseData = array('success' => true, 'idPedidos' => $responses);
} else {
  // Se produjo un error al agregar uno o más pedidos
  $responseData = array('success' => false);
}

header('Content-Type: application/json');
echo json_encode($responseData);

unset($pedidoMP);


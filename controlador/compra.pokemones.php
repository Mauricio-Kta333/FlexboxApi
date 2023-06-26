<?php

include_once "../model/compra.php";

$compraPS = new \modelo\Compras();

$codigoCom = rand(1000, 5000);

$compraPS->setCodigoCom($codigoCom);
$response = $compraPS->agregarCompraPokemon();

// Obtener el ID de la compra insertada
$idCom = $compraPS->conexion->getCon()->lastInsertId();

// Crear un arreglo asociativo con la respuesta y el ID de la compra
$responseData = array(
  'message' => $response,
  'idCom' => $idCom
);

echo json_encode($responseData);

unset($compraPS);
unset($response);

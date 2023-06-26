<?php

include_once "../model/compra.php";

$datosPokemon = $_POST; // Obtener los datos del formulario enviado por FormData

$datosPOS = new \modelo\Compras();

// Obtener el ID de la compra desde el formulario
$datosPOS->setIdCom($datosPokemon["idCom"]);

$responses = array();

// Recorrer todos los datos enviados desde el formulario
foreach ($datosPokemon as $campo => $valor) {
    // Verificar si el nombre del campo comienza con "idPo"
    if (strpos($campo, 'idPo') === 0) {
        $idPo = $valor;
        $cantidadPoCom = $datosPokemon["cantidadPoCom"];
        $datosPOS->setIdPo($idPo);
        $datosPOS->setCantidadPoCom($cantidadPoCom);

        $response = $datosPOS->agregarDetalleCompra();

        $responses[] = $response;
    }
}

echo json_encode($responses);

unset($datosPOS);
?>

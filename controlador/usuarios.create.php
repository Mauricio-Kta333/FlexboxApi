<?php

include_once "../model/usuario.php";

$tipoDoc = $_POST["selTipoDoc"];
$identificacion = $_POST["numIdentificacion"];
$nombre = $_POST["txtNombre"];
$apellido = $_POST["txtApellido"];
$correo = $_POST["txtCorreo"];
$password = $_POST["txtPassword"];
$direccion = $_POST["txtDireccion"];
$telefono = $_POST["txtTelefono"];
$genero = $_POST["selGenero"];

$usuarioM = new \modelo\Usuario();

$usuarioM->setTipoDoc($tipoDoc);
$usuarioM->setIdentificacion($identificacion);
$usuarioM->setNombre($nombre);
$usuarioM->setApellido($apellido);
$usuarioM->setCorreo($correo);
$usuarioM->setPassword($password);
$usuarioM->setDireccion($direccion);
$usuarioM->setTelefono($telefono);
$usuarioM->setGenero($genero);

$response = $usuarioM->createUsuario();

echo json_encode($response);

unset($usuarioM);
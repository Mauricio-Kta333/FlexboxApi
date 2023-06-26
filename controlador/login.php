<?php

include_once "../model/usuario.php";

$correo = $_POST["txtCorreo"];
$password = $_POST["txtPassword"];

$loginM = new \modelo\Usuario();
$loginM->setCorreo($correo);
$loginM->setPassword($password);
$response = $loginM->login();

echo json_encode($response);

unset($loginM);
unset($response);
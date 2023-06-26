<?php
session_start();

if ( isset($_SESSION) and !empty($_SESSION)){
    $response = true;
} else {
    $response = false;
}

echo json_encode($response);
unset($response);
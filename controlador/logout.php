<?php
try {
    session_start();
    session_unset();
    session_destroy();

    // Eliminar el siguiente código JSON
    // echo json_encode(true);

    header("Location: ../inicioSesion.html");

    exit();
} catch (\Throwable $th) {
    echo json_encode(false);
}

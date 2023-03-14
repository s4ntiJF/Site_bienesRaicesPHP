<?php

function conectarBD() : mysqli {
    $baseDatos = mysqli_connect('localhost', 'root', '', 'bienesraices_crub');

    if(!$baseDatos){
        echo 'Error no se pudo conectar';
    }

    return $baseDatos;
}
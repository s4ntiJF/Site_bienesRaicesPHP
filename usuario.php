<?php

// Importar la conexión
require 'includes/config/database.php';
$baseDatos = conectarBD();

// Crear un email y password 
$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($passwordHash, PASSWORD_DEFAULT);


// Query para crear el usuario
$query = " INSERT INTO asuarios (email, password ) VALUES ('${email}', '${passwordHash}'; ";

// echo $query;

// Agregarlo a la base de datos
mysqli_query($baseDatos, $query);


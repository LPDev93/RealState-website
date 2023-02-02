<?php

/* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
============================== */

// -- Variables de conexión - MySQL Maria BD
$db_name        = 'mysql:host=localhost;dbname=home_db';
$db_user_name   = 'root';
$db_user_pass   = '';

// -- Conexión a la BD
$conn = new PDO(
    $db_name,
    $db_user_name,
    $db_user_pass
);

// -- Función para crear ID únicos aleatorios
function create_unique_id()
{
    $characters         = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // -- 'strlen' devuelve el tamaño de caracteres de un texto
    $charactersLength   = strlen($characters);
    $randomString       = '';
    // -- 'for' para crear el nuevo ID aleatorio de 20 caracteres
    for ($c = 0; $c < 20; $c++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    // -- retornamos el nuevo ID
    return $randomString;
}

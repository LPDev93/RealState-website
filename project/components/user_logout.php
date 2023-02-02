<?php

/* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
============================== */

// -- Clases incluidas
include 'connect.php';

// -- Actualizar las cookies a un ID vacío
setcookie('user_id', '', time() - 1, '/');

// -- Redirecionamos a Inicio
header('location:../home.php');
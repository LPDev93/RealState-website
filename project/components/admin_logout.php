<?php

/* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
============================== */

//-- Componentes
include 'connect.php';

//-- Borramos datos locals o cookies
setcookie('admin_id', '', time() - 1, '/');
header('location:../admin/login.php');

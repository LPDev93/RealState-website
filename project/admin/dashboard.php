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
include '../components/connect.php';

//-- Validación de Usuario
if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Admin - Panel de Control</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Componente - Panel de Control - Inicio -->
    <section class="dashboard">
        <!-- Título -->
        <h1 class="heading">Panel de Control</h1>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <!-- Componente - Caja 01 -->
            <div class="box">
                <?php
                //-- Consultamos los datos del administrador según su ID
                $select_profile = $conn->prepare(
                    "SELECT *
                    FROM `admins`
                    WHERE id = ?
                    LIMIT 1"
                );
                $select_profile->execute([$admin_id]);
                //-- Capturamos los datos del administrador
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <h3>¡Bienvenido!</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="update.php" class="btn">Actualizar perfil</a>
            </div>
            <!-- Componente - Caja 02 -->
            <div class="box">
                <?php
                //-- Consultamos los datos de las propiedades
                $select_listings = $conn->prepare(
                    "SELECT * 
                    FROM `property`"
                );
                $select_listings->execute();
                //-- Contamos la cantidad de incidencias encontradas
                $count_listings = $select_listings->rowCount();
                ?>
                <h3><?= $count_listings; ?></h3>
                <p>Propiedades publicadas</p>
                <a href="listings.php" class="btn">Ver anuncios</a>
            </div>
            <!-- Componente - Caja 03 -->
            <div class="box">
                <?php
                //-- Consultamos los datos de los usuarios
                $select_users = $conn->prepare(
                    "SELECT * 
                    FROM `users`"
                );
                $select_users->execute();
                //-- Contamos la cantidad de usuarios encontrados
                $count_users = $select_users->rowCount();
                ?>
                <h3><?= $count_users; ?></h3>
                <p>Usuarios totales</p>
                <a href="users.php" class="btn">Ver usuarios</a>
            </div>
            <!-- Componente - Caja 04 -->
            <div class="box">
                <?php
                //-- Consultamos los datos de los administradores
                $select_admins = $conn->prepare(
                    "SELECT * 
                    FROM `admins`"
                );
                $select_admins->execute();
                //-- Contamos la cantidad de administradores encontrados
                $count_admins = $select_admins->rowCount();
                ?>
                <h3><?= $count_admins; ?></h3>
                <p>Administradores encontrados</p>
                <a href="admins.php" class="btn">Ver administradores</a>
            </div>
            <!-- Componente - Caja 05 -->
            <div class="box">
                <?php
                //-- Consultamos los datos de los mensajes
                $select_messages = $conn->prepare(
                    "SELECT * 
                    FROM `messages`"
                );
                $select_messages->execute();
                //-- Contamos la cantidad de mensajes encontrados
                $count_messages = $select_messages->rowCount();
                ?>
                <h3><?= $count_messages; ?></h3>
                <p>Nuevos mensajes</p>
                <a href="messages.php" class="btn">Ver mensajes</a>
            </div>
        </div>
    </section>
    <!-- Componente - Panel de Control - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="../js/admin_script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

</body>

</html>
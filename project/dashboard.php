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
include 'components/connect.php';

// -- Validación de Inicio de sesión
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';    
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Panel de control</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Panel de control - Inicio -->
    <section class="dashboard">
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <!-- Componente - Caja 01 -->
            <div class="box">
                <?php
                //-- Obtener Información del usuario por ID
                $select_profile = $conn->prepare(
                    "SELECT *
                    FROM `users`
                    WHERE id = ?
                    LIMIT 1"
                );
                $select_profile->execute([$user_id]);
                //-- Con "fetch" extraemos la información en una variable
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <!-- Título -->
                <h3>¡Bienvenido!</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="update.php" class="btn">Actualizar perfil</a>
            </div>
            <!-- Componente - Caja 02 -->
            <div class="box">
                <!-- Título -->
                <h3>Buscar anuncio</h3>
                <p>Busca un anuncio</p>
                <a href="search.php" class="btn">Buscar ahora</a>
            </div>
            <!-- Componente - Caja 03 -->
            <div class="box">
                <?php
                //-- Obtener información de las propiedades del usuario por ID                
                $count_properties = $conn->prepare(
                    "SELECT *
                    FROM `property`
                    WHERE user_id = ?"
                );
                $count_properties->execute([$user_id]);
                //-- Se contarán cuantas filas existen en la BD
                $total_properties = $count_properties->rowCount();
                ?>
                <!-- Título -->
                <h3><?= $total_properties; ?></h3>
                <p>propiedades publicadas</p>
                <a href="my_listings.php" class="btn">ver mis publicaciones</a>
            </div>
            <!-- Componente - Caja 04 -->
            <div class="box">
                <?php
                //-- Obtener información de las consultas hacia el usuario por ID
                $count_requests_received = $conn->prepare(
                    "SELECT * 
                    FROM `requests` 
                    WHERE receiver = ?"
                );
                $count_requests_received->execute([$user_id]);
                //-- Se contarán cuantas filas existen en la BD
                $total_requests_received = $count_requests_received->rowCount();
                ?>
                <!-- Título -->
                <h3><?= $total_requests_received; ?></h3>
                <p>solicitudes recibidas</p>
                <a href="requests.php" class="btn">ver todas las solicitudes</a>
            </div>
            <!-- Componente - Caja 05 -->
            <div class="box">
                <?php
                //-- Obtener información de las consultas hechas por el usuario
                $count_requests_sent = $conn->prepare(
                    "SELECT * 
                    FROM `requests` 
                    WHERE sender = ?"
                );
                $count_requests_sent->execute([$user_id]);
                //-- Se contarán cuantas filas existen en la BD
                $total_requests_sent = $count_requests_sent->rowCount();
                ?>
                <!-- Título -->
                <h3><?= $total_requests_sent; ?></h3>
                <p>solicitudes enviadas</p>
                <a href="saved.php" class="btn">Ver todas las solicitudes</a>
            </div>
            <!-- Componente - Caja 06 -->
            <div class="box">
                <?php
                //-- Obtener información de los anuncios favoritos por usuario
                $count_saved_properties = $conn->prepare(
                    "SELECT * 
                    FROM `saved` 
                    WHERE user_id = ?"
                );
                $count_saved_properties->execute([$user_id]);
                //-- Se contarán cuantas filas existen en la BD
                $total_saved_properties = $count_saved_properties->rowCount();
                ?>
                <!-- Título -->
                <h3><?= $total_saved_properties; ?></h3>
                <p>Anuncios favoritos</p>
                <a href="saved.php" class="btn">Ver anuncios favoritos</a>
            </div>
        </div>
    </section>
    <!-- Sección Panel de control - Inicio -->

    <!-- Componente - Pie de página -->
    <?php include 'components/footer.php'; ?>

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="js/script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include 'components/message.php'; ?>

</body>

</html>
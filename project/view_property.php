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

//-- Validar el ID de la propiedad en consulta
if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:home.php');
}

//-- Clases adicionales, luego de validar datos
include 'components/save_send.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Propiedad</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Propiedad - Inicio -->
    <section class="view-property">
        <!-- Título -->
        <h1 class="heading">Detalles de la propiedad</h1>
        <?php
        //-- Consultar datos de la propiedad a mostrar
        $select_properties = $conn->prepare(
            "SELECT * 
            FROM `property` 
            WHERE id = ? 
            ORDER BY date 
            DESC 
            LIMIT 1"
        );
        $select_properties->execute([$get_id]);
        //-- Sí encontramos incidencias en la BD
        if ($select_properties->rowCount() > 0) {
            //-- Obtener datos de la propiedad
            while ($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)) {
                $property_id = $fetch_property['id'];
                //-- Consultar datos del vendedor
                $select_user = $conn->prepare(
                    "SELECT * 
                    FROM `users` 
                    WHERE id = ?"
                );
                $select_user->execute([$fetch_property['user_id']]);
                //-- Obtener datos del vendeor de la propiedad
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
                //-- Consultar datos de las propiedades favoritas según ID del usuario en sesión
                $select_saved = $conn->prepare(
                    "SELECT * 
                    FROM `saved` 
                    WHERE property_id = ? 
                    AND user_id = ?"
                );
                $select_saved->execute([$fetch_property['id'], $user_id]);
        ?>
                <!-- Componente - Caja Detalles -->
                <div class="details">
                    <!-- Componente - Carusel de imágenes -->
                    <div class="swiper images-container">
                        <div class="swiper-wrapper">
                            <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="<?= $fetch_property['property_name']; ?>" class="swiper-slide">
                            <?php if (!empty($fetch_property['image_02'])) { ?>
                                <img src="uploaded_files/<?= $fetch_property['image_02']; ?>" alt="<?= $fetch_property['property_name']; ?>" class="swiper-slide">
                            <?php } ?>
                            <?php if (!empty($fetch_property['image_03'])) { ?>
                                <img src="uploaded_files/<?= $fetch_property['image_03']; ?>" alt="<?= $fetch_property['property_name']; ?>" class="swiper-slide">
                            <?php } ?>
                            <?php if (!empty($fetch_property['image_04'])) { ?>
                                <img src="uploaded_files/<?= $fetch_property['image_04']; ?>" alt="<?= $fetch_property['property_name']; ?>" class="swiper-slide">
                            <?php } ?>
                            <?php if (!empty($fetch_property['image_05'])) { ?>
                                <img src="uploaded_files/<?= $fetch_property['image_05']; ?>" alt="<?= $fetch_property['property_name']; ?>" class="swiper-slide">
                            <?php } ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <!-- Título -->
                    <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
                    <!-- Ubicación -->
                    <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
                    <!-- Información adicional -->
                    <div class="info">
                        <p><i class="fas fa-dollar-sign"></i><span><?= $fetch_property['price']; ?></span></p>
                        <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
                        <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?= $fetch_user['number']; ?></a></p>
                        <p><i class="fas fa-building"></i><span><?= $fetch_property['type']; ?></span></p>
                        <p><i class="fas fa-house"></i><span><?= $fetch_property['offer']; ?></span></p>
                        <p><i class="fas fa-calendar"></i><span><?= $fetch_property['date']; ?></span></p>
                    </div>
                    <!-- Título -->
                    <h3 class="title">Detalles</h3>
                    <!-- Componente - Flexible -->
                    <div class="flex">
                        <!-- Componente - Caja 01 -->
                        <div class="box">
                            <p><i>Habitaciones: </i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
                            <p><i>Deposito Inicial: </i><span><span class="fas fa-dollar-sign" style="margin-right: .5rem;"></span><?= $fetch_property['deposite']; ?></span></p>
                            <p><i>Estado: </i><span><?= $fetch_property['status']; ?></span></p>
                            <p><i>Cuartos: </i><span><?= $fetch_property['bedroom']; ?></span></p>
                            <p><i>Baños: </i><span><?= $fetch_property['bathroom']; ?></span></p>
                            <p><i>Balcones: </i><span><?= $fetch_property['balcony']; ?></span></p>
                        </div>
                        <!-- Componente - Caja 02 -->
                        <div class="box">
                            <p><i>Metros cuadrados : </i><span><?= $fetch_property['carpet']; ?></span></p>
                            <p><i>Antiguedad : </i><span><?= $fetch_property['age']; ?> years</span></p>
                            <p><i>Pisos Totales: </i><span><?= $fetch_property['total_floors']; ?></span></p>
                            <p><i>Planta Bajas: </i><span><?= $fetch_property['room_floor']; ?></span></p>
                            <p><i>Muebles: </i><span><?= $fetch_property['furnished']; ?></span></p>
                            <p><i>Préstamo: </i><span><?= $fetch_property['loan']; ?></span></p>
                        </div>
                    </div>
                    <!-- Título -->
                    <h3 class="title">Servicios Adicionales</h3>
                    <!-- Componente - Flexible -->
                    <div class="flex">
                        <!-- Componente - Caja -->
                        <div class="box">
                            <p><i class="fas fa-<?php if ($fetch_property['lift'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Ascensor</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['security_guard'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Seguridad</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['play_ground'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Parque</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['garden'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Jardín</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['water_supply'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Tanque de agua</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['power_backup'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Energía de emergencia</span></p>
                        </div>
                        <div class="box">
                            <p><i class="fas fa-<?php if ($fetch_property['parking_area'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Parqueo</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['gym'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Gimnasio</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['shopping_mall'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Centro comercial</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['hospital'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Hospital</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['school'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Escuela</span></p>
                            <p><i class="fas fa-<?php if ($fetch_property['market_area'] == 'yes') {
                                                    echo 'check';
                                                } else {
                                                    echo 'times';
                                                } ?>"></i><span>Mercado</span></p>
                        </div>
                    </div>
                    <!-- Título -->
                    <h3 class="title">Descripción</h3>
                    <p class="description"><?= $fetch_property['description']; ?></p>
                    <!-- Componente - Formulario -->
                    <form action="" method="post" class="flex-btn">
                        <input type="hidden" name="property_id" value="<?= $property_id; ?>">
                        <?php
                        if ($select_saved->rowCount() > 0) {
                        ?>
                            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Quitar de favoritos</span></button>
                        <?php
                        } else {
                        ?>
                            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Favorito</span></button>
                        <?php
                        }
                        ?>
                        <input type="submit" value="Mandar solicitud" name="send" class="btn">
                    </form>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">¡No se encuentra la propiedad que intenta acceder! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">¿Deseas añadir una?</a></p>';
        }
        ?>
    </section>
    <!-- Sección Propiedad - Inicio -->

    <!-- Componente - Pie de página -->
    <?php include 'components/footer.php'; ?>

    <!-- Swiper Images CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="js/script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include 'components/message.php'; ?>

    <!-- Script adicional -->
    <script>
        var swiper = new Swiper(".images-container", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 200,
                modifier: 1,
                slideShadows: true,
            },
            pagination: {
                el: ".swiper-pagination",
            },
        });
    </script>

</body>

</html>
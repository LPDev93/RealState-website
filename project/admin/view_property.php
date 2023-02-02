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

//-- Validar el ID de la propiedad en consulta
if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:listings.php');
}

//-- Validar acción de borrar anuncio
if (isset($_POST['delete'])) {
    //-- Variables POST
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    //-- Consulta de datos de la propiedad por ID
    $verify_delete = $conn->prepare(
        "SELECT * 
        FROM `property` 
        WHERE id = ?"
    );
    $verify_delete->execute([$delete_id]);
    //-- Sí existen incidencias
    if ($verify_delete->rowCount() > 0) {
        //-- Consulta de datos de la propiedad seleccionada
        $select_images = $conn->prepare(
            "SELECT * 
            FROM `property` 
            WHERE id = ?"
        );
        $select_images->execute([$delete_id]);
        //-- Capturamos las imágenes y datos de la propiedad seleccionada
        while ($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)) {
            $image_01 = $fetch_images['image_01'];
            $image_02 = $fetch_images['image_02'];
            $image_03 = $fetch_images['image_03'];
            $image_04 = $fetch_images['image_04'];
            $image_05 = $fetch_images['image_05'];
            unlink('../uploaded_files/' . $image_01);
            if (!empty($image_02)) {
                unlink('../uploaded_files/' . $image_02);
            }
            if (!empty($image_03)) {
                unlink('../uploaded_files/' . $image_03);
            }
            if (!empty($image_04)) {
                unlink('../uploaded_files/' . $image_04);
            }
            if (!empty($image_05)) {
                unlink('../uploaded_files/' . $image_05);
            }
        }
        // -- Eliminar anuncios guardados, peticiones y propiedad de la BD
        $delete_saved = $conn->prepare(
            "DELETE
            FROM `saved` 
            WHERE property_id = ?"
        );
        $delete_saved->execute([$delete_id]);
        $delete_requests = $conn->prepare(
            "DELETE
            FROM `requests` 
            WHERE property_id = ?"
        );
        $delete_requests->execute([$delete_id]);
        $delete_listing = $conn->prepare(
            "DELETE
            FROM `property` 
            WHERE id = ?"
        );
        $delete_listing->execute([$delete_id]);
        $success_msg[] = '¡Anuncio eliminado correctamente!';
    } else {
        $warning_msg[] = '¡El anuncio ya ha sido eliminado!';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Admin - Ver propiedad</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Componente - Ver propiedad - Inicio -->
    <section class="view-property">
        <!-- Título -->
        <h1 class="heading">Detalles de la propiedad</h1>
        <?php
        //-- Consulta de datos de la propiedad seleccionada por ID
        $select_properties = $conn->prepare(
            "SELECT * 
            FROM `property` 
            WHERE id = ? 
            ORDER BY date 
            DESC 
            LIMIT 1"
        );
        $select_properties->execute([$get_id]);
        //-- Sí encuentra incidencias
        if ($select_properties->rowCount() > 0) {
            //-- Capturamos los datos de la propiedad seleccionada por ID
            while ($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)) {
                $property_id = $fetch_property['id'];
                //-- Consulta de datos del usuario
                $select_user = $conn->prepare(
                    "SELECT * 
                    FROM `users` 
                    WHERE id = ?"
                );
                $select_user->execute([$fetch_property['user_id']]);
                //-- Capturamos de datos del usuario
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
        ?>
                <!-- Componente - Detalles -->
                <div class="details">
                    <div class="swiper images-container">
                        <div class="swiper-wrapper">
                            <img src="../uploaded_files/<?= $fetch_property['image_01']; ?>" alt="Imagen" class="swiper-slide">
                            <?php if (!empty($fetch_property['image_02'])) { ?>
                                <img src="../uploaded_files/<?= $fetch_property['image_02']; ?>" alt="Imagen" class="swiper-slide">
                            <?php } ?>
                            <?php if (!empty($fetch_property['image_03'])) { ?>
                                <img src="../uploaded_files/<?= $fetch_property['image_03']; ?>" alt="Imagen" class="swiper-slide">
                            <?php } ?>
                            <?php if (!empty($fetch_property['image_04'])) { ?>
                                <img src="../uploaded_files/<?= $fetch_property['image_04']; ?>" alt="Imagen" class="swiper-slide">
                            <?php } ?>
                            <?php if (!empty($fetch_property['image_05'])) { ?>
                                <img src="../uploaded_files/<?= $fetch_property['image_05']; ?>" alt="Imagen" class="swiper-slide">
                            <?php } ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <!-- Elementos -->
                    <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
                    <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
                    <!-- Componente - Información -->
                    <div class="info">
                        <p><i class="fas fa-dollar-sign"></i><span><?= $fetch_property['price']; ?></span></p>
                        <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
                        <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?= $fetch_user['number']; ?></a></p>
                        <p><i class="fas fa-building"></i><span><?= $fetch_property['type']; ?></span></p>
                        <p><i class="fas fa-house"></i><span><?= $fetch_property['offer']; ?></span></p>
                        <p><i class="fas fa-calendar"></i><span><?= $fetch_property['date']; ?></span></p>
                    </div>
                    <!-- Elementos -->
                    <h3 class="title">Detalles adicionales</h3>
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
                    </div><!-- Título -->
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
                    <!-- Elementos -->
                    <h3 class="title">Descripción</h3>
                    <p class="description"><?= $fetch_property['description']; ?></p>
                    <!-- Componente - Formulario -->
                    <form action="" method="post" class="flex-btn">
                        <input type="hidden" name="delete_id" value="<?= $property_id; ?>">
                        <input type="submit" value="Borrar propiedad" name="delete" class="delete-btn" onclick="return confirm('¿Desea borrar este anuncio?');">
                    </form>
                    <a href="listings.php" class="option-btn">Volver a los anuncios</a>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">No se ha podido encontrar la propiedad <a href="listings.php" style="margin-top:1.5rem;" class="option-btn">Volver a los anuncios</a></p>';
        }
        ?>
    </section>
    <!-- Componente - Ver propiedad - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Swiper Images CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="../js/admin_script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

    <script>
        var swiper = new Swiper(".images-container", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            loop: true,
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 200,
                modifier: 3,
                slideShadows: true,
            },
            pagination: {
                el: ".swiper-pagination",
            },
        });
    </script>

</body>

</html>
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

//-- Validar acción eliminar
if (isset($_POST['delete'])) {
    //-- Variables POST
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    //-- Consultar datos de propiedades por ID
    $verify_delete = $conn->prepare(
        "SELECT * 
        FROM `property` 
        WHERE id = ?"
    );
    $verify_delete->execute([$delete_id]);
    //-- Sí se encuentran incidencias
    if ($verify_delete->rowCount() > 0) {
        //-- Consultar los datos de la propiedad por ID
        $select_images = $conn->prepare(
            "SELECT * 
            FROM `property` 
            WHERE id = ?"
        );
        $select_images->execute([$delete_id]);
        //-- Capturamos las imágenes enlazadas a la propiedad
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
    <title>Real Estate Lima - Admin - Anuncios</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Componente - Anuncios - Inicio -->
    <section class="listings">
        <!-- Título -->
        <h1 class="heading">Todos los anuncios</h1>
        <!-- Componente - Formulario -->
        <form action="" method="post" class="search-form">
            <input type="text" name="search_box" placeholder="Buscar anuncio" maxlength="100" required>
            <button type="submit" class="fas fa-search" name="search_btn"></button>
        </form>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <?php
            //-- Validamos acción de búsqueda
            if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                //-- Variables POST
                $search_box = $_POST['search_box'];
                $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
                //-- Consultamos datos de la propiedad que cumpla con la búsqueda por orden descendiente
                $select_listings = $conn->prepare(
                    "SELECT * 
                    FROM `property` 
                    WHERE property_name 
                    LIKE '%{$search_box}%' 
                    OR address 
                    LIKE '%{$search_box}%' 
                    ORDER BY date 
                    DESC"
                );
                $select_listings->execute();
            } else {
                //-- Consultamos datos de todas las propiedades por orden descendiente
                $select_listings = $conn->prepare(
                    "SELECT *
                    FROM `property` 
                    ORDER BY date 
                    DESC"
                );
                $select_listings->execute();
            }
            //-- Cantidad de imágenes por anuncio
            $total_images = 0;
            //-- Sí existen incidencias encontradas
            if ($select_listings->rowCount() > 0) {
                //-- Capturamos los datos de las propiedades
                while ($fetch_listing = $select_listings->fetch(PDO::FETCH_ASSOC)) {
                    $listing_id = $fetch_listing['id'];
                    //-- Consultamos los usuarios de los anuncios por su ID
                    $select_user = $conn->prepare(
                        "SELECT * 
                        FROM `users` 
                        WHERE id = ?"
                    );
                    $select_user->execute([$fetch_listing['user_id']]);
                    //-- Capturamos los datos de los usuarios
                    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
                    //-- Añadimos las imágenes encontradas a la variable contador
                    if (!empty($fetch_listing['image_02'])) {
                        $image_coutn_02 = 1;
                    } else {
                        $image_coutn_02 = 0;
                    }
                    if (!empty($fetch_listing['image_03'])) {
                        $image_coutn_03 = 1;
                    } else {
                        $image_coutn_03 = 0;
                    }
                    if (!empty($fetch_listing['image_04'])) {
                        $image_coutn_04 = 1;
                    } else {
                        $image_coutn_04 = 0;
                    }
                    if (!empty($fetch_listing['image_05'])) {
                        $image_coutn_05 = 1;
                    } else {
                        $image_coutn_05 = 0;
                    }

                    $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);
            ?>
                    <!-- Componente - Caja -->
                    <div class="box">
                        <!-- Componente - Miniatura -->
                        <div class="thumb">
                            <p><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
                            <img src="../uploaded_files/<?= $fetch_listing['image_01']; ?>" alt="Anuncio">
                        </div>
                        <!-- Elementos -->
                        <p class="price"><i class="fas fa-dollar-sign"></i><?= $fetch_listing['price']; ?></p>
                        <h3 class="name"><?= $fetch_listing['property_name']; ?></h3>
                        <p class="location"><i class="fas fa-map-marker-alt"></i><?= $fetch_listing['address']; ?></p>
                        <!-- Componente - Formulario -->
                        <form action="" method="POST">
                            <input type="hidden" name="delete_id" value="<?= $listing_id; ?>">
                            <a href="view_property.php?get_id=<?= $listing_id; ?>" class="btn">Ver anuncio</a>
                            <input type="submit" value="Borrar anuncio" onclick="return confirm('¿Desea borrar el anuncio?');" name="delete" class="delete-btn">
                        </form>
                    </div>
            <?php
                }
            } elseif (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                echo '<p class="empty">No se encontró ningún anuncio.</p>';
            } else {
                echo '<p class="empty">No hay anuncios publicados.</p>';
            }
            ?>
        </div>
    </section>
    <!-- Componente - Anuncios - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="../js/admin_script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

</body>

</html>
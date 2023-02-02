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

// -- Eliminar Anuncio
if (isset($_POST['delete'])) {
    // -- Variables POST
    $delete_id = $_POST['property_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    // -- Consulta a BD - Eliminar
    $verify_delete = $conn->prepare(
        "SELECT * 
        FROM `property` 
        WHERE id = ?"
    );
    $verify_delete->execute([$delete_id]);
    // -- Validar datos con ID de la propiedad seleccionada
    if ($verify_delete->rowCount() > 0) {
        // -- Consulta a la BD - Eliminar imágenes relacionadas
        $select_images = $conn->prepare(
            "SELECT * 
            FROM `property` 
            WHERE id = ?"
        );
        $select_images->execute([$delete_id]);
        // -- Selección de imágenes y desvincularlas de la carpeta contenedora
        while ($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)) {
            $image_01 = $fetch_images['image_01'];
            $image_02 = $fetch_images['image_02'];
            $image_03 = $fetch_images['image_03'];
            $image_04 = $fetch_images['image_04'];
            $image_05 = $fetch_images['image_05'];
            unlink('uploaded_files/' . $image_01);
            if (!empty($image_02)) {
                unlink('uploaded_files/' . $image_02);
            }
            if (!empty($image_03)) {
                unlink('uploaded_files/' . $image_03);
            }
            if (!empty($image_04)) {
                unlink('uploaded_files/' . $image_04);
            }
            if (!empty($image_05)) {
                unlink('uploaded_files/' . $image_05);
            }
        }
        // -- Eliminar anuncios guardados, peticiones y propiedad de la BD
        $delete_saved = $conn->prepare(
            "DELETE FROM `saved` 
            WHERE property_id = ?"
        );
        $delete_saved->execute([$delete_id]);
        $delete_requests = $conn->prepare(
            "DELETE FROM `requests` 
            WHERE property_id = ?"
        );
        $delete_requests->execute([$delete_id]);
        $delete_listing = $conn->prepare(
            "DELETE FROM `property` 
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
    <title>Real Estate Lima - Mis Anuncios</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Mis Anuncios - Inicio -->
    <section class="my-listings">
        <!-- Título -->
        <h1 class="heading">Mis Anuncios</h1>
        <!-- Componente - Caja principal -->
        <div class="box-container">
            <?php
            // -- Contador de imágenes
            $total_images = 0;
            // -- Consulta de propiedad publicada
            $select_properties = $conn->prepare(
                "SELECT *
                FROM `property`
                WHERE user_id = ?
                ORDER BY date
                DESC"
            );
            $select_properties->execute([$user_id]);
            // -- Sì existen propiedades mostrarlas
            if ($select_properties->rowCount() > 0) {
                while ($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)) {
                    $property_id = $fetch_property['id'];
                    // -- Cambiamos el orden de las imágenes en caso no se completen
                    if (!empty($fetch_property['image_02'])) {
                        $image_coutn_02 = 1;
                    } else {
                        $image_coutn_02 = 0;
                    }
                    if (!empty($fetch_property['image_03'])) {
                        $image_coutn_03 = 1;
                    } else {
                        $image_coutn_03 = 0;
                    }
                    if (!empty($fetch_property['image_04'])) {
                        $image_coutn_04 = 1;
                    } else {
                        $image_coutn_04 = 0;
                    }
                    if (!empty($fetch_property['image_05'])) {
                        $image_coutn_05 = 1;
                    } else {
                        $image_coutn_05 = 0;
                    }

                    $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);
            ?>
                    <!-- Formulario - Diseño de propiedad en venta -->
                    <form action="" method="post" class="box">
                        <input type="hidden" name="property_id" value="<?= $property_id; ?>">
                        <!-- Imágenes -->
                        <div class="thumb">
                            <p><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
                            <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
                        </div>
                        <!-- Precio -->
                        <div class="price"><i class="fas fa-dollar-sign"></i><span><?= $fetch_property['price']; ?></span></div>
                        <!-- Título -->
                        <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
                        <!-- Localización -->
                        <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
                        <!-- Componente flexible -->
                        <div class="flex-btn">
                            <a href="update_property.php?get_id=<?= $property_id; ?>" class="btn">Actualizar</a>
                            <input type="submit" name="delete" value="Borrar" class="btn" onclick="return confirm('¿Desea borrar este anuncio?');">
                        </div>
                        <!-- Ver propiedad -->
                        <a href="view_property.php?get_id=<?= $property_id; ?>" class="btn">Ver anuncio</a>
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no has creado ningún anuncio! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">publica uno.</a></p>';
            }
            ?>
        </div>
    </section>
    <!-- Sección Mis Anuncios - Inicio -->

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
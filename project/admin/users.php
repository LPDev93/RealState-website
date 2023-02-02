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

//-- Acción - Eliminar usuario
if (isset($_POST['delete'])) {
    //-- Variables POST
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    //-- Consulta - Usuarios por ID
    $verify_delete = $conn->prepare(
        "SELECT * 
        FROM `users` 
        WHERE id = ?"
    );
    $verify_delete->execute([$delete_id]);
    //-- Sí haya una incidencia
    if ($verify_delete->rowCount() > 0) {
        //-- Consulta - Todas las imágenes de la propiedad según ID de usuario
        $select_images = $conn->prepare(
            "SELECT * 
            FROM `property` 
            WHERE user_id = ?"
        );
        $select_images->execute([$delete_id]);
        //-- Captura - Imágenes de las propiedad o anuncio
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
        //-- Consultas - Eliminamos propiedades, consultas, favoritos y al usuario
        $delete_listings = $conn->prepare(
            "DELETE 
            FROM `property` 
            WHERE user_id = ?"
        );
        $delete_listings->execute([$delete_id]);
        $delete_requests = $conn->prepare(
            "DELETE 
            FROM `requests` 
            WHERE sender = ? 
            OR receiver = ?"
        );
        $delete_requests->execute([$delete_id, $delete_id]);
        $delete_saved = $conn->prepare(
            "DELETE 
            FROM `saved` 
            WHERE user_id = ?"
        );
        $delete_saved->execute([$delete_id]);
        $delete_user = $conn->prepare(
            "DELETE 
            FROM `users` 
            WHERE id = ?"
        );
        $delete_user->execute([$delete_id]);
        $success_msg[] = 'Usuario eliminado';
    } else {
        $warning_msg[] = 'El usuario ya ha sido eliminado';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Admin - Usuarios</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Componente - Usuarios - Inicio -->
    <section class="grid">
        <!-- Título -->
        <h1 class="heading">Usuarios</h1>
        <!-- Componente - formulario -->
        <form action="" method="POST" class="search-form">
            <input type="text" name="search_box" placeholder="Buscar usuarios..." maxlength="100" required>
            <button type="submit" class="fas fa-search" name="search_btn"></button>
        </form>
        <!-- Componete - Contenedor -->
        <div class="box-container">
            <?php
            //-- Sí se encuentra incidencias
            if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                //-- Variables POST
                $search_box = $_POST['search_box'];
                $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
                //-- Consulta - Datos de usuarios filtrados
                $select_users = $conn->prepare(
                    "SELECT * 
                    FROM `users` 
                    WHERE name 
                    LIKE '%{$search_box}%' 
                    OR number
                    LIKE '%{$search_box}%' 
                    OR email 
                    LIKE '%{$search_box}%'"
                );
                $select_users->execute();
            } else {
                //-- Consulta - Datos de usuarios
                $select_users = $conn->prepare(
                    "SELECT * 
                    FROM `users`"
                );
                $select_users->execute();
            }
            //-- Si hay incidencias encontradas
            if ($select_users->rowCount() > 0) {
                //-- Captura de datos del usuario
                while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                    //-- Consulta - Datos de la propiedad
                    $count_property = $conn->prepare(
                        "SELECT * 
                        FROM `property` 
                        WHERE user_id = ?"
                    );
                    $count_property->execute([$fetch_users['id']]);
                    //-- Contar propiedades
                    $total_properties = $count_property->rowCount();
            ?>
                    <!-- Componente - Caja -->
                    <div class="box">
                        <!-- Elementos -->
                        <p>Nombre : <span><?= $fetch_users['name']; ?></span></p>
                        <p>Número : <a href="tel:<?= $fetch_users['number']; ?>"><?= $fetch_users['number']; ?></a></p>
                        <p>Correo : <a href="mailto:<?= $fetch_users['email']; ?>"><?= $fetch_users['email']; ?></a></p>
                        <p>Cantidad de anuncios : <span><?= $total_properties; ?></span></p>
                        <!-- Componente - Formulario -->
                        <form action="" method="POST">
                            <input type="hidden" name="delete_id" value="<?= $fetch_users['id']; ?>">
                            <input type="submit" value="delete user" onclick="return confirm('¿Desea eliminar al usuario?');" name="delete" class="delete-btn">
                        </form>
                    </div>
            <?php
                }
            } elseif (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                echo '<p class="empty">No se encontraron usuarios.</p>';
            } else {
                echo '<p class="empty">No hay usuarios registrados aún.</p>';
            }
            ?>
        </div>
    </section>
    <!-- Componente - Usuarios - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="../js/admin_script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

</body>

</html>
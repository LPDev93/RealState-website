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

//-- Validar - Botón de eliminar mensaje accionado
if (isset($_POST['delete'])) {
    //-- Variables POST
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    //-- Consulta - Seleccionar mensaje cuyo ID corresponda a la variable capturada
    $verify_delete = $conn->prepare(
        "SELECT * 
        FROM `messages` 
        WHERE id = ?"
    );
    $verify_delete->execute([$delete_id]);
    //-- Validación - Sí se encuentra incidencia
    if ($verify_delete->rowCount() > 0) {
        $delete_bookings = $conn->prepare(
            "DELETE 
            FROM `messages` 
            WHERE id = ?"
        );
        $delete_bookings->execute([$delete_id]);
        $success_msg[] = 'Mensaje eliminado.';
    } else {
        $warning_msg[] = 'El mensaje que intenta eliminar no existe.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Admin - Mensajes</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Componente - Mensajes - Inicio -->
    <section class="grid">
        <!-- Título -->
        <h1 class="heading">Mensajes</h1>
        <!-- Componete - Formulario -->
        <form action="" method="POST" class="search-form">
            <input type="text" name="search_box" placeholder="Buscar mensajes..." maxlength="100" required>
            <button type="submit" class="fas fa-search" name="search_btn"></button>
        </form>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <?php
            //-- Validar - Botón buscar sea accionado
            if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                //-- Variables POST
                $search_box = $_POST['search_box'];
                $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
                //-- Consultar - Mensajes según filtro de búsqueda
                $select_messages = $conn->prepare(
                    "SELECT * 
                    FROM `messages` 
                    WHERE name 
                    LIKE '%{$search_box}%'
                    OR number 
                    LIKE '%{$search_box}%' 
                    OR email 
                    LIKE '%{$search_box}%'
                    OR message 
                    LIKE '%{$search_box}%'"
                );
                $select_messages->execute();
            } else {
                //-- Consultar - Todos los mensajes
                $select_messages = $conn->prepare(
                    "SELECT * 
                    FROM `messages`"
                );
                $select_messages->execute();
            }
            //-- Validar - Sí existen incidencias
            if ($select_messages->rowCount() > 0) {
                //-- Capturar - Datos de los mensajes
                while ($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <p>Nombre : <span><?= $fetch_messages['name']; ?></span></p>
                        <p>Correo : <a href="mailto:<?= $fetch_messages['email']; ?>"><?= $fetch_messages['email']; ?></a></p>
                        <p>Número : <a href="tel:<?= $fetch_messages['number']; ?>"><?= $fetch_messages['number']; ?></a></p>
                        <p>Mensaje : <span><?= $fetch_messages['message']; ?></span></p>
                        <form action="" method="POST">
                            <input type="hidden" name="delete_id" value="<?= $fetch_messages['id']; ?>">
                            <input type="submit" value="Borrar mensaje" onclick="return confirm('delete this message?');" name="delete" class="delete-btn">
                        </form>
                    </div>
            <?php
                }
            } elseif (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                echo '<p class="empty">No se puedo encontrar ese mensaje.</p>';
            } else {
                echo '<p class="empty">No hay ningún mensaje.</p>';
            }
            ?>
        </div>
    </section>
    <!-- Componente - Mensajes - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="../js/admin_script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

</body>

</html>
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

//-- Eliminar solicitud recibida
if (isset($_POST['delete'])) {
    //-- Variables POST
    $delete_id = $_POST['request_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    //-- Obtener datos de la solicitud a eliminar
    $verify_delete = $conn->prepare(
        "SELECT *
        FROM `requests`
        WHERE id = ?"
    );
    $verify_delete->execute([$delete_id]);
    //-- Sí existen incidencias
    if ($verify_delete->rowCount() > 0) {
        //-- Eliminamos incidencia según ID
        $delete_request = $conn->prepare(
            "DELETE 
            FROM `requests` 
            WHERE id = ?"
        );
        $delete_request->execute([$delete_id]);
        $success_msg[] = 'Solicitud eliminada.';
        header('refresh:2;url=requests.php');
    } else {
        $warning_msg[] = 'La solicitud ya ha sido eliminada.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Solicitudes Recibidas</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Peticiones - Inicio -->
    <section class="requests">
        <!-- Título -->
        <h1 class="heading">Solicitudes</h1>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <?php
            //-- Consultar datos del usuario que recibe la solicitud
            $select_requests = $conn->prepare(
                "SELECT *
                FROM `requests`
                WHERE receiver = ?"
            );
            $select_requests->execute([$user_id]);
            //-- Sí encontramos incidencias en la BD
            if ($select_requests->rowCount() > 0) {
                while ($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)) {
                    //-- Obtener datos del usuario que envía la solicitud
                    $select_sender = $conn->prepare(
                        "SELECT *
                        FROM `users`
                        WHERE id = ?"
                    );
                    $select_sender->execute([$fetch_request['sender']]);
                    $fetch_sender = $select_sender->fetch(PDO::FETCH_ASSOC);
                    //-- Obtener datos de la propiedad a consultar
                    $select_property = $conn->prepare(
                        "SELECT *
                        FROM `property`
                        WHERE id = ?"
                    );
                    $select_property->execute([$fetch_request['property_id']]);
                    $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);
            ?>
                    <!-- Componente - Caja -->
                    <div class="box">
                        <p>Nombre: <span><?= $fetch_sender['name']; ?></span></p>
                        <p>Número : <a href="tel:<?= $fetch_sender['number']; ?>"><?= $fetch_sender['number']; ?></a></p>
                        <p>Correo : <a href="mailto:<?= $fetch_sender['email']; ?>"><?= $fetch_sender['email']; ?></a></p>
                        <p>Consulta para : <span><?= $fetch_property['property_name']; ?></span></p>
                        <!-- Componente - Formulario -->
                        <form action="" method="post">
                            <input type="hidden" name="request_id" value="<?= $fetch_request['id']; ?>">
                            <input type="submit" name="delete" value="Eliminar solicitud" class="btn" onclick="return confirm('¿Desea eliminar está solicitud?');">
                            <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">Ver propiedad</a>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No tienes solicitudes nuevas</p>';
            }
            ?>
        </div>
    </section>
    <!-- Sección Peticiones - Inicio -->

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
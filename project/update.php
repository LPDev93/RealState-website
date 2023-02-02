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

// -- Obtención de datos de usuario actual
$select_user = $conn->prepare(
    "SELECT * 
    FROM `users` 
    WHERE id = ? 
    LIMIT 1"
);
$select_user->execute([$user_id]);
$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

// -- Validación de variables _POST
if (isset($_POST['submit'])) {
    // -- Variables _POST
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    // -- 'Empty pass' es contraseña un string vacío para realizar validaciones
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $fetch_user['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);
    // -- Validación de datos - Nombre
    if (!empty($name)) {
        $update_name = $conn->prepare(
            "UPDATE `users`
            SET name = ?
            WHERE id = ?"
        );
        $update_name->execute([$name, $user_id]);
        $success_msg[] = 'Dato(s) actualizados correctamente.';
    }
    // -- Validación de datos - Correo
    if (!empty($email)) {
        $verify_email = $conn->prepare(
            "SELECT email
            FROM `users`
            WHERE email = ?"
        );
        $verify_email->execute([$email]);
        // -- Validar que el correo no esté tomado
        if ($verify_email->rowCount() > 0) {
            $warning_msg[] = "El correo ya ha sido registrado.";
        } else {
            $update_email = $conn->prepare(
                "UPDATE `users`
                SET email = ?
                WHERE id = ?"
            );
            $update_email->execute([$email, $user_id]);
            $success_msg[] = 'Dato(s) actualizados correctamente.';
        }
    }
    // -- Validación de datos - Número
    if (!empty($number)) {
        $verify_number = $conn->prepare(
            "SELECT number
            FROM `users`
            WHERE number = ?"
        );
        $verify_number->execute([$number]);
        // -- Validar que el número no esté tomado
        if ($verify_number->rowCount() > 0) {
            $warning_msg[] = 'El número ya ha sido registrado.';
        } else {
            $update_number = $conn->prepare(
                "UPDATE `users`
                SET number = ?
                WHERE id = ?"
            );
            $update_number->execute([$number, $user_id]);
            $success_msg[] = 'Dato(s) actualizados correctamente.';
        }
    }
    // -- Validación de datos - Contraseña    
    // -- Validar que contraseña antigua no sea igual a un texto vacío
    if ($old_pass != $empty_pass) {
        // -- Validar que contaseña antigua no haya sido alterada
        if ($old_pass != $prev_pass) {
            $warning_msg[] = 'La contraseña actual ingresada no es la correcta.';
        } elseif ($new_pass != $c_pass) {
            // -- Sí la contraseña nueva no es la misma al confirmarse
            $warning_msg[] = 'Debes confirmar la nueva contraseña';
        } else {
            // -- Validar que la nueva contraseña no sea un texto vacío
            if ($new_pass != $empty_pass) {
                $update_pass = $conn->prepare(
                    "UPDATE `users`
                    SET password = ?
                    WHERE id = ?"
                );
                $update_pass->execute([$c_pass, $user_id]);
                $success_msg[] = 'Dato(s) actualizados correctamente.';
            } else {
                $warning_msg[] = 'Por favor, ingresa una contraseña nueva.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Actualizar</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Actualizar - Inicio -->
    <section class="form-container">
        <!-- Formulario de credenciales -->
        <form action="" method="post">
            <!-- Título -->
            <h3>Actualizar datos</h3>
            <!-- Datos requeridos -->
            <input type="text" name="name" maxlength="50" placeholder="<?= $fetch_user['name']; ?>" class="box">
            <input type="email" name="email" maxlength="50" placeholder="<?= $fetch_user['email']; ?>" class="box">
            <input type="number" name="number" min="0" max="999999999" maxlength="9" placeholder="<?= $fetch_user['number']; ?>" class="box">
            <input type="password" name="old_pass" maxlength="20" placeholder="Contraseña antigua" class="box">
            <input type="password" name="new_pass" maxlength="20" placeholder="Contraseña nueva" class="box">
            <input type="password" name="c_pass" maxlength="20" placeholder="Confirmar contraseña nueva" class="box">
            <input type="submit" value="Actualizar datos" name="submit" class="btn">
        </form>
    </section>
    <!-- Sección Actualizar - Fin -->

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
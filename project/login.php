<?php

/* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
 --------------------------------
 Valores de prueba:
 Correo     : prueba@gmail.com
 Contraseña : 123
============================== */

// -- Clases incluidas
include 'components/connect.php';

// -- Validación de Inicio de sesión
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

// -- Validación de variables _POST
if (isset($_POST['submit'])) {
    // -- Variables _POST       
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    // -- Consulta a la BD a partir del correo existente
    $select_users = $conn->prepare(
        "SELECT *
        FROM `users`
        WHERE email = ?
        AND password = ?
        LIMIT 1"
    );
    $select_users->execute([$email, $pass]);
    $row = $select_users->fetch(PDO::FETCH_ASSOC);
    // -- Validación de credenciales existentes
    if ($select_users->rowCount() > 0) {
        // -- Guarda ID en las cookies como 'user_id'
        setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        $success_msg[] = '¡Hola de nuevo ' . $row['name'] . '!';
        header('refresh:2;url=home.php');
    } else {
        $warning_msg[] = "Correo y/o contraseña incorrecto.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Ingresar</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Ingresar - Inicio -->
    <section class="form-container">
        <!-- Formulario de credenciales -->
        <form action="" method="post">
            <!-- Título -->
            <h3>¡Bienvenido!</h3>
            <!-- Datos requeridos -->
            <input type="email" name="email" required maxlength="50" placeholder="Correo" class="box">
            <input type="password" name="pass" required maxlength="20" placeholder="Contraseña" class="box">
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
            <input type="submit" value="Ingresar" name="submit" class="btn">
        </form>
    </section>
    <!-- Sección Ingresar - Fin -->

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
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

// -- Validación de variables _POST
if (isset($_POST['submit'])) {
    // -- Variables _POST
    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);
    // -- Consulta a la BD a partir del correo existente
    $select_users = $conn->prepare(
        "SELECT *
        FROM `users`
        WHERE email = ?"
    );
    $select_users->execute([$email]);
    // -- Validación de credenciales existentes - Creación de usuario en la BD
    if ($select_users->rowCount() > 0) {
        $warning_msg[] = "El correo ya ha sido registrado.";
    } else {
        if ($pass != $c_pass) {
            $warning_msg[] = "Las contraseñas no coinciden.";
        } else {
            $insert_user = $conn->prepare(
                "INSERT INTO `users` (id, name, number, email, password)
                VALUES (?, ?, ?, ?, ?)"
            );
            $insert_user->execute([$id, $name, $number, $email, $c_pass]);
            // -- Validación de acceso
            if ($insert_user) {
                $verify_users = $conn->prepare(
                    "SELECT *
                    FROM `users`
                    WHERE email = ?
                    AND password = ?
                    LIMIT 1"
                );
                $verify_users->execute([$email, $c_pass]);
                $row = $verify_users->fetch(PDO::FETCH_ASSOC);
                // -- Redirecionamiento a home
                if ($verify_users->rowCount() > 0) {
                    // -- Guarda ID en las cookies como 'user_id'
                    setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
                    $success_msg[] = '¡Has creado una cuenta!';
                    header('refresh:2;url=home.php');
                } else {
                    $error_msg[] = "Alguien salió mal. Inténtalo de nuevo.";
                }
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
    <title>Real Estate Lima - Registro</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Registro - Inicio -->
    <section class="form-container">
        <!-- Formulario de credenciales -->
        <form action="" method="post">
            <!-- Título -->
            <h3>Crear cuenta</h3>
            <!-- Datos requeridos -->
            <input type="text" name="name" required maxlength="50" placeholder="Usuario" class="box">
            <input type="email" name="email" required maxlength="50" placeholder="Correo" class="box">
            <input type="number" name="number" required min="0" max="999999999" maxlength="9" placeholder="Celular" class="box">
            <input type="password" name="pass" required maxlength="20" placeholder="Contraseña" class="box">
            <input type="password" name="c_pass" required maxlength="20" placeholder="Confirmar contraseña" class="box">
            <p>¿Ya tienes una cuenta? <a href="login.html">Ingresa</a></p>
            <input type="submit" value="Confirmar" name="submit" class="btn">
        </form>
    </section>
    <!-- Sección Registro - Fin -->

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
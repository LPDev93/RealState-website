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

//-- Validación de registro
if (isset($_POST['submit'])) {
    //-- Variables POST
    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);
    //-- Consultamos datos de los administradores según usuario
    $select_admins = $conn->prepare(
        "SELECT * 
        FROM `admins` 
        WHERE name = ?"
    );
    $select_admins->execute([$name]);
    //-- Validación incidenias duplicadas
    if ($select_admins->rowCount() > 0) {
        $warning_msg[] = 'El usuario ya existe.';
    } else {
        //-- Validamos que las contraseñas ingresadas sean iguales
        if ($pass != $c_pass) {
            $warning_msg[] = 'Las contraseñas no son las mismas';
        } else {
            //-- Creación de la cuenta nueva
            $insert_admin = $conn->prepare(
                "INSERT
                INTO `admins`(id, name, password)
                VALUES (?, ?, ?)"
            );
            $insert_admin->execute([
                $id,
                $name,
                $c_pass
            ]);
            $success_msg[] = '¡Registro completo!';
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
    <title>Real Estate Lima - Admin - Registro</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
    <!-- Componente - Cabecera -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Componente - Registro - Inicio -->
    <section class="form-container">
        <!-- Componente - Formulario -->
        <form action="" method="post">
            <!-- Título -->
            <h3>Crear cuenta</h3>
            <input type="text" name="name" placeholder="Usuario" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" placeholder="Contraseña" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="c_pass" placeholder="Confirmar contraseña" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Registrarse" name="submit" class="btn">
        </form>
    </section>
    <!-- Componente - Registro - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="../js/admin_script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

</body>

</html>
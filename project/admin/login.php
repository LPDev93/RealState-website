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

//-- Validación de ingreso
if (isset($_POST['submit'])) {
    //-- Variables POST
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    //-- Consultamos datos de los administradores según usuario y contraseña
    $select_admins = $conn->prepare(
        "SELECT * 
        FROM `admins` 
        WHERE name = ? 
        AND password = ? 
        LIMIT 1"
    );
    $select_admins->execute([$name, $pass]);
    //-- Capturamos datos de las incidencias encontradas
    $row = $select_admins->fetch(PDO::FETCH_ASSOC);
    //-- Validación de datos ingresados
    if ($select_admins->rowCount() > 0) {
        //-- Sí encuentra una incidencia se guarda el ID del usuario en las Cookies locales
        setcookie('admin_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        header('location:dashboard.php');
    } else {
        $warning_msg[] = 'Credenciales no válidas. Inténtalo de nuevo.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Admin - Ingreso</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body style="padding-left: 0;">

    <!-- Componente - Login - Inicio -->
    <section class="form-container" style="min-height: 100vh;">
        <!-- Componente - Formulario -->
        <form action="" method="post">
            <!-- Título -->
            <h3>¡Bienvenido!</h3>
            <p>usuario de prueba = <span>admin</span> & contraseña = <span>111</span></p>
            <input type="text" name="name" placeholder="Usuario" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" placeholder="Contraseña" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Ingresar" name="submit" class="btn">
        </form>
    </section>
    <!-- Componente - Login - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

</body>

</html>
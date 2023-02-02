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

//-- Capturamos datos del usuario actual
$select_profile = $conn->prepare(
    "SELECT * 
    FROM `admins` 
    WHERE id = ? 
    LIMIT 1"
);
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

//-- Validación de actualización
if (isset($_POST['submit'])) {
    //-- Variables POST    
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $fetch_profile['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);
    //-- Validamos usuario actual vs nuevo
    if (!empty($name)) {
        //-- Consultamos datos de los admins actuales
        $verify_name = $conn->prepare(
            "SELECT * 
            FROM `admins` 
            WHERE name = ?"
        );
        $verify_name->execute([$name]);
        //-- Validamos que no existan incidencias duplicadas
        if ($verify_name->rowCount() > 0) {
            $warning_msg[] = 'El usario ya está tomado.';
        } else {
            //-- Se actualzia el usuario
            $update_name = $conn->prepare(
                "UPDATE `admins` 
                SET name = ? 
                WHERE id = ?"
            );
            $update_name->execute([$name, $admin_id]);
            $success_msg[] = 'Se ha actualizaron los datos';
        }
    }
    //-- Validamos contraseña actual vs nueva
    if ($old_pass != $empty_pass) {
        //-- Validamos que la contraseña actual sea igual a la ingresada
        if ($old_pass != $prev_pass) {
            $warning_msg[] = '¡La contraseña ingresada no es la correcta!';
        } elseif ($c_pass != $new_pass) {
            $warning_msg[] = 'Las contraseñas nuevas no son iguales.';
        } else {
            //-- Validamos que la contraseña nueva no sea igual a vacío
            if ($new_pass != $empty_pass) {
                $update_password = $conn->prepare(
                    "UPDATE `admins`
                    SET password = ?
                    WHERE id = ?"
                );
                $update_password->execute([$c_pass, $admin_id]);
                $success_msg[] = 'Se ha actualizaron los datos';
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
    <title>Real Estate Lima - Admin - Actualizar Datos</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
    <!-- Componente - Cabecera -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Componente - Login - Inicio -->
    <section class="form-container">
        <!-- Componente - Formulario -->
        <form action="" method="post">
            <!-- Título -->
            <h3>Actualizar Datos</h3>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="old_pass" placeholder="Contraseña antigua" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" placeholder="Contraseña nueva" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="c_pass" placeholder="Confirmar contraseña" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Actualizar datos" name="submit" class="btn">
        </form>
    </section>
    <!-- Componente - Login - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="../js/admin_script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

</body>

</html>
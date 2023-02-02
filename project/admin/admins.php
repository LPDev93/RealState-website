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

//-- Acción - Eliminar usuario admin
if (isset($_POST['delete'])) {
    //-- Variables POST
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    //-- Consulta a BD - Buscar usuarios admins según ID
    $verify_delete = $conn->prepare(
        "SELECT * 
        FROM `admins` 
        WHERE id = ?"
    );
    $verify_delete->execute([$delete_id]);
    //-- Condicional - Sí se haya incidencias previas
    if ($verify_delete->rowCount() > 0) {
        //-- Consulta a BD - Elimina el usuario admin según el ID capturado
        $delete_admin = $conn->prepare(
            "DELETE 
            FROM `admins` 
            WHERE id = ?"
        );
        $delete_admin->execute([$delete_id]);
        $success_msg[] = 'Administrador eliminado.';
    } else {
        $warning_msg[] = 'El administrador ya ha sido eliminado.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Admin - Admins</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Componente - Admins - Inicio -->
    <section class="grid">
        <!-- Título -->
        <h1 class="heading">administradores</h1>
        <!-- Componente - formulario -->
        <form action="" method="POST" class="search-form">
            <input type="text" name="search_box" placeholder="Buscar administradores..." maxlength="100" required>
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
                //-- Consulta - Datos de usuarios admins filtrados
                $select_admins = $conn->prepare(
                    "SELECT * 
                    FROM `admins` 
                    WHERE name 
                    LIKE '%{$search_box}%'"
                );
                $select_admins->execute();
            } else {
                //-- Consulta - Datos de usuarios admins
                $select_admins = $conn->prepare(
                    "SELECT * 
                    FROM `admins`"
                );
                $select_admins->execute();
            }
            //-- Si hay incidencias encontradas
            if ($select_admins->rowCount() > 0) {
                //-- Captura de datos del usuario admins
                while ($fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <?php if ($fetch_admins['id'] == $admin_id) { ?>
                        <div class="box" style="order: -1;">
                            <p>Nombre : <span><?= $fetch_admins['name']; ?></p>
                            <a href="update.php" class="option-btn">Actualizar datos</a>
                            <a href="register.php" class="btn">Registrar nuevo</a>
                        </div>
                    <?php } else { ?>
                        <div class="box">
                            <p>Nombre : <span><?= $fetch_admins['name']; ?></p>
                            <form action="" method="POST">
                                <input type="hidden" name="delete_id" value="<?= $fetch_admins['id']; ?>">
                                <input type="submit" value="Eliminar cuenta" onclick="return confirm('¿Desea borrar administrador?');" name="delete" class="<?php if ($fetch_admins['id']  == "BcjKNX58e4x7bIqIvxG7") { ?> delete-btn disabled <?php  } else { ?> delete-btn <?php } ?>">
                            </form>
                        </div>
                    <?php } ?>
                <?php
                }
            } elseif (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                echo '<p class="empty">No se encontraron usuarios.</p>';
            }
            //-- Validación - Crear administradores secundarios
            if ($admin_id == 'BcjKNX58e4x7bIqIvxG7' and !($select_admins->rowCount() > 1)) {
                ?>
                <div class="flex">
                    <div class="box" style="text-align: center;">
                        <p class="empty" style="color: red;">No hay administradores secundarios todavía</p>
                        <a href="register.php" class="btn">¿Crear un administrador nuevo?</a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
    <!-- Componente - Admins - Fin -->

    <!-- Sweet Alert CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- JavaScript personalizado -->
    <script src="../js/admin_script.js"></script>

    <!-- Componente - Mensajes personalizados -->
    <?php include '../components/message.php'; ?>

</body>

</html>
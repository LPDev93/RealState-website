<?php

/* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
============================== */

?>

<header class="header">
    <!-- Componente - Botón -->
    <div id="close-btn"><i class="fas fa-times"></i></div>
    <!-- Elemento - Logo -->
    <a href="dashboard.php" class="logo">AdminPanel.</a>
    <!-- Componente - Barra de navegación -->
    <nav class="navbar">
        <a href="dashboard.php"><i class="fas fa-home"></i><span>Inicio</span></a>
        <a href="listings.php"><i class="fas fa-building"></i><span>Anuncios</span></a>
        <a href="users.php"><i class="fas fa-user"></i><span>Usuarios</span></a>
        <a href="admins.php"><i class="fas fa-user-gear"></i><span>Admins</span></a>
        <a href="messages.php"><i class="fas fa-message"></i><span>Mensajes</span></a>
    </nav>
    <!-- Elemento - Actualizar cuenta -->
    <a href="update.php" class="btn">Actualizar cuenta</a>
    <!-- Componente - Flex -->
    <div class="flex-btn">
        <a href="login.php" class="option-btn">Ingresar</a>
        <a href="register.php" class="option-btn">Registro</a>
    </div>
    <!-- Elemento - Salir cuenta -->
    <a href="../components/admin_logout.php" onclick="return confirm('¿Deseas cerrar sesión?');" class="delete-btn"><i class="fas fa-right-from-bracket"></i><span>Cerrar sesión</span></a>
</header>

<!-- Componente - Botón -->
<div id="menu-btn" class="fas fa-bars"></div>
<!-- /* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
============================== */ -->

<header class="header">
    <!-- Barra de navegación Derecha -->
    <nav class="navbar nav-1">
        <!-- Componente flexible -->
        <section class="flex">
            <!-- Enlace - Logo -->
            <a href="home.php" class="logo">
                <i class="fas fa-house"></i>
                V.I.P.
            </a>
            <!-- Lista de acciones -->
            <ul>
                <!-- Opción #01 -->
                <li>
                    <a href="post_property.php">
                        Publicar vivienda
                        <i class="fas fa-paper-plane"></i>
                    </a>
                </li>
            </ul>
        </section>
    </nav>
    <!-- Barra de navegación Izquierda -->
    <nav class="navbar nav-2">
        <!-- Componente flexible -->
        <section class="flex">
            <!-- Componente menú - Móvil -->
            <div id="menu-btn" class="fas fa-bars"></div>
            <!-- Componente menú opciones - Escritorio -->
            <div class="menu">
                <!-- Lista de acciones -->
                <ul>
                    <!-- Opción #01 -->
                    <?php if ($user_id != '') { ?>
                        <li>

                            <!-- Enlace padre - Mis anuncios -->
                            <a href="#">
                                Mis anuncios
                                <i class="fas fa-angle-down"></i>
                            </a>
                            <!-- Lista de acciones hija -->
                            <ul>
                                <!-- Opciones hijas -->
                                <li><a href="dashboard.php">Panel de control</a></li>
                                <li><a href="post_property.php">Publicar propiedad</a></li>
                                <li><a href="my_listings.php">Mis anuncios</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- Opción #02 -->
                    <li>
                        <!-- Enlace padre - Mis anuncios -->
                        <a href="#">
                            Busca tu hogar
                            <i class="fas fa-angle-down"></i>
                        </a>
                        <!-- Lista de acciones hija -->
                        <ul>
                            <!-- Opciones hijas -->
                            <li><a href="search.php">Búsqueda avanzada</a></li>
                            <li><a href="listings.php">Todos los anuncios</a></li>
                        </ul>
                    </li>
                    <!-- Opción #03 -->
                    <li>
                        <!-- Enlace padre - Mis anuncios -->
                        <a href="#">
                            Ayuda
                            <i class="fas fa-angle-down"></i>
                        </a>
                        <!-- Lista de acciones hija -->
                        <ul>
                            <!-- Opciones hijas -->
                            <li><a href="about.php">Nosotros</a></li>
                            <li><a href="contact.php">Contacto</a></li>
                            <li><a href="contact.php#faq">FAQ</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Lisata de acciones menú - Escritorio -->
            <ul>
                <!-- Opción #01 -->
                <?php if ($user_id != '') { ?>
                    <li>
                        <a href="saved.php">
                            Favoritos
                            <i class="far fa-heart"></i>
                        </a>
                    </li>
                <?php } ?>
                <!-- Opción #02 -->
                <li>
                    <!-- Enlace padre - Mi cuenta -->
                    <a href="#">
                        Mi cuenta
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <!-- Lista de acciones hija -->
                    <ul>
                        <!-- Opciones hijas -->
                        <?php if ($user_id == '') { ?>
                            <li><a href="login.php">Ingresar</a></li>
                            <li><a href="register.php">Registro</a></li>
                        <?php } ?>
                        <!-- Opciones condicionales - Cuenta activa -->
                        <?php if ($user_id != '') { ?>
                            <li><a href="update.php">Actualizar datos</a></li>
                            <li>
                                <a href="components/user_logout.php" onclick="return confirm('¿Deseas cerrar sesión?')">
                                    Salir
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </section>
    </nav>
</header>
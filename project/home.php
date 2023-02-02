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

// -- Clases incluidas de validacón
include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Inicio</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Inicio - Inicio -->
    <div class="home">
        <section class="center">
            <!-- Formulario de búsqueda -->
            <form action="search.php" method="post">
                <!-- Título -->
                <h3>¡Encuentra tu nuevo hogar!</h3>
                <!-- Componente - Ubicación -->
                <div class="box">
                    <p>Ingresa tu distrito <span>*</span></p>
                    <input type="text" name="h_location" required maxlength="100" placeholder="Escribe aquí" class="input">
                </div>
                <!-- Componete flexible -->
                <div class="flex">
                    <!-- Componente - Tipo de propiedad -->
                    <div class="box">
                        <p>Tipo de propiedad <span>*</span></p>
                        <select name="h_type" class="input" required>
                            <option value="flat">Departamento</option>
                            <option value="house">Casa</option>
                            <option value="shop">Comercial</option>
                        </select>
                    </div>
                    <!-- Componente - Tipo de venta -->
                    <div class="box">
                        <p>Tipo de oferta <span>*</span></p>
                        <select name="h_offer" class="input" required>
                            <option value="sale">En venta</option>
                            <option value="resale">Re-venta</option>
                            <option value="rent">Alquiler</option>
                        </select>
                    </div>
                    <!-- Componente - Presupuesto mínimo -->
                    <div class="box">
                        <p>Presupuesto mínimo <span>*</span></p>
                        <select name="h_min" class="input" required>
                            <option value="5000">5K</option>
                            <option value="10000">10K</option>
                            <option value="15000">15k</option>
                            <option value="20000">20k</option>
                            <option value="30000">30k</option>
                            <option value="40000">40k</option>
                            <option value="40000">40k</option>
                            <option value="50000">50k</option>
                            <option value="100000">100K</option>
                            <option value="200000">200K</option>
                            <option value="500000">500K</option>
                        </select>
                    </div>
                    <!-- Componente - Presupuesto máximo -->
                    <div class="box">
                        <p>Presupuesto máximo <span>*</span></p>
                        <select name="h_max" class="input" required>
                            <option value="5000">5K</option>
                            <option value="10000">10K</option>
                            <option value="15000">15k</option>
                            <option value="20000">20k</option>
                            <option value="30000">30k</option>
                            <option value="40000">40k</option>
                            <option value="40000">40k</option>
                            <option value="50000">50k</option>
                            <option value="100000">100K</option>
                            <option value="200000">200K</option>
                            <option value="500000">500K</option>
                        </select>
                    </div>
                </div>
                <!-- Bóton de búsqueda -->
                <input type="submit" value="Buscar" name="h_search" class="btn">
            </form>
        </section>
    </div>
    <!-- Sección Inicio - Fin -->

    <!-- Sección Servicios - Inicio -->
    <section class="services">
        <!-- Título -->
        <h1 class="heading">Nuestros servicios</h1>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <!-- Componente 01 -->
            <div class="box">
                <img src="images/icon-1.png" alt="">
                <h3>Compra una casa</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
            </div>
            <!-- Componente 02-->
            <div class="box">
                <img src="images/icon-2.png" alt="">
                <h3>Renta una casa</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
            </div>
            <!-- Componente 03-->
            <div class="box">
                <img src="images/icon-3.png" alt="">
                <h3>Vender una casa</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
            </div>
            <!-- Componente 04-->
            <div class="box">
                <img src="images/icon-4.png" alt="">
                <h3>Departamentos</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
            </div>
            <!-- Componente 05-->
            <div class="box">
                <img src="images/icon-5.png" alt="">
                <h3>Tiendas y supermercados</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
            </div>
            <!-- Componente 06-->
            <div class="box">
                <img src="images/icon-6.png" alt="">
                <h3>Atención las 24/7</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
            </div>
        </div>
    </section>
    <!-- Sección Servicios - Fin -->

    <!-- Sección Anuncios - Inicio -->
    <section class="listings">
        <!-- Título -->
        <h1 class="heading">¡Últimos anuncios!</h1>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <?php
            // -- Consulta a BD - Mostrar anuncios
            $total_images = 0;
            $select_properties = $conn->prepare(
                "SELECT *
                FROM `property`
                ORDER BY date
                DESC
                LIMIT 6"
            );
            $select_properties->execute();
            // -- Mostrar anuncios sí existen
            if ($select_properties->rowCount() > 0) {
                while ($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)) {
                    // -- Consultamos las propiedades por usuario
                    $select_user = $conn->prepare(
                        "SELECT *
                        FROM `users`
                        WHERE id = ?"
                    );
                    $select_user->execute([$fetch_property['user_id']]);
                    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
                    // -- Validamos que las imágenes existan
                    if (!empty($fetch_property['image_02'])) {
                        $image_count_02 = 1;
                    } else {
                        $image_count_02 = 0;
                    }
                    if (!empty($fetch_property['image_03'])) {
                        $image_count_03 = 1;
                    } else {
                        $image_count_03 = 0;
                    }
                    if (!empty($fetch_property['image_04'])) {
                        $image_count_04 = 1;
                    } else {
                        $image_count_04 = 0;
                    }
                    if (!empty($fetch_property['image_05'])) {
                        $image_count_05 = 1;
                    } else {
                        $image_count_05 = 0;
                    }
                    // -- Sumamos las imágenes totales por anuncio
                    $total_images = (1 + $image_count_02 + $image_count_03 + $image_count_04 + $image_count_05);
                    // -- Seleccionamos los anuncios guardados o favoritos
                    $select_saved = $conn->prepare(
                        "SELECT * 
                        FROM `saved` 
                        WHERE property_id = ? 
                        AND user_id = ?"
                    );
                    $select_saved->execute([$fetch_property['id'], $user_id]);
            ?>
                    <form action="" method="POST">
                        <div class="box">
                            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
                            <?php
                            if ($select_saved->rowCount() > 0) {
                            ?>
                                <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Quitar de favoritos</span></button>
                            <?php
                            } else {
                            ?>
                                <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Favorito</span></button>
                            <?php
                            }
                            ?>
                            <div class="thumb">
                                <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
                                <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
                            </div>
                            <div class="admin">
                                <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
                                <div>
                                    <p><?= $fetch_user['name']; ?></p>
                                    <span><?= $fetch_property['date']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="price"><i class="fas fa-dollar-sign"></i><span><?= $fetch_property['price']; ?></span></div>
                            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
                            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
                            <div class="flex">
                                <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
                                <p><i class="fas fa-tag"></i><span><?= $fetch_property['offer']; ?></span></p>
                                <p><i class="fas fa-bed"></i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
                                <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
                                <p><i class="fas fa-couch"></i><span><?= $fetch_property['furnished']; ?></span></p>
                                <p><i class="fas fa-maximize"></i><span><?= $fetch_property['carpet']; ?> metros cuadrados</span></p>
                            </div>
                            <div class="flex-btn">
                                <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">Ver propiedad</a>
                                <input type="submit" value="Consultar" name="send" class="btn">
                            </div>
                        </div>
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">No hay propiedades aún <a href="post_property.php" style="margin-top:1.5rem;" class="btn">añade uno.</a></p>';
            }
            ?>
        </div>
        <div style="margin-top: 2rem; text-align:center;">
            <a href="listings.php" class="inline-btn">Ver todos</a>
        </div>
    </section>
    <!-- Sección Anuncios - Fin -->

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
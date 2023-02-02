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

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Nosotros</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Nosotros - Inicio -->
    <section class="about">
        <!-- Componente - Fila -->
        <div class="row">
            <!-- Componente - Imagen -->
            <div class="image">
                <img src="images/about-img.svg" alt="Nosotros">
            </div>
            <!-- Componente - Contenido -->
            <div class="content">
                <h3>¿Porqué comprar aquí?</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum dolorem provident voluptatum distinctio laborum veritatis vitae suscipit praesentium fugiat unde?</p>
                <a href="contact.html" class="inline-btn">contact us</a>
            </div>
        </div>
    </section>
    <!-- Sección Nosotros - Inicio -->

    <!-- Sección Pasos de compra - Inicio -->
    <section class="steps">
        <!-- Título -->
        <h1 class="heading">¡3 sencillos pasos!</h1>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <!-- Componente - Caja 01 -->
            <div class="box">
                <img src="images/step-1.png" alt="">
                <h3>Buscar un anuncio</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, placeat.</p>
            </div>
            <!-- Componente - Caja 02 -->
            <div class="box">
                <img src="images/step-2.png" alt="">
                <h3>Consultar con un agente</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, placeat.</p>
            </div>
            <!-- Componente - Caja 02 -->
            <div class="box">
                <img src="images/step-3.png" alt="">
                <h3>¡Ya tienes casa nueva!</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, placeat.</p>
            </div>
        </div>
    </section>
    <!-- Sección Pasos de compra - Fin -->

    <!-- Sección comentarios - Inicio -->
    <section class="reviews">
        <!-- Título -->
        <h1 class="heading">Clientes felices</h1>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <!-- Componente - Caja 01 -->
            <div class="box">
                <!-- Componente - Perfil -->
                <div class="user">
                    <img src="images/pic-1.png" alt="Cliente">
                    <div>
                        <h3>Jhon Deo</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste fugiat facilis pariatur, ipsam vitae, incidunt ad veritatis in nostrum saepe minus veniam sunt quaerat accusantium explicabo earum modi reprehenderit vero.</p>
            </div>
            <!-- Componente - Caja 02 -->
            <div class="box">
                <!-- Componente - Perfil -->
                <div class="user">
                    <img src="images/pic-2.png" alt="Cliente">
                    <div>
                        <h3>Laura Smith</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste fugiat facilis pariatur, ipsam vitae, incidunt ad veritatis in nostrum saepe minus veniam sunt quaerat accusantium explicabo earum modi reprehenderit vero.</p>
            </div>
            <!-- Componente - Caja 03 -->
            <div class="box">
                <!-- Componente - Perfil -->
                <div class="user">
                    <img src="images/pic-3.png" alt="Cliente">
                    <div>
                        <h3>Jorge Savedra</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste fugiat facilis pariatur, ipsam vitae, incidunt ad veritatis in nostrum saepe minus veniam sunt quaerat accusantium explicabo earum modi reprehenderit vero.</p>
            </div>
            <!-- Componente - Caja 04 -->
            <div class="box">
                <!-- Componente - Perfil -->
                <div class="user">
                    <img src="images/pic-4.png" alt="Cliente">
                    <div>
                        <h3>Linda Chang</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste fugiat facilis pariatur, ipsam vitae, incidunt ad veritatis in nostrum saepe minus veniam sunt quaerat accusantium explicabo earum modi reprehenderit vero.</p>
            </div>
            <!-- Componente - Caja 05 -->
            <div class="box">
                <!-- Componente - Perfil -->
                <div class="user">
                    <img src="images/pic-5.png" alt="Cliente">
                    <div>
                        <h3>Iván Rojas</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste fugiat facilis pariatur, ipsam vitae, incidunt ad veritatis in nostrum saepe minus veniam sunt quaerat accusantium explicabo earum modi reprehenderit vero.</p>
            </div>
            <!-- Componente - Caja 06 -->
            <div class="box">
                <!-- Componente - Perfil -->
                <div class="user">
                    <img src="images/pic-6.png" alt="Cliente">
                    <div>
                        <h3>Rosa Max</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste fugiat facilis pariatur, ipsam vitae, incidunt ad veritatis in nostrum saepe minus veniam sunt quaerat accusantium explicabo earum modi reprehenderit vero.</p>
            </div>
        </div>
    </section>
    <!-- Sección comentarios - Fin -->

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
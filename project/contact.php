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

// -- Validación de Envío de mensaje
if (isset($_POST['send'])) {
    // -- Declarar variables POST
    $msg_id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $message = $_POST['message'];
    $message = filter_var($message, FILTER_SANITIZE_STRING);
    // -- Consulta BD - Comprobar mensajes
    $verify_contact = $conn->prepare(
        "SELECT * 
        FROM `messages` 
        WHERE name = ? 
        AND email = ? 
        AND number = ? 
        AND message = ?"
    );
    $verify_contact->execute([
        $name,
        $email,
        $number,
        $message
    ]);
    // -- Consulta BD - Insercción de mensaje
    $send_message = $conn->prepare(
        "INSERT 
        INTO `messages`(id, name, email, number, message) 
        VALUES(?,?,?,?,?)"
    );
    $send_message->execute([
        $msg_id,
        $name,
        $email,
        $number,
        $message
    ]);
    $success_msg[] = '¡Hemos recibido tu mensaje!';
    // -- Sí queremos limitar a un mensaje por
    // if($verify_contact->rowCount() > 0){
    //     $warning_msg[] = 'message sent already!';
    //  }else{
    //     $send_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
    //     $send_message->execute([$msg_id, $name, $email, $number, $message]);
    //     $success_msg[] = 'message send successfully!';
    //  }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Lima - Contacto</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Contacto - Inicio -->
    <section class="contact">
        <!-- Componente - Fila -->
        <div class="row">
            <!-- Componente - Imagen -->
            <div class="image">
                <img src="images/contact-img.svg" alt="Contacto">
            </div>
            <form action="" method="post">
                <h3>Comunícate con nosotros</h3>
                <input type="text" name="name" required maxlength="50" placeholder="Nombre completo" class="box">
                <input type="email" name="email" required maxlength="50" placeholder="Correo electrónico" class="box">
                <input type="number" name="number" required maxlength="10" max="999999999" min="0" placeholder="Número de contacto" class="box">
                <textarea name="message" placeholder="Escribe tu mensaje aquí" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
                <input type="submit" value="Enviar" name="send" class="btn">
            </form>
        </div>
    </section>
    <!-- Sección Contacto - Inicio -->

    <!-- Sección de FAQ - Inicio -->
    <section class="faq" id="faq">
        <!-- Título -->
        <h1 class="heading">FAQ</h1>
        <!-- Componente - Contenedor -->
        <div class="box-container">
            <!-- Componente - Caja 01 -->
            <div class="box active">
                <h3><span>¿Cómo concelar una reserva?</span><i class="fas fa-angle-down"></i></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus veritatis ducimus aut accusantium sunt error esse laborum cumque ipsum ab.</p>
            </div>
            <!-- Componente - Caja 02 -->
            <div class="box">
                <h3><span>¿Cuándo podré ver la propiedad?</span><i class="fas fa-angle-down"></i></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus veritatis ducimus aut accusantium sunt error esse laborum cumque ipsum ab.</p>
            </div>
            <!-- Componente - Caja 03 -->
            <div class="box">
                <h3><span>¿Cuánto es el IGV?</span><i class="fas fa-angle-down"></i></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus veritatis ducimus aut accusantium sunt error esse laborum cumque ipsum ab.</p>
            </div>
            <!-- Componente - Caja 04 -->
            <div class="box">
                <h3><span>¿Cómo me contactaré con los vendedores?</span><i class="fas fa-angle-down"></i></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus veritatis ducimus aut accusantium sunt error esse laborum cumque ipsum ab.</p>
            </div>
            <!-- Componente - Caja 05 -->
            <div class="box">
                <h3><span>¿Por qué mis anuncios no se muestran?</span><i class="fas fa-angle-down"></i></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus veritatis ducimus aut accusantium sunt error esse laborum cumque ipsum ab.</p>
            </div>
            <!-- Componente - Caja 06 -->
            <div class="box">
                <h3><span>¿Cómo puedo promocionar mis anuncios?</span><i class="fas fa-angle-down"></i></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus veritatis ducimus aut accusantium sunt error esse laborum cumque ipsum ab.</p>
            </div>
        </div>
    </section>

    <!-- Sección de FAQ - Fin -->

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
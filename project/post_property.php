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
if (isset($_POST['post'])) {
    // -- Variables _POST
    $id = create_unique_id();
    $property_name = $_POST['property_name'];
    $property_name = filter_var($property_name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $deposite = $_POST['deposite'];
    $deposite = filter_var($deposite, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $offer = $_POST['offer'];
    $offer = filter_var($offer, FILTER_SANITIZE_STRING);
    $type = $_POST['type'];
    $type = filter_var($type, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $furnished = $_POST['furnished'];
    $furnished = filter_var($furnished, FILTER_SANITIZE_STRING);
    $bhk = $_POST['bhk'];
    $bhk = filter_var($bhk, FILTER_SANITIZE_STRING);
    $bedroom = $_POST['bedroom'];
    $bedroom = filter_var($bedroom, FILTER_SANITIZE_STRING);
    $bathroom = $_POST['bathroom'];
    $bathroom = filter_var($bathroom, FILTER_SANITIZE_STRING);
    $balcony = $_POST['balcony'];
    $balcony = filter_var($balcony, FILTER_SANITIZE_STRING);
    $carpet = $_POST['carpet'];
    $carpet = filter_var($carpet, FILTER_SANITIZE_STRING);
    $age = $_POST['age'];
    $age = filter_var($age, FILTER_SANITIZE_STRING);
    $total_floors = $_POST['total_floors'];
    $total_floors = filter_var($total_floors, FILTER_SANITIZE_STRING);
    $room_floor = $_POST['room_floor'];
    $room_floor = filter_var($room_floor, FILTER_SANITIZE_STRING);
    $loan = $_POST['loan'];
    $loan = filter_var($loan, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    // -- Validaciones de opciones adicionales
    if (isset($_POST['lift'])) {
        $lift = $_POST['lift'];
        $lift = filter_var($lift, FILTER_SANITIZE_STRING);
    } else {
        $lift = 'no';
    }
    if (isset($_POST['security_guard'])) {
        $security_guard = $_POST['security_guard'];
        $security_guard = filter_var($security_guard, FILTER_SANITIZE_STRING);
    } else {
        $security_guard = 'no';
    }
    if (isset($_POST['play_ground'])) {
        $play_ground = $_POST['play_ground'];
        $play_ground = filter_var($play_ground, FILTER_SANITIZE_STRING);
    } else {
        $play_ground = 'no';
    }
    if (isset($_POST['garden'])) {
        $garden = $_POST['garden'];
        $garden = filter_var($garden, FILTER_SANITIZE_STRING);
    } else {
        $garden = 'no';
    }
    if (isset($_POST['water_supply'])) {
        $water_supply = $_POST['water_supply'];
        $water_supply = filter_var($water_supply, FILTER_SANITIZE_STRING);
    } else {
        $water_supply = 'no';
    }
    if (isset($_POST['power_backup'])) {
        $power_backup = $_POST['power_backup'];
        $power_backup = filter_var($power_backup, FILTER_SANITIZE_STRING);
    } else {
        $power_backup = 'no';
    }
    if (isset($_POST['parking_area'])) {
        $parking_area = $_POST['parking_area'];
        $parking_area = filter_var($parking_area, FILTER_SANITIZE_STRING);
    } else {
        $parking_area = 'no';
    }
    if (isset($_POST['gym'])) {
        $gym = $_POST['gym'];
        $gym = filter_var($gym, FILTER_SANITIZE_STRING);
    } else {
        $gym = 'no';
    }
    if (isset($_POST['shopping_mall'])) {
        $shopping_mall = $_POST['shopping_mall'];
        $shopping_mall = filter_var($shopping_mall, FILTER_SANITIZE_STRING);
    } else {
        $shopping_mall = 'no';
    }
    if (isset($_POST['hospital'])) {
        $hospital = $_POST['hospital'];
        $hospital = filter_var($hospital, FILTER_SANITIZE_STRING);
    } else {
        $hospital = 'no';
    }
    if (isset($_POST['school'])) {
        $school = $_POST['school'];
        $school = filter_var($school, FILTER_SANITIZE_STRING);
    } else {
        $school = 'no';
    }
    if (isset($_POST['market_area'])) {
        $market_area = $_POST['market_area'];
        $market_area = filter_var($market_area, FILTER_SANITIZE_STRING);
    } else {
        $market_area = 'no';
    }
    // -- Declaración de variables necesarias para insertar Imágenes
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_04 = $_FILES['image_04']['name'];
    $image_04 = filter_var($image_04, FILTER_SANITIZE_STRING);
    $image_05 = $_FILES['image_05']['name'];
    $image_05 = filter_var($image_05, FILTER_SANITIZE_STRING);
    // -- Declaramos - Tipo y ID
    $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
    $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
    $image_03_ext = pathinfo($image_03, PATHINFO_EXTENSION);
    $image_04_ext = pathinfo($image_04, PATHINFO_EXTENSION);
    $image_05_ext = pathinfo($image_05, PATHINFO_EXTENSION);
    $rename_image_01 = create_unique_id() . '.' . $image_01_ext;
    $rename_image_02 = create_unique_id() . '.' . $image_02_ext;
    $rename_image_03 = create_unique_id() . '.' . $image_03_ext;
    $rename_image_04 = create_unique_id() . '.' . $image_04_ext;
    $rename_image_05 = create_unique_id() . '.' . $image_05_ext;
    // -- Declaramos las carpetas temporales en donde se guardarán las imágenes
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
    $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
    $image_04_tmp_name = $_FILES['image_04']['tmp_name'];
    $image_05_tmp_name = $_FILES['image_05']['tmp_name'];
    // -- Declaramos el tamaño en la carpeta temporal
    $image_01_size = $_FILES['image_01']['size'];
    $image_02_size = $_FILES['image_02']['size'];
    $image_03_size = $_FILES['image_03']['size'];
    $image_04_size = $_FILES['image_04']['size'];
    $image_05_size = $_FILES['image_05']['size'];
    // -- Se indica el directorio en donde se almacenará las imágenes
    $image_01_folder = 'uploaded_files/' . $rename_image_01;
    $image_02_folder = 'uploaded_files/' . $rename_image_02;
    $image_03_folder = 'uploaded_files/' . $rename_image_03;
    $image_04_folder = 'uploaded_files/' . $rename_image_04;
    $image_05_folder = 'uploaded_files/' . $rename_image_05;
    // -- Validamos las imágenes - Imagen 02
    if (!empty($image_02)) {
        if ($image_02_size > 2000000) {
            $warning_msg[] = '¡La imagen 02 es muy pesada para subirse!';
        } else {
            move_uploaded_file($image_02_tmp_name, $image_02_folder);
        }
    } else {
        $rename_image_02 = '';
    }
    // -- Validamos las imágenes - Imagen 03
    if (!empty($image_03)) {
        if ($image_03_size > 2000000) {
            $warning_msg[] = '¡La imagen 03 es muy pesada para subirse!';
        } else {
            move_uploaded_file($image_03_tmp_name, $image_03_folder);
        }
    } else {
        $rename_image_03 = '';
    }
    // -- Validamos las imágenes - Imagen 04
    if (!empty($image_04)) {
        if ($image_04_size > 2000000) {
            $warning_msg[] = '¡La imagen 04 es muy pesada para subirse!';
        } else {
            move_uploaded_file($image_04_tmp_name, $image_04_folder);
        }
    } else {
        $rename_image_04 = '';
    }
    // -- Validamos las imágenes - Imagen 05
    if (!empty($image_05)) {
        if ($image_05_size > 2000000) {
            $warning_msg[] = '¡La imagen 05 es muy pesada para subirse!';
        } else {
            move_uploaded_file($image_05_tmp_name, $image_05_folder);
        }
    } else {
        $rename_image_05 = '';
    }
    // -- Validamos las imágenes - Imagen Portada
    // -- Está Inserción es la última, ya que debemos validar las imágenes hijas
    if ($image_01_size > 2000000) {
        $warning_msg[] = '¡La imagen de portada es muy pesada para subirse!';
    } else {
        if ($user_id != '') {
            $insert_property = $conn->prepare(
                "INSERT INTO `property`(id, user_id, property_name, address, price, type, offer, status, furnished, bhk, deposite, bedroom, bathroom, balcony, carpet, age, total_floors, room_floor, loan, lift, security_guard, play_ground, garden, water_supply, power_backup, parking_area, gym, shopping_mall, hospital, school, market_area, image_01, image_02, image_03, image_04, image_05, description)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
            );
            $insert_property->execute([
                $id,
                $user_id,
                $property_name,
                $address,
                $price,
                $type,
                $offer,
                $status,
                $furnished,
                $bhk,
                $deposite,
                $bedroom,
                $bathroom,
                $balcony,
                $carpet,
                $age,
                $total_floors,
                $room_floor,
                $loan,
                $lift,
                $security_guard,
                $play_ground,
                $garden,
                $water_supply,
                $power_backup,
                $parking_area,
                $gym,
                $shopping_mall,
                $hospital,
                $school,
                $market_area,
                $rename_image_01,
                $rename_image_02,
                $rename_image_03,
                $rename_image_04,
                $rename_image_05,
                $description
            ]);
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            $success_msg[] = 'Has publicado un anuncio.';
        } else {
            $error_msg[] = 'Tienes que ingresar a tu cuenta primero';
            header('refresh:2;url=login.php');
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
    <title>Real Estate Lima - Publicar</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Componente - Cabecera -->
    <?php include 'components/user_header.php'; ?>

    <!-- Sección Publicar propiedad - Inicio -->
    <section class="property-form">
        <!-- Formulario de credenciales -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Componente - Nombre -->
            <div class="box">
                <p>Nombre de la propiedad <span>*</span></p>
                <input type="text" name="property_name" required maxlength="50" placeholder="Escriba aquí" class="input">
            </div>
            <!-- Componente Flexible -->
            <div class="flex">
                <!-- Componente - Precio -->
                <div class="box">
                    <p>Precio <span>*</span></p>
                    <input type="number" name="price" required min="0" max="9999999999" maxlength="10" placeholder="Ingrese el monto" class="input">
                </div>
                <!-- Componente - Cuota Inicial -->
                <div class="box">
                    <p>Cuota Inicial <span>*</span></p>
                    <input type="number" name="deposite" required min="0" max="9999999999" maxlength="10" placeholder="Cuota Inicial" class="input">
                </div>
                <!-- Componente - Dirección -->
                <div class="box">
                    <p>Ubicación <span>*</span></p>
                    <input type="text" name="address" required maxlength="100" placeholder="Ubicación" class="input">
                </div>
                <!-- Componente - Tipo de venta -->
                <div class="box">
                    <p>Tipo de oferta <span>*</span></p>
                    <select name="offer" required class="input">
                        <option value="sale">En venta</option>
                        <option value="resale">Re-venta</option>
                        <option value="rent">Alquiler</option>
                    </select>
                </div>
                <!-- Componente - Tipo de propiedad -->
                <div class="box">
                    <p>Tipo de propiedad <span>*</span></p>
                    <select name="type" required class="input">
                        <option value="flat">Departamento</option>
                        <option value="house">Casa</option>
                        <option value="shop">Comercial</option>
                    </select>
                </div>
                <!-- Componente - Estado de la propiedad -->
                <div class="box">
                    <p>Estado de la propiedad <span>*</span></p>
                    <select name="status" required class="input">
                        <option value="ready to move">Habitable</option>
                        <option value="under construction">En construcción</option>
                    </select>
                </div>
                <!-- Componente - Muebles de la propiedad -->
                <div class="box">
                    <p>Estado de inmuebles <span>*</span></p>
                    <select name="furnished" required class="input">
                        <option value="furnished">Amoblada</option>
                        <option value="semi-furnished">Semi-amoblada</option>
                        <option value="unfurnished">Sin amoblar</option>
                    </select>
                </div>
                <!-- Componente - Habitaciones - Salas - Cocinas -->
                <div class="box">
                    <p>BHK <span>*</span></p>
                    <select name="bhk" required class="input">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <!-- Componente - Habitaciones -->
                <div class="box">
                    <p>Habitaciones <span>*</span></p>
                    <select name="bedroom" required class="input">
                        <option value="0">0</option>
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <!-- Componente - Baños -->
                <div class="box">
                    <p>Baños <span>*</span></p>
                    <select name="bathroom" required class="input">
                        <option value="0">0</option>
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <!-- Componente - Balcones -->
                <div class="box">
                    <p>Balcones <span>*</span></p>
                    <select name="balcony" required class="input">
                        <option value="0">0</option>
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <!-- Componente - Metros cuadrados -->
                <div class="box">
                    <p>Metros cuadrados <span>*</span></p>
                    <input type="number" name="carpet" required min="1" max="9999999999" maxlength="10" placeholder="Ingrese la medida" class="input">
                </div>
                <!-- Componente - Antigüedad -->
                <div class="box">
                    <p>Antigüedad <span>*</span></p>
                    <input type="number" name="age" required min="0" max="99" maxlength="2" placeholder="Ingrese años" class="input">
                </div>
                <!-- Componente - Pisos -->
                <div class="box">
                    <p>Pisos <span>*</span></p>
                    <input type="number" name="total_floors" required min="0" max="99" maxlength="2" placeholder="Pisos" class="input">
                </div>
                <!-- Componente - Planta baja -->
                <div class="box">
                    <p>Planta bajas <span>*</span></p>
                    <input type="number" name="room_floor" required min="0" max="99" maxlength="2" placeholder="Planta bajas" class="input">
                </div>
                <!-- Componente - Préstamo -->
                <div class="box">
                    <p>Préstamo <span>*</span></p>
                    <select name="loan" required class="input">
                        <option value="available">Habilitado</option>
                        <option value="not available">No habilitado</option>
                    </select>
                </div>
            </div>
            <!-- Componente - Descripción -->
            <div class="box">
                <p>Descripción <span>*</span></p>
                <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Acerca de la propiedad"></textarea>
            </div>
            <!-- Componente - Adicionales -->
            <div class="checkbox">
                <div class="box">
                    <p><input type="checkbox" name="lift" value="yes" />Ascensor</p>
                    <p><input type="checkbox" name="security_guard" value="yes" />Seguridad</p>
                    <p><input type="checkbox" name="play_ground" value="yes" />Parque</p>
                    <p><input type="checkbox" name="garden" value="yes" />Jardín</p>
                    <p><input type="checkbox" name="water_supply" value="yes" />Tanque de agua</p>
                    <p><input type="checkbox" name="power_backup" value="yes" />Energía de emergencia</p>
                </div>
                <div class="box">
                    <p><input type="checkbox" name="parking_area" value="yes" />Parqueo</p>
                    <p><input type="checkbox" name="gym" value="yes" />Gimnasio</p>
                    <p><input type="checkbox" name="shopping_mall" value="yes" />Centro comercial</p>
                    <p><input type="checkbox" name="hospital" value="yes" />Hospital</p>
                    <p><input type="checkbox" name="school" value="yes" />Escuela</p>
                    <p><input type="checkbox" name="market_area" value="yes" />Mercado</p>
                </div>
            </div>
            <!-- Componente - Imagen principal -->
            <div class="box">
                <p>Portada <span>*</span></p>
                <input type="file" name="image_01" class="input" accept="image/*" required>
            </div>
            <!-- Componente Flexible - Imágenes -->
            <div class="flex">
                <div class="box">
                    <p>Imagen 02</p>
                    <input type="file" name="image_02" class="input" accept="image/*">
                </div>
                <div class="box">
                    <p>Imagen 03</p>
                    <input type="file" name="image_03" class="input" accept="image/*">
                </div>
                <div class="box">
                    <p>Imagen 04</p>
                    <input type="file" name="image_04" class="input" accept="image/*">
                </div>
                <div class="box">
                    <p>Imagen 05</p>
                    <input type="file" name="image_05" class="input" accept="image/*">
                </div>
            </div>
            <input type="submit" value="Publicar" class="btn" name="post">
        </form>
    </section>
    <!-- Sección Publicar propiedad - Inicio -->

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
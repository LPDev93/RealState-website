<?php

/* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
============================== */

// -- Validamos anuncios que han sido guardados 
if (isset($_POST['save'])) {
    if ($user_id != '') {
        // -- Creamos un ID único para el anuncio a guardar
        $save_id = create_unique_id();
        $property_id = $_POST['property_id'];
        $property_id = filter_var($property_id, FILTER_SANITIZE_STRING);
        // -- Consulta a BD - Mostrar datos de la propiedad elegida
        $verify_saved = $conn->prepare(
            "SELECT * 
            FROM `saved` 
            WHERE property_id = ? 
            AND user_id = ?"
        );
        $verify_saved->execute([$property_id, $user_id]);
        // -- Validar propiedad - Eliminar o guardarla
        if ($verify_saved->rowCount() > 0) {
            $remove_saved = $conn->prepare(
                "DELETE 
                FROM `saved` 
                WHERE property_id = ? 
                AND user_id = ?"
            );
            $remove_saved->execute([$property_id, $user_id]);
            $success_msg[] = 'Has removido el anuncio de tus favoritos';
        } else {
            $insert_saved = $conn->prepare(
                "INSERT 
                INTO`saved`(id, property_id, user_id) 
                VALUES(?,?,?)"
            );
            $insert_saved->execute([$save_id, $property_id, $user_id]);
            $success_msg[] = 'Anuncio guardado';
        }
    } else {
        $warning_msg[] = 'Ingrese a su cuenta primero.';
    }
}
// -- Validamos anuncios que han solicitado consulta
if (isset($_POST['send'])) {
    if ($user_id != '') {
        // -- Creamos un ID único para el anuncio a consultar
        $request_id = create_unique_id();
        $property_id = $_POST['property_id'];
        $property_id = filter_var($property_id, FILTER_SANITIZE_STRING);
        // -- Consulta a BD - Mostrar ID del usuario que consulto anuncio
        $select_receiver = $conn->prepare(
            "SELECT user_id 
            FROM `property` 
            WHERE id = ? 
            LIMIT 1"
        );
        $select_receiver->execute([$property_id]);
        $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
        $receiver = $fetch_receiver['user_id'];
        // -- Consulta a BD - Mostrar consultas consultadas
        $verify_request = $conn->prepare(
            "SELECT * 
            FROM `requests` 
            WHERE property_id = ? 
            AND sender = ?
            AND receiver = ?"
        );
        $verify_request->execute([$property_id, $user_id, $receiver]);
        // -- Validar consulta
        if (($verify_request->rowCount() > 0)) {
            $warning_msg[] = '!Ya has enviado una consulta por este anuncio!';
        } elseif ($receiver != $user_id) {
            $send_request = $conn->prepare(
                "INSERT 
                INTO `requests`(id, property_id, sender, receiver) 
                VALUES(?,?,?,?)"
            );
            $send_request->execute([$request_id, $property_id, $user_id, $receiver]);
            $success_msg[] = '¡Acabas de consultar sobre este anuncio!';
        } else {
            $warning_msg[] = 'No puedes mandarte una solicitud tu mismo.';
        }
    } else {
        $warning_msg[] = 'Ingrese a su cuenta primero.';
    }
}

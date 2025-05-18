<?php
// Solo aceptar peticiones POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar que los campos existan
    $nombre = isset($_POST['nombre']) ? strip_tags(trim($_POST['nombre'])) : '';
    $correo = isset($_POST['correo']) ? filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL) : '';
    $mensaje = isset($_POST['mensaje']) ? strip_tags(trim($_POST['mensaje'])) : '';

    // Validar contenido
    if (empty($nombre) || empty($correo) || empty($mensaje) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Datos inválidos. Por favor, complete todos los campos.";
        exit;
    }

    // Dirección del destinatario
    $destinatario = "m.guerra@imasinter.es";
    $asunto = "Nueva solicitud desde la landing de vivienda";

    // Contenido del correo
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo: $correo\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    // Encabezados del correo
    $cabeceras = "From: $nombre <$correo>";

    // Enviar el correo
    if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
        http_response_code(200);
        echo "Correo enviado correctamente.";
    } else {
        http_response_code(500);
        echo "Error al enviar el correo.";
    }
} else {
    http_response_code(403);
    echo "Método no permitido.";
}

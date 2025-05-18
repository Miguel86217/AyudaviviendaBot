<?php
// Asegurar que solo se aceptan peticiones POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger y sanitizar los datos del formulario
    $nombre = isset($_POST['nombre']) ? strip_tags(trim($_POST['nombre'])) : '';
    $correo = isset($_POST['correo']) ? filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL) : '';
    $mensaje = isset($_POST['mensaje']) ? strip_tags(trim($_POST['mensaje'])) : '';

    // Validar los campos requeridos
    if (empty($nombre) || empty($correo) || empty($mensaje) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Datos inválidos.";
        exit;
    }

    // Configurar el correo
    $destinatario = "m.guerra@imasinter.es";
    $asunto = "Nueva solicitud desde AyudaViviendaBot";
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo: $correo\n";
    $contenido .= "Mensaje:\n$mensaje\n";
    $cabeceras = "From: $nombre <$correo>\r\n";
    $cabeceras .= "Reply-To: $correo\r\n";

    // Intentar enviar el correo
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

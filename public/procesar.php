<?php
/**
 * DISEÑARTE MÉXICO - SCRIPT DE ENVÍO DE CORREO (PHP)
 * --------------------------------------------------
 * Recibe datos por POST, valida y envía a ventas@disenartemx.com
 */

// 1. Evitar acceso directo
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /contacto");
    exit();
}

// 2. Configuración del destinatario
$destinatario = "lumomoro@gmail.com"; // TU CORREO DE VENTAS
$asunto = "Nuevo Prospecto desde el Sitio Web";

// 3. Sanitizar y capturar datos
$nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_STRING);
$telefono = filter_var(trim($_POST["telefono"]), FILTER_SANITIZE_STRING);
$correo = filter_var(trim($_POST["correo"]), FILTER_SANITIZE_EMAIL);
$empresa = !empty($_POST["empresa"]) ? filter_var(trim($_POST["empresa"]), FILTER_SANITIZE_STRING) : "No especificada";
$mensaje = filter_var(trim($_POST["mensaje"]), FILTER_SANITIZE_STRING);

// 4. Validar campos obligatorios
if (empty($nombre) || empty($telefono) || empty($correo) || empty($mensaje) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor completa todos los campos obligatorios (*) correctamente.']);
    exit();
}

// 5. Construir el cuerpo del correo (Diseño HTML limpio)
$contenido_html = '
<html>
<head>
  <style>
    body { font-family: sans-serif; line-height: 1.6; color: #333; }
    .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
    .header { background-color: #712c91; color: white; padding: 15px; text-align: center; border-radius: 10px 10px 0 0; }
    .field { margin-bottom: 15px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; }
    .label { font-weight: bold; color: #66bcc9; text-transform: uppercase; font-size: 12px; }
    .value { font-size: 16px; margin-top: 5px; color: #1a1a1a; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Nuevo Mensaje de Contacto</h1>
    </div>
    <div style="padding: 20px;">
      <div class="field"><div class="label">Nombre:</div><div class="value">' . $nombre . '</div></div>
      <div class="field"><div class="label">Teléfono:</div><div class="value">' . $telefono . '</div></div>
      <div class="field"><div class="label">Correo Electrónico:</div><div class="value">' . $correo . '</div></div>
      <div class="field"><div class="label">Empresa:</div><div class="value">' . $empresa . '</div></div>
      <div class="field"><div class="label">Mensaje:</div><div class="value">' . nl2br($mensaje) . '</div></div>
    </div>
    <div style="text-align: center; font-size: 11px; color: #aaa; margin-top: 20px;">
      Este correo fue generado automáticamente desde disenartemx.com.
    </div>
  </div>
</body>
</html>
';

// 6. Configurar cabeceras de correo (Vital para que llegue como HTML)
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// Importante: La dirección de "From" debe ser de tu dominio (ej. contacto@disenartemx.com)
// para mejorar la entregabilidad. Si no la creas, usa webmaster@disenartemx.com.
$headers .= 'From: Webmaster Diseñarte <it@disenartemx.com>' . "\r\n";
$headers .= 'Reply-To: ' . $correo . "\r\n";

// 7. Enviar Correo
if (mail($destinatario, $asunto, $contenido_html, $headers)) {
    echo json_encode(['status' => 'success', 'message' => 'Tu mensaje ha sido enviado con éxito. Nos pondremos en contacto pronto.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Hubo un problema al enviar tu mensaje. Por favor intenta más tarde o contáctanos por WhatsApp.']);
}
?>
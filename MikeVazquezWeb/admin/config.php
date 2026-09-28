<?php
/**
 * Configuración del Panel de Administración - Mike Vazquez Web
 * 
 * Las credenciales y configuraciones sensibles se cargan de forma segura
 * desde variables de entorno o desde el archivo .env protegido.
 * NUNCA almacenes contraseñas, emails privados ni claves de API en este archivo.
 */

// Cargar variables de entorno desde .env si existe
if (!function_exists('load_env_file')) {
    function load_env_file($filePath) {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return false;
        }
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }
            if (strpos($line, '=') !== false) {
                list($key, $val) = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val);
                // Remover comillas si existen
                if ((strpos($val, '"') === 0 && strrpos($val, '"') === strlen($val) - 1) ||
                    (strpos($val, "'") === 0 && strrpos($val, "'") === strlen($val) - 1)) {
                    $val = substr($val, 1, -1);
                }
                if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                    putenv("{$key}={$val}");
                    $_ENV[$key] = $val;
                    $_SERVER[$key] = $val;
                }
            }
        }
        return true;
    }
}

// Intentar cargar .env desde distintas rutas relativas
$envLocations = [
    dirname(__DIR__) . '/.env',
    __DIR__ . '/.env',
    dirname(dirname(__DIR__)) . '/.env'
];

foreach ($envLocations as $envFile) {
    if (load_env_file($envFile)) {
        break;
    }
}

// Función auxiliar para leer variables de entorno con valor predeterminado
if (!function_exists('env_get')) {
    function env_get($key, $default = '') {
        $val = getenv($key);
        if ($val !== false && $val !== '') {
            return $val;
        }
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
            return $_ENV[$key];
        }
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
            return $_SERVER[$key];
        }
        return $default;
    }
}

// Credenciales protegidas (obtenidas desde .env o variables de entorno del servidor)
define('ADMIN_EMAIL', env_get('ADMIN_EMAIL', 'admin@soymikevazquez.com'));
define('ADMIN_PASSWORD_HASH', env_get('ADMIN_PASSWORD_HASH', ''));

// Iniciar sesión de forma segura si no se ha iniciado ya
if (session_status() === PHP_SESSION_NONE) {
    // Configurar cookies de sesión seguras
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

/**
 * Verifica si el administrador ha iniciado sesión
 */
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Autentica al administrador con el correo y opcionalmente con contraseña
 */
function verify_admin_login($email, $password = '') {
    $expected_email = strtolower(trim(ADMIN_EMAIL));
    $input_email = strtolower(trim($email));

    if (empty($expected_email) || $input_email !== $expected_email) {
        return false;
    }

    // Si se configuró hash de contraseña en .env y se envió contraseña, verificarla
    if (defined('ADMIN_PASSWORD_HASH') && ADMIN_PASSWORD_HASH !== '' && !empty($password)) {
        if (hash('sha256', $password) !== ADMIN_PASSWORD_HASH) {
            return false;
        }
    }

    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_email'] = $input_email;
    return true;
}

/**
 * Cierra la sesión del administrador
 */
function logout_admin() {
    unset($_SESSION['admin_logged_in']);
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

<?php

require __DIR__ . '/../vendor/autoload.php';

// Load cấu hình ứng dụng
$config = require __DIR__ . '/../config/app.php';
$debug = $config['debug'] ?? false;

// Chuyển đổi các lỗi PHP thông thường thành ErrorException
set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

// Bắt Exception toàn cục
set_exception_handler(function ($exception) use ($debug) {
    // Đảm bảo thư mục lưu log tồn tại
    $logDir = __DIR__ . '/../storage/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    // Ghi nhận lỗi chi tiết vào file storage/logs/error.log
    $logFile = $logDir . '/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = sprintf(
        "[%s] %s: %s in %s on line %d\nStack trace:\n%s\n\n",
        $timestamp,
        get_class($exception),
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine(),
        $exception->getTraceAsString()
    );
    error_log($logMessage, 3, $logFile);

    // Thiết lập response code 500
    http_response_code(500);

    if ($debug) {
        // Môi trường Dev: Hiển thị lỗi chi tiết
        echo "<h1>500 Internal Server Error</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($exception->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($exception->getFile()) . " on line " . $exception->getLine() . "</p>";
        echo "<pre>" . htmlspecialchars($exception->getTraceAsString()) . "</pre>";
    } else {
        // Môi trường Production: Render trang lỗi sạch
        if (function_exists('render')) {
            try {
                render('errors/500', ['title' => '500 Internal Server Error']);
            } catch (\Throwable $e) {
                echo "<h1>500 Internal Server Error</h1><p>An unexpected error occurred.</p>";
            }
        } else {
            echo "<h1>500 Internal Server Error</h1><p>An unexpected error occurred.</p>";
        }
    }
    exit;
});

use App\Controllers\AppointmentController;
use App\Controllers\PatientController;
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HealthController;
use App\Controllers\PublicPatientController;



session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();
check_session_timeout();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'handleLogin']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/health', [HealthController::class, 'index']);
$router->get('/appointments', [AppointmentController::class, 'index']);
$router->get('/appointments/create', [AppointmentController::class, 'create']);
$router->post('/appointments', [AppointmentController::class, 'store']);
$router->get('/appointments/edit', [AppointmentController::class, 'edit']);
$router->post('/appointments/update', [AppointmentController::class, 'update']);
$router->post('/appointments/delete', [AppointmentController::class, 'delete']);
$router->get('/patients', [PatientController::class, 'index']);
$router->get('/patients/create', [PatientController::class, 'create']);
$router->post('/patients', [PatientController::class, 'store']);
$router->get('/patients/edit', [PatientController::class, 'edit']);
$router->post('/patients/update', [PatientController::class, 'update']);
$router->post('/patients/delete', [PatientController::class, 'delete']);

// Các route đăng ký bệnh nhân công khai
$router->get('/public-patients/create', [PublicPatientController::class, 'create']);
$router->post('/public-patients', [PublicPatientController::class, 'store']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
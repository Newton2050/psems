<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('VIEW_PATH', APP_PATH . '/Views');

if (file_exists(ROOT_PATH . '/.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable(ROOT_PATH);
    $dotenv->load();
}

require_once CONFIG_PATH . '/constants.php';
$autoloader = require_once ROOT_PATH . '/vendor/autoload.php';
require_once APP_PATH . '/Helpers/functions.php';

$config = require_once CONFIG_PATH . '/config.php';
use App\Core\Database;
Database::init($config['database']);

use App\Core\Session;
Session::start();

if (!Session::has('csrf_token')) {
    Session::set('csrf_token', bin2hex(random_bytes(32)));
    Session::set('csrf_token_time', time());
}

header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

use App\Core\App;
$app = new App();
$app->run();

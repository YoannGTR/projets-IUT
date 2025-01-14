<?php
require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../Autoloader.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->safeLoad();

enum CurrentPage: string
{
    case HOME = 'home';
    case RESERVATIONS = 'reservations';
    case ACCOUNT = 'account';

    case REGISTER = 'register';
    const BACKOFFICE = 'backoffice';
}

use Classes\Authentification;
use voku\helper\AntiXSS;

$antiXss = new AntiXSS();
$auth = new Authentification();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
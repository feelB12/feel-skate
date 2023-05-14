<?php

Namespace App\App;

error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors',1);
error_reporting(-1);
require '../vendor/autoload.php';

Class bootstrap {

function e404(){
    //header('location: \404.php');
    require '../public/calendar/404.php';
    exit();
}

function get_pdo (): \PDO {
    return new \PDO('mysql:host=localhost;dbname=calendrier-bdd', 'root', 'root', [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ]);
}
function h(?string $value): string {
    if ($value === null) {
        return '';
    }
    return htmlentities($value); 
}
function render(string $view, $parameters = []) {
    extract($parameters);
    include "../views/{$view}.php";
}
}
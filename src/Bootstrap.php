<?php

namespace App;

error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors',1);
error_reporting(-1);


use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\LoaderInterface;

use App\Calendar\Month;
use App\Calendar\Event;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\MakerBundle\MakerBundle;

class Bootstrap extends AbstractController
{

function e404(){
    //header('location: \404.php');
    require '../public/404.php';
    exit();
}


function get_pdo (): PDO {
    return new PDO('mysql:host=localhost;dbname=calendrier-bdd', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}
function h(?string $value): string {
    if ($value === null) {
        return '';
    }
    return htmlentities($value); 
}

}
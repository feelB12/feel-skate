
<!DOCTYPE html>
<html lang='en'>
    <head>
       <meta charset='utf-8' />
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <link rel="stylesheet" href="css/calendar.css">
<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors',1);
error_reporting(-1);

require '../src/bootstrap.php';

use Calendar\{
    Events,
    Month   
 };

$pdo =  get_pdo();
$events = new Events($pdo);
if (!isset($_GET['id'])) {
    header('location: /404.php');
}
try {
    $event = $events->find($_GET['id']);   
} catch (\Exception $e) {
    e404();
}

render('../views/header', ['title' => $event->getName()]);

?>
      <title><?= isset($title) ? h($title) : 'Calendar'; ?></title>
      </head>
   <body>
      <nav class="navbar navbar-dark bg-primary mb-3">
        <a href="../calendar/index.php" class="navbar-brand"> Calendrier Brigadier </a>
      </nav>

<h1><?= h($event->getName()); ?></h1>
<ul>
    <li>Date: <?= $event->getStart()->format('d/m/Y'); ?></li>
    <li>Heure de démarrage: <?= $event->getStart()->format('H:i'); ?></li>
    <li>Heure de fin: <?= $event->getEnd()->format('H:i'); ?></li>
    <li>
        Description:<br>
        <?= h($event->getDescription());?>
    </li>
</ul>

<?php require '../views/footer.php'; ?>
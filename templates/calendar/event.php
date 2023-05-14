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

render('header', ['title' => $event->getName()]);

?>

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
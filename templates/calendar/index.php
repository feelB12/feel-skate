<!DOCTYPE html>
<html lang='en'>
<head>
   <meta charset='utf-8' />
   <title>{% block metatitle %}Calendrier | Skateboard Social Club{% endblock metatitle %} | Skateboard Social Club</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
   <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@100&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Cabin&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/hom.css') }}">
   <link rel="stylesheet" href="{{ asset('css/header.css') }}">
   <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
</head>
<body>

<main id="main">
  
<nav class="navbar navbar-dark bg-primary mb-3">
   <a href="index.php" class="navbar-brand"> Brigadier Calendrier</a>
</nav>

<h1>Mai 2023</h1>


<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors',1);
error_reporting(-1);

require '../../src/Bootstrap.php';
require '../../src/Calendar/Month.php';
require '../../src/Calendar/Events.php';

use App\Calendar\{
   Events,
   Month   
};

$pdo = get_pdo();
$events = new App\Calendar\Events($pdo);

$month = new App\Calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay();
$start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 * ($weeks - 1)) . ' days');
$events = $events->getEventsBetweenByDay($start, $end);

$status = [];
if(isset($_POST['status'])){
    echo $_POST['status'];
}

require '../templates/views/header.php';
?>

<div class="calendar">

   <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
  
   
      <h1><?= $month->toString(); ?></h1>

      <?php if (isset($_GET['success'])): ?>
         <div class="container">
            <div class="alert alert-sucsess">
               L'évènement a bien été enregistré<br>
               <?php echo "en statut: <b>" . $_POST['status'] . "</b><br>"; ?>
            </div>
         </div>
      <?php endif; ?>

      <div>
         <a href="index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
         <a href="index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
      </div>
   </div>

<table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
   <?php for ($i = 0; $i < $weeks; $i++): ?>
      <tr>
         <?php
            foreach($month->days as $k => $day): 
            $date = $start->modify( "+" . ($k + $i * 7) . " days");
            $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
            $isToday = date('Y-m-d') === $date->format('Y-m-d');
            ?>
            <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?> <?= $isToday ? 'is-today' : ''; ?>">
               
            <?php if ($i === 0): ?>

                  <div class="calendar__weekday"> <?= $day;?><br></div>

               <?php endif; ?>
                   <a class="calendar__day" href="add.php?date=<?= $date->format('Y-m-d'); ?>"><?= $date->format('d');  ?><br></a>
                   <br>
                   
                  <?php foreach($eventsForDay as $event): ?>
                     <div class="calendar__event">
                        <?= (new DateTime($event['start']))->format('H:i') ?> - <a href="edit.php?id=<?= $event['id'];?>"><?= h($event['name']);?></a><br>
                     </div>
                  <?php endforeach; ?>
            </td>
         <?php endforeach; ?>
      </tr>
   <?php endfor; ?>
</table>

<a href="calendar/add" class="calendar__button">+</a>
</div>

<?php render('footer'); ?>


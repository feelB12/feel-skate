<!DOCTYPE html>
<html lang='en'>
    <head>
       <meta charset='utf-8' />
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <link rel="stylesheet" href="css/calendar.css">
      </head>
   <body>
      <nav class="navbar navbar-dark bg-primary mb-3">
        <a href="/index.php" class="navbar-brand"> Brigadier Calendrier</a>
      </nav>

      <?php 
      require 'vendor/autoload.php';
      require '../../src/Date/Month.php';
      $month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null, $_GET['day'] ?? null);
      $start = $month->getStartingDay();
      $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
      ?>

      <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
         <h1><?= $month->toString(); ?></h1>
         <div>
            <a href="/index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="/index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
         </div>
      </div>

     

      <table class="calendar__table calendar__table--<?= $month->getWeeks(); ?>weeks">
         <?php for ($i = 0; $i < $month->getWeeks(); $i++): ?>
            <tr>
               <?php
               foreach($month->days as $k => $day): 
                  $date = (clone $start)->modify( "+" . ($k + $i * 7) . " days")
                  ?>
               <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
                  <?php if ($i === 0): ?>
                     <div class="calendar__weekday"> <?= $day; ?></div>
                     <?php endif; ?>
                     <div class="calendar__day"><?= $date->format('d'); ?></div>
                  </td>
                  <?php endforeach; ?>
            </tr>
         <?php endfor; ?>
      </table>
   </body>
</html> 
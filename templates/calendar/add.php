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
        require '../../src/App/bootstrap.php';

        use Calendar\{
            Events,
            Month   
        };

        $status = [];
        if(isset($_POST['status'])){
            echo $_POST['status'];
        }


        $status = [
            'hide'          => $_POST['status2'],
            'is_published'  => $_POST['status1'],
            'status'        => $_GET['status'],
        ];

        $data = [
            'date'          => $_GET['date'] ?? date('Y-m-d'),
            'start'         => date('H:i'),
            'end'           => date('H:i'),
            'hide'          => $_POST['status2'] ?? date('Y-m-d'),
            'is_published'  => $_POST['status1'] ?? date('Y-m-d'),
            'status'        => $_POST['status'] ?? date('Y-m-d'),
            'created_at'    => date('Y-m-d H:i'),
        ];
        $validator = new \App\Validator($data);
        if (!$validator->validate('date', 'date')) {
            $data['date'] = date('Y-m-d');
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $validator = new Calendar\EventValidator();
            $errors = $validator->validates($_POST);
            if(empty($errors)) {
                $events = new \Calendar\Events(get_pdo());
                $event = $events->hydrate(new \Calendar\Event(), $data);
                
                $events->create($event);
                header('location: /feel-skate/public/index.php?success=1');
                exit();
            }
        }
        render('header', ['titre' => 'Ajouter un évènement']);
        dd($data);
        dd($status);
        dd($_POST['status']);
        ?>

      <title><?= isset($title) ? h($title) : 'Calendar'; ?></title>
      </head>
   <body>
      <nav class="navbar navbar-dark bg-primary mb-3">
        <a href="../calendar/index.php" class="navbar-brand"> Calendrier Brigadier </a>
      </nav>

<div class="container">
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        Merci de corriger vos erreurs
    </div>
<?php endif; ?>

<h1>Ajouter un évènement</h1>
<form action="" method="post" class="form">
        <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
        
    <div class="form-group">
        <button class="btn btn-primary">Ajouter un évènement</button>
    </div>
    </form>
    
</div>
<?php render('footer'); ?>
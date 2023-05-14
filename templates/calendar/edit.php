<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors',1);
error_reporting(-1);

require '../src/bootstrap.php';
$pdo =  get_pdo();
$events = new Calendar\Events($pdo);
$errors = [];
if (!isset($_GET['id'])) {
    e404();
}
try {
    $event = $events->find($_GET['id'] ?? null);   
} catch (\Exception $e) {
    e404();
} catch (\Error $e) {
    e404();
}

$status = [];
if(isset($_POST['status'])){
    echo $_POST['status'];
}

$status = [
    'status'        => $_POST['status'],
    'hide'          => $event->getHide()->format('Y-m-d H:i'),
    'is_published'  => $event->getPublished()->format('Y-m-d H:i'),
   
];

$data = [
    'name'          => $event->getName(),
    'date'          => $event->getStart()->format('Y-m-d'),
    'start'         => $event->getStart()->format('H:i'),
    'end'           => $event->getEnd()->format('H:i'),
    'description'   => $event->getDescription(),
    'hide'          => $event->getHide()->format('Y-m-d H:i'),
    'is_published'  => $event->getPublished()->format('Y-m-d H:i'),
    'status'        => $event->getStatus(),
    'created_at'    => $event->getCreated()->format('Y-m-d H:i'),
];

dd($data);
dd($status);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($data);
    if(empty($errors)) {
        $events->hydrate($event, $data);
        $events->update($event);
        header('location: /php-calendrier/public/index.php?success=1');
        exit();
    }
}

render('header', ['title' => $event->getName()]);
?>

<div class="container">

    <h1>Editer l'évènement
         <small><?= h($event->getName()); ?></small
    ></h1>
    
    <form action="" method="post" class="form">
        <div class="">
            <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
            <div class="form-group form-button">
                    <button class="btn btn-primary btn-flex">Modifier l'évènement</button>
                    <button class="btn btn-primary btn-flex">supprimer l'évènement</button>
            </div>
        </div>
    </form>
</div>

<?php render('footer'); ?>
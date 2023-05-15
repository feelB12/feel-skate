<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\LoaderInterface;

use App\Entity\Month;
use App\Date;
use App\Validator;
use App\EventValidator;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\MonthRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /** renvoie l'evenement
     * @Route("calendar/event.php", name="calendar_event", methods={"GET"})
     */
    public function Event()
    {
        
        return $this->render('event.html.twig');

        //return $this->redirectToRoute("calendrier");
    }

    /** ajoute un évenement
     * @Route("calendar/add.php", name="event_add", methods={"GET","POST"})
     */
    public function AddEvent()
    {
        
        return $this->render('add_event.html.twig');

        //return $this->redirectToRoute("calendrier");
    }

    /** edite un évènement
     * @Route("calendar/edit.php", name="event_edit", methods={"GET","POST"})
     */
    public function EditEvent()
    {
        
        return $this->render('edit_event.html.twig');

        //return $this->redirectToRoute("calendrier");
    }

    /** Supprime un évènement
     * @Route("calendar/delete", name="event_delete", methods={"GET"})
     */
    public function DeleteEvent()
    {
        
        return $this->render('delete_event.html.twig');

        //return $this->redirectToRoute("calendrier");
    }

    /** exporte les évènements
     * @Route("calendar/export.php", name="event_export", methods={"GET"})
     */
    public function ExportEvent()
    {
        
        return $this->render('export_event.html.twig');

        //return $this->redirectToRoute("calendrier");
    }

    /** import les évènements
     * @Route("calendar/import.php", name="event_import", methods={"GET"})
     */
    public function ImportEvent()
    {
        
        return $this->render('import_event.html.twig');

        //return $this->redirectToRoute("calendrier");
    }
}
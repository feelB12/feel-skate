<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\LoaderInterface;

use App\Bootsrtap;
use App\Calendar\Month;
use App\Calendar\Event;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\MakerBundle\MakerBundle;

class CalendarValidatorController extends AbstractController
{
    /** 
     * @Route("calendar", name="calendar", methods={"GET"})
     */
    public function Calendrier()
    {
        
        return $this->render('calendar/calendar.html.twig');

        //return $this->redirectToRoute("calendrier");
    }
    /** Calendrier
     * @Route("calendar/index.php", name="calendar_index", methods={"GET"})
     */
    public function IndexCalendrier()
    {
        
        return $this->render('calendar/index.php');

        //return $this->redirectToRoute("calendrier");
    }
    /** Ajoute un évènement
     * @Route("calendar/add", name="calendar_add", methods={"GET"})
     */
    public function FrontCalendrier()
    {
        
        return $this->render('calendar/add.php');

        //return $this->redirectToRoute("calendrier");
    }
    /** Edite un évènement
     * @Route("calendar/edit.php", name="calendar_edit", methods={"GET"})
     */
    public function EditCalendrier($id)
    {
        
        return $this->render('calendar/edit.php');

        //return $this->redirectToRoute("calendrier");
    }
    /**
     * @Route("/calendar/calendar", name="calendar_calendar", methods={"GET"})
     */
    public function AccessCalendrier()
    {
        
        return $this->render('calendar/calendar.html.twig');

        //return $this->redirectToRoute("calendrier");
    }
}
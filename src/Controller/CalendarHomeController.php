<?php

namespace App\Controller;

use App\Date;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;

class CalendarHomeController extends AbstractController
{
    /** 
     * @Route("calendar", name="calendar", methods={"GET"})
     */
    public function Calendrier()
    {
        
        return $this->render('calendar/index.php');

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
    /**
     * @Route("/calendar/calendar", name="calendar_front", methods={"GET"})
     */
    public function AccessCalendrier()
    {
        
        return $this->render('agenda.html.twig');

        //return $this->redirectToRoute("calendrier");
    }
}
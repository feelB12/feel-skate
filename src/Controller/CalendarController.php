<?php

namespace App\Controller;

use App\Date;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("calendar", name="calendar", methods={"GET"})
     */
    public function Calendrier()
    {
        
        return $this->render('calendar/calendar.html.twig');

        //return $this->redirectToRoute("calendrier");
    }
}
<?php

namespace App\Controller;

use App\Repository\MonthRepository;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\LoaderInterface;

use App\Entity\Month;
use App\Validator;
use App\EventValidator;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;
//use pour intval

#[AsController]
class MonthController extends AbstractController
{
    /**
     * @Route("calendar/month", name="calendar_month", methods={"GET"})
     */
    public $days = ['Lundi','Mardi', 'Mercredi', 'Jeudi','Vendredi','Samedi', 'Dimanche'];

    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre','Novembre','Décembre'];
    public $month;
    public $year;


    public function __construct(?int $month = null, ?int $year = null)
    {

        if ($month === null) {
            $month = intval(date('m'));
        }
        if ($year === null) {
            $year = intval(date('Y'));
        }
        if ($month === 12||$month > 12) {
            $month === 11;
        }
        $this->month = $month;
        $this->year = $year;

        return $this->render('calendar/calendar.html.twig', [
            'month' => $month,
            'year' => $year
        ]);

        //return $this->redirectToRoute("calendrier");
    }
}
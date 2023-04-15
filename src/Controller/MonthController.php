<?php

namespace App\Controller;



use App\Repository\MonthRepository;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\LoaderInterface;

use App\Entity\Month;
use App\Date;
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
     * @Route("calendar/calendar", name="calendar_month", methods={"GET"})
     */
    public function Calendrier(?int $month, ?int $year)
    {

        if ($month === null) {
            $month = intval(date('m'));
        }
        if ($year === null) {
            $year = intval(date('Y'));
        }
        //if ($month < 1 || $month > 12) { throw new \Exception ("Le mois $month n'est pas valide"); }        
        $month = $month % 12;

       // if ($year < 1970) { throw new \Exception ("L'année est inférieur à 1970"); }
        $this->month = $month;
        $this->year = $year;

        return $this->render('calendar/index.php', [
            'month' => $month,
            'year' => $year
        ]);

        //return $this->redirectToRoute("calendrier");
    }
}
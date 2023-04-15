<?php

Namespace App\Date;

class Month {

    public $days = ['Lundi','Mardi', 'Mercredi', 'Jeudi','Vendredi','Samedi', 'Dimanche'];

    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre','Novembre','Décembre'];
    public $month;
    public $year;

    /**
     * Month constructor.
     * @param int $month Le mois compris entre 1 et 12 
     * @param int $year L'année
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
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
    }

    /**
     * Renvoie le premier jour du mois
     * @return \DateTime
     */
    public function getStartingDay (): \DateTime {
        return new \DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * Retourne le mois en toute lettre (ex: Mars 2023)
     * @return string
     * 
    */
    public function toString (): string {
            return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    /**
     * Renvoie le nombre de semaine dans le mois 
     * @return int
     */
    public function getWeeks (): int {
        $start = new \DateTime("{$this->year}-{$this->month}-01");
        $end = (clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
        if ($weeks < 0) {
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }

    /**
     * Renvoie le nombre de jour dans la semaine
     * @return int
     */
    public function getDays (): int {
        $startday = new \DateTime("{$this->week}-{$this->day}-01");
        $endday = (clone $startday)->modify('+1 week -1 day');
        $weeksday = intval($endday->format('D')) - intval($startday->format('D')) + 1;
        if ($weeksday < 0) {
            $weeksday = intval($endday->format('D'));
        }
        return $weeksday;
    }

    /**
     * Est ce que le jour est dans le mois en cours
     * @param \DateTime $date
     * @return bool
     */
    public function withinMonth (\DateTime $date): bool {
        return $this ->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoie le moi suivant 
     * @return Month
     */

    public function nextMonth(): Month {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * Renvoie le moi précédent 
     * @return Month
     */

    public function previousMonth(): Month {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}
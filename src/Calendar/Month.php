<?php

Namespace App\Calendar;

class Month {
    private $nextMonth;
    private $previousMonth;

    public $days = ['Lundi','Mardi', 'Mercredi', 'Jeudi','Vendredi','Samedi', 'Dimanche'];

    private $months = [
        'Janvier',
        'Février',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Aout',
        'Septembre',
        'Octobre',
        'Novembre',
        'Décembre'
    ];
    
    public $month;
    public $year;

    /**
     * Month constructor.
     * @param int $month Le mois compris entre 1 et 12 
     * @param int $year L'année
     */
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
    }

    /**
     * Renvoie le premier jour du mois
     * @param \DateTimeInterface
     * @return \DateTimeInterface 
     */
    public function getStartingDay (): \DateTimeInterface 
    {
        return new \DateTimeImmutable("{$this->year}-{$this->month}-01");
    }

    /**
     * Retourne le mois en toute lettre (ex: Mars 2023)
     * @return string
     
    */
    public function toString (): string {
            
            return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    /**
     * Renvoie le nombre de semaine dans le mois 
     * @return int $weeks
     */
    public function getWeeks (): int 
    {
        
        $start = $this->getStartingDay();
        $end = $start->modify('+1 month -1 day');
        
        $startWeek = intval($start->format('W'));
        $endWeek = intval($end->format('W'));
        if ($endWeek === 1) {
            $endWeek = intval($end->modify('- 7 days')->format('W')) + 1 ;
        }
        $weeks = $endWeek - $startWeek + 1;
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
        $endday = $startday->modify('+1 week -1 day');
        $weeksday = intval($endday->format('D')) - intval($startday->format('D')) + 1;
        if ($weeksday < 0) {
            $weeksday = intval($endday->format('D'));
        }
        return $weeksday;
    }

    /**
     * Est ce que le jour est dans le mois en cours
     * @param \DateTimeInterface $date
     * @return bool
     * @throws \Exception
     */
    public function withinMonth (\DateTimeInterface $date): bool {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoie le moi suivant 
     * @return Month
     */

    public function nextMonth(): Month {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12)
        {
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
        if ($month < 1)
        {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}
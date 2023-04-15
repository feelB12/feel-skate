<?php

namespace App\Entity;

use App\Repository\MonthRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonthRepository::class)
 */
class Month
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $day = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $month;

    /**
     * @ORM\Column(type="array")
     */
    public $days = ['Lundi','Mardi', 'Mercredi', 'Jeudi','Vendredi','Samedi', 'Dimanche'];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="array")
     */
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre','Novembre','Décembre'];

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="integer")
     */
    private $weeks;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startday;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endday;

    /**
     * @ORM\Column(type="integer")
     */
    private $weeksday;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?array
    {
        return $this->day;
    }

    public function setDay(array $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getMonths(): ?array
    {
        return $this->months;
    }

    public function setMonths(array $months): self
    {
        $this->months = $months;

        return $this;
    }

    public function getYear(int $year): ?int
    {
        return $this->year;
    }

    public function setYear(int $month): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function setDays(array $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getWeeks(): ?int
    {
        return $this->weeks;
    }

    public function setWeeks(int $weeks): self
    {
        $this->weeks = $weeks;

        return $this;
    }

    public function getStartday(): ?\DateTimeInterface
    {
        return $this->startday;
    }

    public function setStartday(\DateTimeInterface $startday): self
    {
        $this->startday = $startday;

        return $this;
    }

    public function getEndday(): ?\DateTimeInterface
    {
        return $this->endday;
    }

    public function setEndday(\DateTimeInterface $endday): self
    {
        $this->endday = $endday;

        return $this;
    }

    public function getWeeksday(): ?int
    {
        return $this->weeksday;
    }

    public function setWeeksday(int $weeksday): self
    {
        $this->weeksday = $weeksday;

        return $this;
    }
}

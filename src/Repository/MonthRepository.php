<?php

namespace App\Repository;

use App\Entity\Month;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Month>
 *
 * @method Month|null find($id, $lockMode = null, $lockVersion = null)
 * @method Month|null findOneBy(array $criteria, array $orderBy = null)
 * @method Month[]    findAll()
 * @method Month[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @param int $month Le mois compris entre 1 et 12 
 * @param int $year L'année
 * @throws \Exception
 */
class MonthRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Month::class);
    }

    public function add(Month $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Month $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
     * Return next month 
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
     * Return prévious month 
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
//    /**
//     * @return Month[] Returns an array of Month objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Month
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

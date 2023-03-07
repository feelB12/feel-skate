<?php

namespace App\Repository;

use App\Entity\Club;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Club|null find($id, $lockMode = null, $lockVersion = null)
 * @method Club|null findOneBy(array $criteria, array $orderBy = null)
 * @method Club[]    findAll()
 * @method Club[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Club::class);
    }
    public function searchByTitle($word)
    {
        // j'utilise la méthode createQueryBuilder provenant de la classe parent
        // et je définis un alias pour la table book
        $queryBuilder = $this->createQueryBuilder('club');

        // je demande à Doctrine de créer une requête SQL
        // qui fait une requête SELECT sur la table club
        // à condition que le titre du club
        // contiennent le contenu de $word (à un endroit ou à un autre, grâce à LIKE %xxxx%)
        $query = $queryBuilder->select('club')
            ->where('club.title LIKE :word')
            ->setParameter('word', '%'.$word.'%')
            ->getQuery();

        // je récupère les résultats de la requête SQL
        // et je les retourne
        return $query->getResult();
    }

    // /**
    //  * @return Club[] Returns an array of Club objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Club
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
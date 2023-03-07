<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }
    public function searchByTitle($word)
    {
        // j'utilise la méthode createQueryBuilder provenant de la classe parent
        // et je définis un alias pour la table book
        $queryBuilder = $this->createQueryBuilder('session');

        // je demande à Doctrine de créer une requête SQL
        // qui fait une requête SELECT sur la table session
        // à condition que le titre de la session
        // contiennent le contenu de $word (à un endroit ou à un autre, grâce à LIKE %xxxx%)
        $query = $queryBuilder->select('session')
            ->where('shop.title LIKE :word')
            ->setParameter('word', '%' . $word . '%')
            ->getQuery();

        // je récupère les résultats de la requête SQL
        // et je les retourne
        return $query->getResult();
    }
    // /**
    //  * @return Session[] Returns an array of Session objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Session
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
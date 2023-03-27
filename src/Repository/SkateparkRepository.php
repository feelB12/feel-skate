<?php

namespace App\Repository;

use App\Entity\Skatepark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Skatepark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skatepark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skatepark[]    findAll()
 * @method Skatepark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkateparkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skatepark::class);
    }
    public function searchByTitle($word)
    {
        // j'utilise la méthode createQueryBuilder provenant de la classe parent
        // et je définis un alias pour la table skatepark
        $queryBuilder = $this->createQueryBuilder('skatepark');

        // je demande à Doctrine de créer une requête SQL
        // qui fait une requête SELECT sur la table skatepark
        // à condition que le titre du skatepark
        // contiennent le contenu de $word (à un endroit ou à un autre, grâce à LIKE %xxxx%)
        $query = $queryBuilder->select('skatepark')
            ->where('skatepark.title LIKE :word')
            ->setParameter('word', '%'. $word .'%')
            ->getQuery();

        // je récupère les résultats de la requête SQL
        // et je les retourne
        return $query->getResult();
    }
    // /**
    //  * @return Skatepark[] Returns an array of Skatepark objects
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
    public function findOneBySomeField($value): ?Skatepark
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
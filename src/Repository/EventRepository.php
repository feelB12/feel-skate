<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }
    public function searchByTitle($word)
    {
        // j'utilise la méthode createQueryBuilder provenant de la classe parent
        // et je définis un alias pour la table book
        $queryBuilder = $this->createQueryBuilder('event');

        // je demande à Doctrine de créer une requête SQL
        // qui fait une requête SELECT sur la table event
        // à condition que le titre de la event
        // contiennent le contenu de $word (à un endroit ou à un autre, grâce à LIKE %xxxx%)
        $query = $queryBuilder->select('event')
            ->where('event.title LIKE :word')
            ->setParameter('word', '%' . $word . '%')
            ->getQuery();

        // je récupère les résultats de la requête SQL
        // et je les retourne
        return $query->getResult();
    }
    /**
     * récupère les évents commenançant entre deux dates
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return Event[]
     */

     public function getEventsBetween (\DateTimeInterface $start, \DateTimeInterface $end): array {
        $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'ORDER BY start ASC";
        $statement = $this->pdo->query($sql);
        $results = $statement->fetchAll();
        
         return $results;
    }
    /**
     * récupère les évents commenançant entre deux dates indexé par jour
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     */
    public function getEventsBetweenByDay (\DateTimeInterface $start, \DateTimeInterface $end): array {
        $events = $this->getEventsBetween($start, $end);
        $days = [];
        foreach($events as $event) {
            
            $date = explode(' ', $event['start']) [0];
           
            if (!isset($days[$date])) {
                $days[$date] = [$event];
                
            } else{
                $days[$date][] = $event;
            } 
        }
        return $days;
    }
    /**
     * Récupère un évenement
     * @param int $id
     * @return Event
     * @throws \Exception
     */
    public function found (int $id): Event {
        
        $statement = $this->pdo->query("SELECT * FROM events WHERE id = $id LIMIT 1");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::Class);
        $result = $statement->fetch();
        if ($result === false) {
            throw new \Exception('Aucun résultat n\'a été trouvé');
        }
        return $result;
    }
    /**
     * 
     * @param Event $event
     * @param array $data
     * @return Event
     */
    public function hydrate (Event $event, array $data) {
        $event->setName($data['name']);
        $event->setDescription($data['description']);
        $event->setStart(\DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start'])->format('Y-m-d H:i:s'));
        $event->setEnd(\DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end'])->format('Y-m-d H:i:s'));   
        $event->setStatus($data['status']);
      
        return $event;
    }

     /**
     * crée un évenement au niveau de la base de données
     * @param Event $event
     * @throws bool
     */
    public function create (Event $event): bool {
        $statement = $this->pdo->prepare('INSERT INTO events (name, description, start, end, hide, is_published, status, created_at ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        return $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getHide()->format('Y-m-d H:i:s'),
            $event->getPublished()->format('Y-m-d H:i:s'),
            $event->getStatus(),
            $event->getCreated()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Met à jour un évenement au niveau de la base de données
     * @param Event $event
     * @throws bool
     */
    public function update (Event $event): bool {
        $statement = $this->pdo->prepare('UPDATE events SET name = ? , description = ? , start = ? , end = ? , hide = ? , is_published = ? , created_at = ?, status = ? WHERE id = ?');
        return $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getHide()->format('Y-m-d H:i:s'),
            $event->getPublished()->format('Y-m-d H:i:s'),
            $event->getCreated()->format('Y-m-d H:i:s'),
            $event->getStatus(),
            $event->getId()
        ]);
    }

    /**
     * TODO: Supprime un évenement au niveau de la base de données
     * @param Event $event
     * @throws bool
     */
    public function delete (Event $event): bool {
        


        $statement = $this->pdo->prepare('UPDATE events SET name = ? , description = ? , start = ? , end = ? , hide = ? , is_published = ?, status = ?, created_at = ? WHERE id = ?');
        return $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getHide()->format('Y-m-d H:i:s'),
            $event->getPublished()->format('Y-m-d H:i:s'),
            $event->getStatus(),
            $event->getId()
        ]);
    
        return true;
    }
    /**
     * TODO: Modifier le status d'un évenement au niveau de la base de données
     * en le cachant grâce à une modification de $hide 
     * @param Event $event
     * @throws bool
     */
    public function hide (Event $event): bool {
        $statement = $this->pdo->prepare('SELECT event FROM events WHERE id = ? LIMIT 1');
        return $statement->execute([
            $event->getHide()->format('Y-m-d H:i:s'),
            $event->getPublished()->format('Y-m-d H:i:s'),
            $event->getCreated()->format('Y-m-d H:i:s'),
            $event->getStatus(),
            $event->getId()
        ]);
    
        return true;
    }
    /**
     * TODO: Modifier le status d'un évenement au niveau de la base de données
     * en le cachant grâce à une modification de $hide 
     * @param Event $event
     * @throws bool
     */
    public function published (Event $event): bool {
        $statement = $this->pdo->prepare('SELECT event FROM events WHERE id = ? LIMIT 1');
        return $statement->execute([
            $event->getHide()->format('Y-m-d H:i:s'),
            $event->getPublished()->format('Y-m-d H:i:s'),
            $event->getStatus(),
            $event->getId()
        ]);
    
        return true;
    }
    // /**
    //  * @return Event[] Returns an array of Event objects
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
    public function findOneBySomeField($value): ?Event
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
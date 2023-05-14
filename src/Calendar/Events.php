<?php

Namespace App\Calendar;

class Events {

    private $pdo;

    private $btnradio = [];


    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
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
    public function find (int $id): Event {
        
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
}
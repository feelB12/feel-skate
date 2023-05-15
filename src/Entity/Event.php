<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventRepository;
use App\Repository\ClubRepository;
use App\Repository\SessionRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;


/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $descrption;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $hide;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $is_published;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $zippcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $town;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $area;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverFilename;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitudeStartAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitudeStartAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitudeFinishAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitudeFinishAt;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="event")
    */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName (string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getUser(): ?int
    {
        return $this->user;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription (string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setStart (string $start): self 
    {
        $this->start = $start;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return new \DateTimeImmutable($this->start);

        return $this->start;
    }

    public function setEnd (string $end): self 
    {
        $this->end = $end;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return new \DateTimeImmutable($this->end);
        
        return $this->end;
    }

    public function setHide (string $hide): self
    {
        $this->hide = $hide;
    }

    public function getHide(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->hide ?? '');
        
        return $this->hide;
    }

    public function setPublished (string $is_published): self {
        $this->is_published = $is_published;
    }

    public function getPublished(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->is_published ?? '');

    }

    public function setStatus (string $status): self 
    {
        $this->status = $status;
        
        return $this;
    }

    public function getStatus(): ?string 
    {
        return $this->status;
    }

    public function setCreateded (string $created_at): self
    {
        $this->created_at = $created_at;
        
        return $this;
    }

    public function getCreated(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->created_at ?? '');
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZippcode(): ?int
    {
        return $this->zippcode;
    }

    public function setZippcode(int $zippcode): self
    {
        $this->zippcode = $zippcode;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getCoverFilename(): ?string
    {
        return $this->coverFilename;
    }

    public function setCoverFilename(?string $coverFilename): self
    {
        $this->coverFilename = $coverFilename;

        return $this;
    }

    public function getLongitudeStartAt(): ?float
    {
        return $this->longitudeStartAt;
    }

    public function setLongitudeStartAt(?float $longitudeStartAt): self
    {
        $this->longitudeStartAt = $longitudeStartAt;

        return $this;
    }

    public function getLatitudeStartAt(): ?float
    {
        return $this->latitudeStartAt;
    }

    public function setLatitudeStartAt(?float $latitudeStartAt): self
    {
        $this->latitudeStartAt = $latitudeStartAt;

        return $this;
    }

    public function getLongitudeFinishAt(): ?float
    {
        return $this->longitudeFinishAt;
    }

    public function setLongitudeFinishAt(?float $longitudeFinishAt): self
    {
        $this->longitudeFinishAt = $longitudeFinishAt;

        return $this;
    }

    public function getLatitudeFinishAt(): ?float
    {
        return $this->latitudeFinishAt;
    }

    public function setLatitudeFinishAt(?float $latitudeFinishAt): self
    {
        $this->latitudeFinishAt = $latitudeFinishAt;

        return $this;
    }

}
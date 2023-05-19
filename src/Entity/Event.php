<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $start;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $end;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $hide;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $is_published;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $start_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $finish_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverFilename;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitudeStart_at;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitudeStart_at;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitudeFinish_at;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitudeFinish_at;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="event")
    */
    private $user;

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStart(): ?\DateTimeImmutable
    {
        return $this->start;
    }

    public function setStart(?\DateTimeImmutable $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeImmutable
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeImmutable $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getHide(): ?\DateTimeImmutable
    {
        return $this->hide;
    }

    public function setHide(?\DateTimeImmutable $hide): self
    {
        $this->hide = $hide;

        return $this;
    }

    public function getPublished(): ?\DateTimeImmutable
    {
        return $this->is_published;
    }

    public function setPublished(?\DateTimeImmutable $is_published): self
    {
        $this->is_published = $is_published;

        return $this;
    }

    public function getCreated(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreated(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
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

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->start_at;
    }

    public function setStartAt(?\DateTimeImmutable $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getFinishAt(): ?\DateTimeImmutable
    {
        return $this->finish_at;
    }

    public function setFinishAt(?\DateTimeImmutable $finish_at): self
    {
        $this->finish_at = $finish_at;

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
        return $this->longitudeStart_at;
    }

    public function setLongitudeStartAt(?float $longitudeStart_at): self
    {
        $this->longitudeStart_at = $longitudeStart_at;

        return $this;
    }

    public function getLatitudeStartAt(): ?float
    {
        return $this->latitudeStart_at;
    }

    public function setLatitudeStartAt(?float $latitudeStart_at): self
    {
        $this->latitudeStar_at = $latitudeStart_at;

        return $this;
    }

    public function getLongitudeFinishAt(): ?float
    {
        return $this->longitudeFinish_at;
    }

    public function setLongitudeFinishAt(?float $longitudeFinish_at): self
    {
        $this->longitudeFinish_at = $longitudeFinish_at;

        return $this;
    }

    public function getLatitudeFinishAt(): ?float
    {
        return $this->latitudeFinish_at;
    }

    public function setLatitudeFinishAt(?float $latitudeFinish_at): self
    {
        $this->latitudeFinish_at = $latitudeFinish_at;

        return $this;
    }
}

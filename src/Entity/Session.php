<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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
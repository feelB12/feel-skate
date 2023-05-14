<?php

Namespace App\Calendar ;

class Event {

    private $id;

    private $name;

    private $descrption;

    private $start;

    private $end;

    private $hide;

    private $is_published;

    private $created_at;

    private $status;

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description ?? '';
    }

    public function getStart(): \DateTimeInterface {
        return new \DateTimeImmutable($this->start);
    }
    
    public function getEnd(): \DateTimeInterface {
        return new \DateTimeImmutable($this->end);
    }
    
    public function getHide(): \DateTimeInterface {
        return new \DateTimeImmutable($this->hide ?? '');
    }
    
    public function getPublished(): \DateTimeInterface {
        return new \DateTimeImmutable($this->is_published ?? '');
    }

    public function getStatus(): ?string {
        return $this->status;
    }
    public function getCreated(): \DateTimeInterface {
        return new \DateTimeImmutable($this->created_at ?? '');
    }

    public function setName (string $name) {
        $this->name = $name;
    }
    public function setDescription (string $description) {
        $this->description = $description;
    }
    public function setStart (string $start) {
        $this->start = $start;
    }
    public function setEnd (string $end) {
        $this->end = $end;
    }
    public function setHide (string $hide) {
        $this->hide = $hide;
    }
    public function setPublished (string $is_published) {
        $this->is_published = $is_published;
    }
    public function setStatus (string $status) {
        $this->status = $status;
    }
    public function setCreateded (string $created_at) {
        $this->created_at = $created_at;
    }
}
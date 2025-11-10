<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventRequestRepository;

#[ORM\Entity(repositoryClass: EventRequestRepository::class)]
#[ORM\Table(name: "event_requests")]
class EventRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "string", length: 255)]
    private string $email;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $localita = null;

    #[ORM\Column(type: "date", nullable: true)]
    private ?\DateTimeInterface $eventDate = null;

    #[ORM\Column(type: "string", length: 100, options: ["default" => "Non richiesto"])]
    private string $drinkService = 'Non richiesto';

    #[ORM\Column(type: "string", length: 100)]
    private string $eventType;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $meal = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $people = null;

    #[ORM\Column(type: "string", length: 5, nullable: true)]
    private ?string $startTime = null;

    #[ORM\Column(type: "string", length: 5, nullable: true)]
    private ?string $endTime = null;

    #[ORM\Column(type: "json", nullable: true)]
    private ?array $services = [];

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $message = null;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): self { $this->phone = $phone; return $this; }

    public function getLocalita(): ?string { return $this->localita; }
    public function setLocalita(?string $localita): self { $this->localita = $localita; return $this; }

    public function getEventDate(): ?\DateTimeInterface { return $this->eventDate; }
    public function setEventDate(?\DateTimeInterface $d): self { $this->eventDate = $d; return $this; }

    public function getDrinkService(): string { return $this->drinkService; }
    public function setDrinkService(string $s): self { $this->drinkService = $s; return $this; }

    public function getEventType(): string { return $this->eventType; }
    public function setEventType(string $t): self { $this->eventType = $t; return $this; }

    public function getMeal(): ?string { return $this->meal; }
    public function setMeal(?string $m): self { $this->meal = $m; return $this; }

    public function getPeople(): ?int { return $this->people; }
    public function setPeople(?int $p): self { $this->people = $p; return $this; }

    public function getStartTime(): ?string { return $this->startTime; }
    public function setStartTime(?string $t): self { $this->startTime = $t; return $this; }

    public function getEndTime(): ?string { return $this->endTime; }
    public function setEndTime(?string $t): self { $this->endTime = $t; return $this; }

    public function getServices(): ?array { return $this->services; }
    public function setServices(?array $s): self { $this->services = $s; return $this; }

    public function getMessage(): ?string { return $this->message; }
    public function setMessage(?string $m): self { $this->message = $m; return $this; }

    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
    public function setCreatedAt(\DateTimeInterface $dt): self { $this->createdAt = $dt; return $this; }
}
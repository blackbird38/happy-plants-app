<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionHistoryRepository")
 */
class ActionHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Action", inversedBy="actionHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_action;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="actionHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @Assert\Positive
     * @ORM\Column(type="float")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant", inversedBy="actionHistories")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $id_plant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAction(): ?Action
    {
        return $this->id_action;
    }

    public function setIdAction(?Action $id_action): self
    {
        $this->id_action = $id_action;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getIdPlant(): ?Plant
    {
        return $this->id_plant;
    }

    public function setIdPlant(?Plant $id_plant): self
    {
        $this->id_plant = $id_plant;

        return $this;
    }
}

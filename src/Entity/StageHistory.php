<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageHistoryRepository")
 */
class StageHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stage", inversedBy="stageHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_stage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant", inversedBy="stageHistories")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $id_plant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStage(): ?Stage
    {
        return $this->id_stage;
    }

    public function setIdStage(?Stage $id_stage): self
    {
        $this->id_stage = $id_stage;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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

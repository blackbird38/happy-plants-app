<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StageHistory", mappedBy="id_stage")
     */
    private $stageHistories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->stageHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|StageHistory[]
     */
    public function getStageHistories(): Collection
    {
        return $this->stageHistories;
    }

    public function addStageHistory(StageHistory $stageHistory): self
    {
        if (!$this->stageHistories->contains($stageHistory)) {
            $this->stageHistories[] = $stageHistory;
            $stageHistory->setIdStage($this);
        }

        return $this;
    }

    public function removeStageHistory(StageHistory $stageHistory): self
    {
        if ($this->stageHistories->contains($stageHistory)) {
            $this->stageHistories->removeElement($stageHistory);
            // set the owning side to null (unless already changed)
            if ($stageHistory->getIdStage() === $this) {
                $stageHistory->setIdStage(null);
            }
        }

        return $this;
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
}

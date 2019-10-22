<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlantRepository")
 */
class Plant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Species", inversedBy="plants", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_species;

    /**
     * @ORM\Column(type="date")
     */
    private $birth_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="plants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_place;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medium", inversedBy="plants", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_medium;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StageHistory", mappedBy="id_plant", fetch="EAGER")
     */
    private $stageHistories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActionHistory", mappedBy="id_plant", fetch="EAGER")
     */
    private $actionHistories;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="plants", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stage", inversedBy="plants", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_stage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    public function __construct()
    {
        $this->stageHistories = new ArrayCollection();
        $this->actionHistories = new ArrayCollection();
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

    public function getIdSpecies(): ?Species
    {
        return $this->id_species;
    }

    public function setIdSpecies(?Species $id_species): self
    {
        $this->id_species = $id_species;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getIdPlace(): ?Place
    {
        return $this->id_place;
    }

    public function setIdPlace(?Place $id_place): self
    {
        $this->id_place = $id_place;

        return $this;
    }

    public function getIdMedium(): ?Medium
    {
        return $this->id_medium;
    }

    public function setIdMedium(?Medium $id_medium): self
    {
        $this->id_medium = $id_medium;

        return $this;
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
            $stageHistory->setIdPlant($this);
        }

        return $this;
    }

    public function removeStageHistory(StageHistory $stageHistory): self
    {
        if ($this->stageHistories->contains($stageHistory)) {
            $this->stageHistories->removeElement($stageHistory);
            // set the owning side to null (unless already changed)
            if ($stageHistory->getIdPlant() === $this) {
                $stageHistory->setIdPlant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ActionHistory[]
     */
    public function getActionHistories(): Collection
    {
        return $this->actionHistories;
    }

    public function addActionHistory(ActionHistory $actionHistory): self
    {
        if (!$this->actionHistories->contains($actionHistory)) {
            $this->actionHistories[] = $actionHistory;
            $actionHistory->setIdPlant($this);
        }

        return $this;
    }

    public function removeActionHistory(ActionHistory $actionHistory): self
    {
        if ($this->actionHistories->contains($actionHistory)) {
            $this->actionHistories->removeElement($actionHistory);
            // set the owning side to null (unless already changed)
            if ($actionHistory->getIdPlant() === $this) {
                $actionHistory->setIdPlant(null);
            }
        }

        return $this;
    }

    public function getOwnerId(): ?User
    {
        return $this->owner_id;
    }

    public function setOwnerId(?User $owner_id): self
    {
        $this->owner_id = $owner_id;

        return $this;
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}

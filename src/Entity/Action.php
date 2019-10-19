<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 */
class Action
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
     * @ORM\OneToMany(targetEntity="App\Entity\ActionHistory", mappedBy="id_action")
     */
    private $actionHistories;

    public function __construct()
    {
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
            $actionHistory->setIdAction($this);
        }

        return $this;
    }

    public function removeActionHistory(ActionHistory $actionHistory): self
    {
        if ($this->actionHistories->contains($actionHistory)) {
            $this->actionHistories->removeElement($actionHistory);
            // set the owning side to null (unless already changed)
            if ($actionHistory->getIdAction() === $this) {
                $actionHistory->setIdAction(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeDesignerRepository")
 */
class TypeDesigner
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
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Designer", mappedBy="types")
     */
    private $designers;

    public function __construct()
    {
        $this->designers = new ArrayCollection();
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
     * @return Collection|Designer[]
     */
    ##TODO: Fix me "A circular reference has been detected when serializine"
    private function getDesigners(): Collection
    {
        return $this->designers;
    }

    public function addDesigner(Designer $designer): self
    {
        if (!$this->designers->contains($designer)) {
            $this->designers[] = $designer;
            $designer->setTypes($this);
        }

        return $this;
    }

    public function removeDesigner(Designer $designer): self
    {
        if ($this->designers->contains($designer)) {
            $this->designers->removeElement($designer);
            // set the owning side to null (unless already changed)
            if ($designer->getTypes() === $this) {
                $designer->setTypes(null);
            }
        }

        return $this;
    }
}

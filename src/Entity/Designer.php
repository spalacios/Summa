<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DesignerRepository")
 */
class Designer extends Employee
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDesigner", inversedBy="designers")
     */
    private $types;

    public function getTypes(): ?TypeDesigner
    {
        return $this->types;
    }

    public function setTypes(?TypeDesigner $types): self
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Costom Methods
     */
    ##TODO: Fix me "A circular reference has been detected when serializine"
    ##TODO: Fix me getTypes for get Type
    public function customSerialize()
    {
        return [
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'lastName'      => $this->getLastName(),
            'age'           => $this->getAge(),
            'company'       =>[
                'id'      => $this->getCompany()->getId(),
                'name'    => $this->getCompany()->getName(),
            ],
            'type'   => [
                'id'   => $this->getTypes()->getId(),
                'name' => $this->getTypes()->getName(),
            ]
        ];
    }
}

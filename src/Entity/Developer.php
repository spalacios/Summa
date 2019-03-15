<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeveloperRepository")
 */
class Developer extends Employee
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="developers")
     */
    private $language;

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Costom Methods
     */
    ##TODO: Fix me "A circular reference has been detected when serializine"
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
            'language'   => [
                'id'   => $this->getLanguage()->getId(),
                'name' => $this->getLanguage()->getName(),
            ]
        ];
    }
}

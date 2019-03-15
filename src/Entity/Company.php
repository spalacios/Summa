<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use function PHPSTORM_META\type;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
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
     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="company", cascade={"persist","remove"})
     */
    private $employees;


    public function __construct()
    {
        $this->employees = new ArrayCollection();
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
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->setCompany($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->contains($employee)) {
            $this->employees->removeElement($employee);
            // set the owning side to null (unless already changed)
            if ($employee->getCompany() === $this) {
                $employee->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return float|int|null
     */
    public function getAverageAge()
    {
        $acum = 0;
        foreach ($this->employees as $employee){
            $acum += $employee->getAge();
        }

        return ($this->employees->isEmpty()) ? null : number_format($acum / $this->employees->count(), 2, '.', '');
    }

    /**
     * Costom Methods
     */
    ##TODO: Fix me "A circular reference has been detected when serializine"

    /**
     * @return array
     */
    public function customSerialize()
    {
        return [
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'employees'     => $this->serializeEmployees($this->employees),
            'averageAge'    => $this->getAverageAge()
        ];
    }

    /**
     * @param ArrayCollection $employees
     * @return null
     */
    private function serializeEmployees(){
        foreach ($this->employees as $employee){
            $result[] = [
                'id'        => $employee->getId(),
                'name'      => $employee->getName(),
                'lastName'  => $employee->getLastName(),
                'age'       => $employee->getAge(),
                'class'     => get_class($employee)
            ];
        }

        return (isset($result)) ? $result : null;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AffaireRepository")
 */
class Affaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $designation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Politicien", inversedBy="lesAffaires")
     */
    private $lesPoliticiens;

    public function __construct()
    {
        $this->lesPoliticiens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection|Politicien[]
     */
    public function getLesPoliticiens(): Collection
    {
        return $this->lesPoliticiens;
    }

    public function addLesPoliticien(Politicien $lesPoliticien): self
    {
        if (!$this->lesPoliticiens->contains($lesPoliticien)) {
            $this->lesPoliticiens[] = $lesPoliticien;
        }

        return $this;
    }

    public function removeLesPoliticien(Politicien $lesPoliticien): self
    {
        if ($this->lesPoliticiens->contains($lesPoliticien)) {
            $this->lesPoliticiens->removeElement($lesPoliticien);
        }

        return $this;
    }
}

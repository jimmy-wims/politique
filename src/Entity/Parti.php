<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartiRepository")
 */
class Parti
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Politicien", mappedBy="parti")
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
            $lesPoliticien->setParti($this);
        }

        return $this;
    }

    public function removeLesPoliticien(Politicien $lesPoliticien): self
    {
        if ($this->lesPoliticiens->contains($lesPoliticien)) {
            $this->lesPoliticiens->removeElement($lesPoliticien);
            // set the owning side to null (unless already changed)
            if ($lesPoliticien->getParti() === $this) {
                $lesPoliticien->setParti(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}

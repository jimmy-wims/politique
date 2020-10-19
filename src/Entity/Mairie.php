<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MairieRepository")
 */
class Mairie
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
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Politicien", mappedBy="mairie")
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

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

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
            $lesPoliticien->setMairie($this);
        }

        return $this;
    }

    public function removeLesPoliticien(Politicien $lesPoliticien): self
    {
        if ($this->lesPoliticiens->contains($lesPoliticien)) {
            $this->lesPoliticiens->removeElement($lesPoliticien);
            // set the owning side to null (unless already changed)
            if ($lesPoliticien->getMairie() === $this) {
                $lesPoliticien->setMairie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->ville;
    }
}

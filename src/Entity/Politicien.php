<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PoliticienRepository")
 */
class Politicien
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
     * @ORM\Column(type="string", length=1)
     * @Assert\Regex(pattern="/^M$|^F$/",
     *                  message="la valeur de sexe doit être M ou F")
     */
    private $sexe;

    /**
     * @ORM\Column(type="smallint")
     *  @Assert\GreaterThanOrEqual(value = 18,
     *                          message="la valeur de l'age doit être >= {{ compared_value }}")
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parti", inversedBy="lesPoliticiens")
     */
    private $parti;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Affaire", mappedBy="lesPoliticiens")
     */
    private $lesAffaires;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mairie", inversedBy="lesPoliticiens")
     */
    private $mairie;

    public function __construct()
    {
        $this->lesAffaires = new ArrayCollection();
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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getParti(): ?Parti
    {
        return $this->parti;
    }

    public function setParti(?Parti $parti): self
    {
        $this->parti = $parti;

        return $this;
    }

    /**
     * @return Collection|Affaire[]
     */
    public function getLesAffaires(): Collection
    {
        return $this->lesAffaires;
    }

    public function addLesAffaire(Affaire $lesAffaire): self
    {
        if (!$this->lesAffaires->contains($lesAffaire)) {
            $this->lesAffaires[] = $lesAffaire;
            $lesAffaire->addLesPoliticien($this);
        }

        return $this;
    }

    public function removeLesAffaire(Affaire $lesAffaire): self
    {
        if ($this->lesAffaires->contains($lesAffaire)) {
            $this->lesAffaires->removeElement($lesAffaire);
            $lesAffaire->removeLesPoliticien($this);
        }

        return $this;
    }

    public function getMairie(): ?Mairie
    {
        return $this->mairie;
    }

    public function setMairie(?Mairie $mairie): self
    {
        $this->mairie = $mairie;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}

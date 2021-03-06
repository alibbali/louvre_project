<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletsRepository")
 */
class Billets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      maxMessage = "Votre nom n'est il pas trop long ?")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     *@Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Votre nom est trop court.",
     *      maxMessage = "Votre nom n'est il pas trop long ?")
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    private $naissance;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Country
     */
    private $pays;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reduction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="billets")
     * @ORM\JoinColumn(name="reservation_id", referencedColumnName="id")
     */
    private $reservation;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNaissance(): ?\DateTimeInterface
    {
        return $this->naissance;
    }

    public function setNaissance(\DateTimeInterface $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getReduction(): ?bool
    {
        return $this->reduction;
    }

    public function setReduction(bool $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }
/* 
    public function getBillets(): ?Billets
    {
        return $this->billets;
    }

    public function setBillets(?Billets $billets): self
    {
        $this->billets = $billets;

        return $this;
    }
 */
    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }
}

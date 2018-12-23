<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="nom")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_reservation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reduced;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdReservation(): ?Reservation
    {
        return $this->id_reservation;
    }

    public function setIdReservation(?Reservation $id_reservation): self
    {
        $this->id_reservation = $id_reservation;

        return $this;
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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getReduced(): ?bool
    {
        return $this->reduced;
    }

    public function setReduced(?bool $reduced): self
    {
        $this->reduced = $reduced;

        return $this;
    }

    public function getCodeReservation(): ?string
    {
        return $this->code_reservation;
    }

    public function setCodeReservation(string $code_reservation): self
    {
        $this->code_reservation = $code_reservation;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint;
use App\Validator\CheckBillets;
Use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     * @Assert\GreaterThanOrEqual("today UTC")
     */
    private $dateVisite;

    /**
     * @ORM\Column(type="text")
     * @Assert\Email(
     *     message="Le mail '{{value}}' est invalide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Billets", inversedBy="reservations", cascade={"persist"})
     * @Assert\Valid()
     */
    private $billets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $serialNumber;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->dateVisite = new \DateTime();
        $this->billets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }


    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function createSerialNumber() {
        //Il faut trouver un moyen de créer un serial number 
    }

    public function addBillet(Billets $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setReservations($this);
        }

        return $this;
    }

    public function removeBillet(Billets $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getReservations() === $this) {
                $billet->setReservations(null);
            }
        }

        return $this;
    }
}

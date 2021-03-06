<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicule::class, inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idVehicule;

    /**
     * @ORM\Column(type="text")
     */
    private $plateformeLocation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $parcStationnement;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remarque;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idLocationGetaround;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVehicule(): ?Vehicule
    {
        return $this->idVehicule;
    }

    public function setIdVehicule(?Vehicule $idVehicule): self
    {
        $this->idVehicule = $idVehicule;

        return $this;
    }

    public function getPlateformeLocation(): ?string
    {
        return $this->plateformeLocation;
    }

    public function setPlateformeLocation(string $plateformeLocation): self
    {
        $this->plateformeLocation = $plateformeLocation;

        return $this;
    }

    public function getParcStationnement(): ?string
    {
        return $this->parcStationnement;
    }

    public function setParcStationnement(?string $parcStationnement): self
    {
        $this->parcStationnement = $parcStationnement;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdLocationGetaround(): ?int
    {
        return $this->idLocationGetaround;
    }

    public function setIdLocationGetaround(?int $idLocationGetaround): self
    {
        $this->idLocationGetaround = $idLocationGetaround;

        return $this;
    }
}

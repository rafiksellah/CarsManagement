<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehiculeRepository::class)
 */
class Vehicule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $parcStationnementVille;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="text")
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="date")
     */
    private $dateImmatriculation;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombrePlace;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombrePorte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phaseFinition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $energie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleur;


    /**
     * @ORM\Column(type="date")
     */
    private $dataAchat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kilometrageAchat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $options;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="idVehicule")
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity=Depenses::class, mappedBy="idVehicule")
     */
    private $depenses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mark;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idVehiculeGetaround;


    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->depenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getParcStationnementVille(): ?string
    {
        return $this->parcStationnementVille;
    }

    public function setParcStationnementVille(string $parcStationnementVille): self
    {
        $this->parcStationnementVille = $parcStationnementVille;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getDateImmatriculation(): ?\DateTimeInterface
    {
        return $this->dateImmatriculation;
    }

    public function setDateImmatriculation(\DateTimeInterface $dateImmatriculation): self
    {
        $this->dateImmatriculation = $dateImmatriculation;

        return $this;
    }

    public function getNombrePlace(): ?int
    {
        return $this->nombrePlace;
    }

    public function setNombrePlace(int $nombrePlace): self
    {
        $this->nombrePlace = $nombrePlace;

        return $this;
    }

    public function getNombrePorte(): ?int
    {
        return $this->nombrePorte;
    }

    public function setNombrePorte(int $nombrePorte): self
    {
        $this->nombrePorte = $nombrePorte;

        return $this;
    }

    public function getPhaseFinition(): ?string
    {
        return $this->phaseFinition;
    }

    public function setPhaseFinition(string $phaseFinition): self
    {
        $this->phaseFinition = $phaseFinition;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(string $energie): self
    {
        $this->energie = $energie;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getDataAchat(): ?\DateTimeInterface
    {
        return $this->dataAchat;
    }

    public function setDataAchat(\DateTimeInterface $dataAchat): self
    {
        $this->dataAchat = $dataAchat;

        return $this;
    }

    public function getKilometrageAchat(): ?int
    {
        return $this->kilometrageAchat;
    }

    public function setKilometrageAchat(?int $kilometrageAchat): self
    {
        $this->kilometrageAchat = $kilometrageAchat;

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

    public function getOptions(): ?array
    {
        return explode(',', $this->options);
    }

    public function setOptions(?array $options): self
    {
        $this->options = implode(',', $options);

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setIdVehicule($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getIdVehicule() === $this) {
                $location->setIdVehicule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Depenses[]
     */
    public function getDepenses(): Collection
    {
        return $this->depenses;
    }

    public function addDepense(Depenses $depense): self
    {
        if (!$this->depenses->contains($depense)) {
            $this->depenses[] = $depense;
            $depense->setIdVehicule($this);
        }

        return $this;
    }

    public function removeDepense(Depenses $depense): self
    {
        if ($this->depenses->removeElement($depense)) {
            // set the owning side to null (unless already changed)
            if ($depense->getIdVehicule() === $this) {
                $depense->setIdVehicule(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->model.' - '.$this->immatriculation;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIdVehiculeGetaround(): ?int
    {
        return $this->idVehiculeGetaround;
    }

    public function setIdVehiculeGetaround(?int $idVehiculeGetaround): self
    {
        $this->idVehiculeGetaround = $idVehiculeGetaround;

        return $this;
    }

}

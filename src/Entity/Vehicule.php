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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modeFinancement;

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
    private $dateDebutContrat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $apport;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dureeFinancement;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $loyerMensuel;

    /**
     * @ORM\Column(type="date")
     */
    private $dataAchat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kilometrageAchat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
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

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->depenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModeFinancement(): ?string
    {
        return $this->modeFinancement;
    }

    public function setModeFinancement(?string $modeFinancement): self
    {
        $this->modeFinancement = $modeFinancement;

        return $this;
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

    public function getDateDebutContrat(): ?\DateTimeInterface
    {
        return $this->dateDebutContrat;
    }

    public function setDateDebutContrat(\DateTimeInterface $dateDebutContrat): self
    {
        $this->dateDebutContrat = $dateDebutContrat;

        return $this;
    }

    public function getApport(): ?string
    {
        return $this->apport;
    }

    public function setApport(?string $apport): self
    {
        $this->apport = $apport;

        return $this;
    }

    public function getDureeFinancement(): ?int
    {
        return $this->dureeFinancement;
    }

    public function setDureeFinancement(?int $dureeFinancement): self
    {
        $this->dureeFinancement = $dureeFinancement;

        return $this;
    }

    public function getLoyerMensuel(): ?string
    {
        return $this->loyerMensuel;
    }

    public function setLoyerMensuel(?string $loyerMensuel): self
    {
        $this->loyerMensuel = $loyerMensuel;

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

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(?string $options): self
    {
        $this->options = $options;

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
}

<?php

namespace AnnoncesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="AnnoncesBundle\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDep", type="datetime")
     */
    private $dateDep;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateArr", type="datetime")
     */
    private $dateArr;

    /**
     * @var int
     *
     * @ORM\Column(name="annonceur", type="integer")
     */
    private $id_annonceur;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_places", type="integer", nullable=true)
     */
    private $nbPlaces;

    /**
     * @var int
     *
     * @ORM\Column(name="duree_detour", type="integer", nullable=true)
     */
    private $dureeDetour;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=true)
     */
    private $prix;


    /**
     * @var string
     *
     * @ORM\Column(name="ville_dep", type="string", length=255, nullable=true)
     */
    private $villeDep;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_arr", type="string", length=255, nullable=true)
     */
    private $villeArr;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_dep", type="string", length=255, nullable=true)
     */
    private $adresseDep;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_arr", type="string", length=255, nullable=true)
     */
    private $adresseArr;

    /**
     * @var int
     *
     * @ORM\Column(name="id_conducteur", type="integer")
     */
    private $id_conducteur;

    /**
     * @var array
     *
     * @ORM\Column(name="array_passagers", type="integer", nullable=true)
     */
    private $array_passagers;




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set trajet
     *
     * @param integer $trajet
     *
     * @return Annonce
     */
    public function setTrajet($trajet)
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
     * Get trajet
     *
     * @return int
     */
    public function getTrajet()
    {
        return $this->trajet;
    }

    /**
     * Set annonceur
     *
     * @param int $annonceur
     *
     * @return Annonce
     */
    public function setId_annonceur($annonceur)
    {
        $this->id_annonceur = $annonceur;

        return $this;
    }

    /**
     * Get annonceur
     *
     * @return int
     */
    public function getId_annonceur()
    {
        return $this->id_annonceur;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Annonce
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Annonce
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     *
     * @return Annonce
     */
    public function setNbPlaces($nbPlaces)
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    /**
     * Get nbPlaces
     *
     * @return int
     */
    public function getNbPlaces()
    {
        return $this->nbPlaces;
    }

    /**
     * Set dureeDetour
     *
     * @param integer $dureeDetour
     *
     * @return Annonce
     */
    public function setDureeDetour($dureeDetour)
    {
        $this->dureeDetour = $dureeDetour;

        return $this;
    }

    /**
     * Get dureeDetour
     *
     * @return int
     */
    public function getDureeDetour()
    {
        return $this->dureeDetour;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Annonce
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set idAnnonceur
     *
     * @param string $idAnnonceur
     *
     * @return Annonce
     */
    public function setIdAnnonceur($idAnnonceur)
    {
        $this->id_annonceur = $idAnnonceur;

        return $this;
    }

    /**
     * Get idAnnonceur
     *
     * @return string
     */
    public function getIdAnnonceur()
    {
        return $this->id_annonceur;
    }

    /**
     * Set dateDep
     *
     * @param \DateTime $dateDep
     *
     * @return Annonce
     */
    public function setDateDep($dateDep)
    {
        $this->dateDep = $dateDep;

        return $this;
    }

    /**
     * Get dateDep
     *
     * @return \DateTime
     */
    public function getDateDep()
    {
        return $this->dateDep;
    }

    /**
     * Set dateArr
     *
     * @param \DateTime $dateArr
     *
     * @return Annonce
     */
    public function setDateArr($dateArr)
    {
        $this->dateArr = $dateArr;

        return $this;
    }

    /**
     * Get dateArr
     *
     * @return \DateTime
     */
    public function getDateArr()
    {
        return $this->dateArr;
    }

    /**
     * Set villeDep
     *
     * @param string $villeDep
     *
     * @return Annonce
     */
    public function setVilleDep($villeDep)
    {
        $this->villeDep = $villeDep;

        return $this;
    }

    /**
     * Get villeDep
     *
     * @return string
     */
    public function getVilleDep()
    {
        return $this->villeDep;
    }

    /**
     * Set villeArr
     *
     * @param string $villeArr
     *
     * @return Annonce
     */
    public function setVilleArr($villeArr)
    {
        $this->villeArr = $villeArr;

        return $this;
    }

    /**
     * Get villeArr
     *
     * @return string
     */
    public function getVilleArr()
    {
        return $this->villeArr;
    }

    /**
     * Set adresseDep
     *
     * @param string $adresseDep
     *
     * @return Annonce
     */
    public function setAdresseDep($adresseDep)
    {
        $this->adresseDep = $adresseDep;

        return $this;
    }

    /**
     * Get adresseDep
     *
     * @return string
     */
    public function getAdresseDep()
    {
        return $this->adresseDep;
    }

    /**
     * Set adresseArr
     *
     * @param string $adresseArr
     *
     * @return Annonce
     */
    public function setAdresseArr($adresseArr)
    {
        $this->adresseArr = $adresseArr;

        return $this;
    }

    /**
     * Get adresseArr
     *
     * @return string
     */
    public function getAdresseArr()
    {
        return $this->adresseArr;
    }

    /**
     * Set idConducteur
     *
     * @param integer $idConducteur
     *
     * @return Annonce
     */
    public function setIdConducteur($idConducteur)
    {
        $this->id_conducteur = $idConducteur;

        return $this;
    }

    /**
     * Get idConducteur
     *
     * @return integer
     */
    public function getIdConducteur()
    {
        return $this->id_conducteur;
    }

    /**
     * Set arrayPassagers
     *
     * @param array $arrayPassagers
     *
     * @return Annonce
     */
    public function setArrayPassagers($arrayPassagers)
    {
        $this->array_passagers = $arrayPassagers;

        return $this;
    }

    /**
     * Get arrayPassagers
     *
     * @return array
     */
    public function getArrayPassagers()
    {
        return $this->array_passagers;
    }
}

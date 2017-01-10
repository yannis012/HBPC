<?php

namespace HBPC\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Composant
 *
 * @ORM\Table(name="composant")
 * @ORM\Entity(repositoryClass="HBPC\ToolsBundle\Repository\ComposantRepository")
 */
class Composant
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
     * @ORM\ManyToOne(targetEntity="HBPC\ToolsBundle\Entity\Categorie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=100)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_vente", type="decimal", precision=10, scale=2)
     */
    private $prixVente;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_achat", type="decimal", precision=10, scale=2)
     */
    private $prixAchat;

    /**
     * @var string
     *
     * @ORM\Column(name="fournisseur", type="string", length=100)
     */
    private $fournisseur;

    /**
     * @var string
     *
     * @ORM\Column(name="fournisseur_ref", type="string", length=100)
     */
    private $fournisseurRef;
    
    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="smallint")
     */
    private $stock;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setCategorie(Categorie $categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }
    
    public function getCategorie()
    {
        return $this->categorie;
    }
    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Composants
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Composants
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set prixVente
     *
     * @param string $prixVente
     *
     * @return Composants
     */
    public function setPrixVente($prixVente)
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    /**
     * Get prixVente
     *
     * @return string
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * Set prixAchat
     *
     * @param string $prixAchat
     *
     * @return Composants
     */
    public function setPrixAchat($prixAchat)
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    /**
     * Get prixAchat
     *
     * @return string
     */
    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    /**
     * Set fournisseur
     *
     * @param string $fournisseur
     *
     * @return Composants
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return string
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set fournisseurRef
     *
     * @param string $fournisseurRef
     *
     * @return Composants
     */
    public function setFournisseurRef($fournisseurRef)
    {
        $this->fournisseurRef = $fournisseurRef;

        return $this;
    }

    /**
     * Get fournisseurRef
     *
     * @return string
     */
    public function getFournisseurRef()
    {
        return $this->fournisseurRef;
    }

    
    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Composants
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }
}


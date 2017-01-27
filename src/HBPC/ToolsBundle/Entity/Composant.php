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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="HBPC\ToolsBundle\Entity\Categorie", inversedBy="composants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;
    
    /**
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(name="reference", type="string", length=100)
     */
    private $reference;

    /**
     * @ORM\Column(name="prix_vente", type="decimal", precision=10, scale=2)
     */
    private $prixVente;

    /**
     * @ORM\Column(name="prix_achat", type="decimal", precision=10, scale=2)
     */
    private $prixAchat;

    /**
     * @ORM\Column(name="fournisseur", type="string", length=100)
     */
    private $fournisseur;

    /**
     * @ORM\Column(name="fournisseur_ref", type="string", length=100)
     */
    private $fournisseurRef;
    
    /**
     * @ORM\Column(name="stock", nullable=true, type="smallint", options={"default":0})
     */
    private $stock;

    public function getPrixVenteTTC(){
        return round(($this->prixVente)*1.2, 2);
    }
    
    public function getPrixAchatTTC(){
        return round(($this->prixAchat)*1.2, 2);
    }
    
    public function getMargeTTC(){
        return round(100-(($this->getPrixAchatTTC()*100)/$this->getPrixVenteTTC()), 1);
    }
    public function getCategorie()
    {
        return $this->categorie;
    }
    
    public function setCategorie(Categorie $categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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


<?php

namespace HBPC\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Configuration
 *
 * @ORM\Table(name="configuration")
 * @ORM\Entity(repositoryClass="HBPC\ToolsBundle\Repository\ConfigurationRepository")
 */
class Configuration
{
    // Constructeur
    public function __construct()
    {
      $this->composants = new ArrayCollection();
    }
    
    /**
     * @ORM\ManyToMany(targetEntity="HBPC\ToolsBundle\Entity\Composant", cascade={"persist"})
     */
    private $composants;
    
    /**
    * @ORM\ManyToOne(targetEntity="HBPC\ToolsBundle\Entity\Gamme")
    * @ORM\JoinColumn(nullable=false)
    */
    private $gamme;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @ORM\Column(name="reference", type="string", length=50)
     */
    private $reference;
    /**
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     */
    private $prix;
    /**
     * @ORM\Column(name="maj", nullable=true, type="boolean", options={"default":0})
     */
    private $maj;

    public function margeAssemblage(){
        return round($this->prix-$this->venteComposants()-$this->commissionCB()-$this->manutention(), 2);
    }
    
    public function margePC(){
        return round($this->prix-$this->achatsComposants()-$this->commissionCB()-$this->manutention(), 2);
    }
    
    public function margePCPourcent(){
        return round($this->margePC()*100/$this->prix);
    }
    
    public function margeComposants(){
        $vente=0;
        foreach($this->getComposants() as $c){
            $vente+=$c->getPrixVenteTTC();
        }
        return $vente-$this->achatsComposants()." €";
    }
    public function margeComposantsPourcent(){
        if($this->venteComposants() != 0){
            return round(100-$this->achatsComposants()*100/$this->venteComposants(), 2);
        }else{
            return 0;
        }
    }
    
    public function commissionCB(){
        return round($this->prix*0.008, 2);
    }
    
    public function manutention(){
        return 10;
    }
    
    public function prixVenteHT(){
        return $this->prix/1.2;
    }
    
    public function achatsComposants(){
        $total=0;
        foreach($this->getComposants() as $c){
            $total+=$c->getPrixAchatTTC();
        }
        return $total;
    }
    public function venteComposants(){
        $total=0;
        foreach($this->getComposants() as $c){
            $total+=$c->getPrixVenteTTC();
        }
        return $total;
    }
    
    public function getComposants()
    {
        return $this->composants;
    }
    
    public function addComposant(Composant $composant)
    {
        $this->composant[] = $composant;
    }
    
    public function removeComposant(Composant $composant)
    {
        $this->composants->removeElement($composant);
    }
    
    public function setGamme(Gamme $gam){
        $this->gamme = $gam;
        return $this;
    }
    
    public function getGamme(){
        return $this->gamme;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
    
    public function getNom()
    {
        return $this->nom;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    public function setMaj($maj)
    {
        $this->maj = $maj;

        return $this;
    }

    public function getMaj()
    {
        return $this->maj;
    }
    
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }
}

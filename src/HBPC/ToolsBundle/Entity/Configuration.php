<?php

namespace HBPC\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 *
 * @ORM\Table(name="configuration")
 * @ORM\Entity(repositoryClass="HBPC\ToolsBundle\Repository\ConfigurationRepository")
 */
class Configuration
{
    
    /**
    * @ORM\ManyToMany(targetEntity="HBPC\ToolsBundle\Entity\Composant", cascade={"persist"})
    */
    private $composants;
    
    public function __construct()
    {
      $this->composants = new ArrayCollection();
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @var bool
     *
     * @ORM\Column(name="maj", type="boolean")
     */
    private $maj;

    
    
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Configurations
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
     * Set prix
     *
     * @param string $prix
     *
     * @return Configurations
     */
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

    /**
     * Set maj
     *
     * @param boolean $maj
     *
     * @return Configurations
     */
    public function setMaj($maj)
    {
        $this->maj = $maj;

        return $this;
    }

    /**
     * Get maj
     *
     * @return bool
     */
    public function getMaj()
    {
        return $this->maj;
    }
    
}


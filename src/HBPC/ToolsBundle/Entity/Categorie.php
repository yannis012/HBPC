<?php

namespace HBPC\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="HBPC\ToolsBundle\Repository\CategorieRepository")
 */
class Categorie
{
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
     * @Assert\Length(min=2)
     */
    private $nom; 
    
    /**
     * @var smallint
     *
     * @ORM\Column(name="position", nullable=true, type="smallint", options={"default":0})
     */
    private $position;
    
    /**
     * @ORM\OneToMany(targetEntity="HBPC\ToolsBundle\Entity\Composant", mappedBy="categorie")
     */
    private $composants;
    
    public function addComposant(Composant $composant)
    {
        $this->composants[] = $composant;
        $composant->setCategorie($this);
        return $this;
    }
    
    public function removeComposant(Composant $composant)
    {
        $this->composants->removeElement($composant);
    }
    
    public function getComposants(){
        return $this->composants;
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


    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Categorie
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}

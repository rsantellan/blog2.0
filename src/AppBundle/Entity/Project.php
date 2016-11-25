<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 * 
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 * @ORM\Table(name="rs_project")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\ProjectTranslation")
 * @author Rodrigo Santellan
 */
class Project{
  /**
   *
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   * 
   */
  protected $id;
  
  /**
   * @Gedmo\Translatable
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank()
   */
  protected $name;
  
  /**
   * 
   * @ORM\Column(type="string", length=100, nullable=true)
   * @Assert\NotBlank()
   */
  protected $cliente;
  
  /**
   * @Gedmo\Translatable
   * @ORM\Column(type="text", nullable=true)
   */
  protected $tipo_de_trabajo;
  
  /**
   * @Gedmo\Translatable
   * @ORM\Column(type="text", nullable=true)
   */
  protected $description;
  
  
  /**
   * @Gedmo\SortablePosition
   * @ORM\Column(type="integer")
   */
  protected $orden;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;
    
    

    /**
     * @var Category
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="projects")
     * @ORM\JoinTable(name="rs_project_category") 
     * 
     */
    protected $category;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
    */
    protected $slug;

    /**
     *
     * @var ComplexTag
     * @ORM\ManyToMany(targetEntity="ComplexTag", inversedBy="projects")
     * @ORM\JoinTable(name="rs_project_complex_tag",
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="complextag_id", referencedColumnName="id")}
     *      ) 
     */
    protected $complexTags;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cliente
     *
     * @param string $cliente
     * @return Project
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return string 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set tipo_de_trabajo
     *
     * @param string $tipoDeTrabajo
     * @return Project
     */
    public function setTipoDeTrabajo($tipoDeTrabajo)
    {
        $this->tipo_de_trabajo = $tipoDeTrabajo;
    
        return $this;
    }

    /**
     * Get tipo_de_trabajo
     *
     * @return string 
     */
    public function getTipoDeTrabajo()
    {
        return $this->tipo_de_trabajo;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
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
     * Set orden
     *
     * @param integer $orden
     * @return Project
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    
        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Add complexTags
     *
     * @param \AppBundle\Entity\Category $category
     * @return Project
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->category[] = $category;
    
        return $this;
    }

    /**
     * Remove complexTags
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }
    
    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Project
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function getFullClassName()
    {
      return get_class($this);
    }
    
    
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
    
    public function retrieveAlbums()
    {
      return array("main", "images");
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->complexTags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add complexTags
     *
     * @param \AppBundle\Entity\ComplexTag $complexTags
     * @return Project
     */
    public function addComplexTag(\AppBundle\Entity\ComplexTag $complexTags)
    {
        $this->complexTags[] = $complexTags;
    
        return $this;
    }

    /**
     * Remove complexTags
     *
     * @param \AppBundle\Entity\ComplexTag $complexTags
     */
    public function removeComplexTag(\AppBundle\Entity\ComplexTag $complexTags)
    {
        $this->complexTags->removeElement($complexTags);
    }

    /**
     * Get complexTags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComplexTags()
    {
        return $this->complexTags;
    }
}


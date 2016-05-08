<?php

// src/AppBundle/Entity/Product.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $description;
	
	/**
     * @var datetime $created
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var simple_array $tags
     * @ORM\Column(type="simple_array", nullable = true)
     */
    private $tags;
	
	/**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $impath;
	
	/**
     * @Assert\File(maxSize="6000000")
     */
    private $imfile;

	/**
     * Sets imfile.
     *
     * @param UploadedFile $file
     */
    public function setImfile(UploadedFile $file = null)
    {
        $this->imfile = $file;
    }
	
	/**
     * Get imfile.
     *
     * @return UploadedFile
     */
    public function getImfile()
    {
        return $this->imfile;
    }
	
	public function uploadImage()
	{
		if (null === $this->getImfile()) {
			return;
		}		
		$this->getImfile()->move(
			$this->getUploadRootDir(),
			$this->getImfile()->getClientOriginalName()
		);
		
		if ($this->impath!=$this->getImfile()->getClientOriginalName() && is_file($this->getAbsoluteImagePath()))
			unlink($this->getAbsoluteImagePath());
		$this->impath = $this->getImfile()->getClientOriginalName();		
		$this->imfile = null;
	}	
	
	public function getAbsoluteImagePath() {
        return null === $this->impath? null : $this->getUploadRootDir().'/'.$this->impath;
    }

    public function getWebImagePath() {
        return null === $this->impath? null : $this->getUploadDir().'/'.$this->impath;
    }

    protected function getUploadRootDir() {
        return $GLOBALS["kernel"]->getWebRoot().$this->getUploadDir();
    }

    protected function getUploadDir() {
        return '/files/images';
    }	

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
     *
     * @return Product
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
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
	 * Set image
	 *
	 * @param AppBundle\Entity\Image $image
	 * @return Product
	 */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Product
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set tags
     *
     * @param array $tags
     *
     * @return Product
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }
}

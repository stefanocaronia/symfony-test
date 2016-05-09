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
    private $imageFileName;

	/**
     * @Assert\File(maxSize="6000000")
     */
    private $imageFile;

	/**
     * Sets imageFile.
     *
     * @param UploadedFile $file
     */
    public function setImageFile(UploadedFile $file = null) {
        $this->imageFile = $file;
    }

	/**
     * Get imageFile.
     *
     * @return UploadedFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

	/**
     * Handle image upload
     *
     * @return bool
     */
	public function uploadImage()
	{
		if (null === $this->getImageFile()) {
			return false;
		}

		// sposto il file temporaneo nella cartella di upload
		$this->getImageFile()->move(
			$this->getUploadRootDir(),
			$this->getImageFile()->getClientOriginalName()
		);

		// se il nome dell'immagine è cambiato elimino la vecchia immagine
		if ($this->getImageFileName() !== $this->getImageFile()->getClientOriginalName() && is_file($this->getAbsoluteImagePath())) {
			unlink($this->getAbsoluteImagePath());
		}

		// aggiorno il nome del file per il database e svuoto l'oggetto file
		$this->setImageFileName($this->getImageFile()->getClientOriginalName());
		$this->setImageFile(null);

		return is_file($this->getAbsoluteImagePath());
	}

	/**
     * Get absolute image Path
     *
     * @return string | null
     */
	public function getAbsoluteImagePath()
	{
        return (null === $this->getImageFileName() ? null : $this->getUploadRootDir().'/'.$this->getImageFileName());
    }

	/**
     * Get web image Path
     *
     * @return string | null
     */
    public function getWebImagePath()
	{
        return (null === $this->getImageFileName() ? null : $this->getUploadDir().'/'.$this->getImageFileName());
    }

	/**
     * Get Upload root dir
     *
     * @return string
     */
    protected function getUploadRootDir()
	{
        return $GLOBALS["kernel"]->getWebRoot().$this->getUploadDir();
    }

	/**
     * Get upload dir for images (relative to web folder)
     *
     * @return string
     */
    protected function getUploadDir()
	{
        return '/files/images';
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)  {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
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
	 * Set imageFileName
	 *
	 * @return Product
	 */
    public function setImageFileName($image)
	{
        $this->imageFileName = $image;

        return $this;
    }

    /**
     * Get imageFileName
     *
     * @return AppBundle\Entity\Image
     */
    public function getImageFileName()
	{
        return $this->imageFileName;
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

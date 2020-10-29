<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as SR;

/**
 * @ORM\Entity()
 */
class Beer
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @SR\Groups({"show", "list"})
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @SR\Groups({"show", "list"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=555)
     * @SR\Groups({"show", "list"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @SR\Groups({"show"})
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="string", length=555)
     * @SR\Groups({"show"})
     *
     */
    private $tagline;

    /**
     * @ORM\Column(type="date")
     * @SR\Groups({"show"})
     */
    private $firstBrewed;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getTagline()
    {
        return $this->tagline;
    }

    /**
     * @param mixed $tagline
     */
    public function setTagline($tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * @return mixed
     */
    public function getFirstBrewed()
    {
        return $this->firstBrewed;
    }

    /**
     * @param mixed $firstBrewed
     */
    public function setFirstBrewed($firstBrewed): void
    {
        $this->firstBrewed = $firstBrewed;
    }

}
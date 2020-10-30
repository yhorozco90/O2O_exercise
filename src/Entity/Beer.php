<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as SR;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(schema="Beer")
 * @ORM\Entity(repositoryClass="App\Entity\Beer")
 */
class Beer
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @SR\Groups({"show", "list"})
     * @OA\Property(description="beer identifier",type="integer",readOnly=true)
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @SR\Groups({"show", "list"})
     * @OA\Property(description="beer name",type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=555)
     * @SR\Groups({"show", "list"})
     * @OA\Property(description="beer descrption",type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @SR\Groups({"show"})
     * @OA\Property(description="beer image",type="string")
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="string", length=555)
     * @SR\Groups({"show"})
     * @OA\Property(description="beer slogan",type="string")
     */
    private $tagline;

    /**
     * @ORM\Column(type="date")
     * @SR\Groups({"show"})
     * @ORM\Column(type="datetime")
     * @OA\Property(description="beer first brewed",type="string",format="date-time",pattern= "MM-YYYY")
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
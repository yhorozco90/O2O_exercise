<?php

namespace App\Tests\Entity;

use App\Entity\Beer;
use PHPUnit\Framework\TestCase;

class BeerTest extends TestCase
{
    public function testSetAndGetId()
    {
        $beer = new Beer();
        $beer->setId(192);
        $this->assertEquals($beer->getId(), 192);

    }

    public function testSetAndGetName()
    {
        $beer = new Beer();
        $beer->setName("Punk IPA 2007 - 2010");
        $this->assertEquals($beer->getName(), "Punk IPA 2007 - 2010");

    }

    public function testSetAndGetDescription()
    {
        $beer = new Beer();
        $beer->setDescription("Our flagship beer that kick started the craft beer revolution.");
        $this->assertEquals($beer->getDescription(), "Our flagship beer that kick started the craft beer revolution.");

    }


    public function testSetAndGetFirstBrewed()
    {
        $beer = new Beer();
        $beer->setFirstBrewed("04/2007");
        $this->assertEquals($beer->getFirstBrewed(), "04/2007");

    }

    public function testSetAndGetImageUrl()
    {
        $beer = new Beer();
        $beer->setImageUrl("https://images.punkapi.com/v2/192.png");
        $this->assertEquals($beer->getImageUrl(), "https://images.punkapi.com/v2/192.png");

    }

    public function testSetAndGetTagline()
    {
        $beer = new Beer();
        $beer->setTagline("Post Modern Classic. Spiky. Tropical. Hoppy.");
        $this->assertEquals($beer->getTagline(), "Post Modern Classic. Spiky. Tropical. Hoppy.");

    }

}

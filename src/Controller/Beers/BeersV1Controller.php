<?php

namespace App\Controller\Beers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class BeersV1Controller
 * @package App/Controller/Beers
 *
 * @Rest\Route(
 *     condition="request.attributes.get('version')=='1'"
 * )
 **/
class BeersV1Controller extends AbstractController
{
    /**
     * @Rest\Get(
     *     path="/beer/{id}"
     * )
     */
    public function index(): Response
    {
        return $this->json( [
            'controller_name' => 'BeersV1Controller',
        ]);
    }
}

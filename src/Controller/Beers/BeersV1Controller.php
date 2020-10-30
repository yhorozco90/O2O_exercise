<?php

namespace App\Controller\Beers;

use App\ThirdPartyServers\PunkApi\PunkApiClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints;


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
     *
     * Get a beer by id.
     * @Rest\Get(
     *     path="/beer/{id}"
     * )
     *
     * @OA\Tag(name="Beer"),
     * @OA\Response(
     *         response="200",
     *         description= "Return the beer data given its id",
     *         @Model(type=App\Entity\Beer::class, groups={"show"}),
     *
     *     )
     * @OA\Response(
     *     response=404,
     *     description= "Beer not found"
     * )
     * @OA\Response(
     *     response=400,
     *     description= "Bad request"
     * )
     * @OA\Parameter (
     *     name="id",
     *     in="path",
     *     @OA\Schema(type="integer"),
     *     description= "Identifier of the beer",
     *     required=true
     * )
     *
     * @param PunkApiClient $client
     * @param Request $request
     * @param LoggerInterface $logger
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function getBeer(
        PunkApiClient $client,
        Request $request,
        LoggerInterface $logger,
        ValidatorInterface $validator
    ): Response
    {
        $input = ['id' => $request->get("id")];
        $constraints = new Constraints\Collection([
            'id' => [new Constraints\NotBlank(), new Constraints\Type('numeric')]
        ]);
        $violations = $validator->validate($input, $constraints);
        if (count($violations) > 0) {
            return $this->json(null, Response::HTTP_BAD_REQUEST);
        }
        try {
            $data = $client->getBeerById(
                $request->get('id')
            );
            if (empty($data)) {
                return $this->json(null, Response::HTTP_NOT_FOUND);
            }
            return $this->json($data,
                Response::HTTP_OK, [],
                [ObjectNormalizer::GROUPS => ['show']]);
        } catch
        (GuzzleException $e) {
            if ($e instanceof RequestException && $e->getResponse()->getStatusCode() === 404) {
                return $this->json(null, Response::HTTP_NOT_FOUND);
            }
            $logger->error($e->getMessage());
            return $this->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}

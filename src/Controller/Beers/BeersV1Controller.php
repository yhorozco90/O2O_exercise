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
     * Get matches with the given food recepy.
     *
     * @Rest\Get(
     *     path="/beer/match"
     * )
     * @OA\Response(
     *     response=200,
     *     description= "Returns all matchings beers for the given food recepy",
     *     @OA\JsonContent(
     *         type="array",
     *      @OA\Items(
     *                @OA\Property(
     *                    property="id",
     *                    type="integer",
     *                    description="Beer identifier",
     *                    example="52"
     *                 ),
     *              @OA\Property(
     *                    property="nombre",
     *                    type="string",
     *                    description="Beer name",
     *                    example="India Session Lager - Prototype Challenge"
     *                 ),
     *
     *              @OA\Property(
     *                    property="description",
     *                    type="string",
     *                    description="Beer decription",
     *                    example="BrewDog’s level of dry-hop to a beer formed with a baseline of 100% pilsner malt – and at under 4.5%"
     *                 ),
     *             )
     *
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description= "Beer not found"
     * )
     * @OA\Response(
     *     response=400,
     *     description= "Bad request"
     * )
     * @OA\Parameter (
     *     name="food",
     *     in="query",
     *     @OA\Schema(type="string"),
     *     description= "Food recepy",
     *     required=true
     * )
     * @OA\Parameter (
     *     name="page",
     *     in="query",
     *     @OA\Schema(type="integer"),
     *     description= "Number of the page to show"
     * )
     * @OA\Parameter (
     *     name="per_page",
     *     in="query",
     *     @OA\Schema(type="integer"),
     *     description= "Number of items show by page"
     * )
     * @OA\Tag(name="Beer")
     *
     * @param PunkApiClient $client
     * @param Request $request
     * @param LoggerInterface $logger
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function getBeersFoodMatchs(
        PunkApiClient $client,
        Request $request,
        LoggerInterface $logger,
        ValidatorInterface $validator
    ): Response
    {
        $input = [
            'food' => $request->get('food'),
            'page' => $request->get('page', 1),
            'per_page' => $request->get('per_page', 20),
        ];
        $constraints = new Constraints\Collection([
            'food' => [new Constraints\NotBlank(), new  Constraints\Type('string')],
            'page' => [new  Constraints\Type('numeric')],
            'per_page' => [new  Constraints\Type('numeric')]
        ]);
        $violations = $validator->validate($input, $constraints);
        if (count($violations) > 0) {
            return $this->json(null, Response::HTTP_BAD_REQUEST);
        }
        try {
            $data = $client->listBeers($input);
            if (empty($data)) {
                return $this->json(null, Response::HTTP_NOT_FOUND);
            }
            return $this->json($data,
                Response::HTTP_OK, [],
                [ObjectNormalizer::GROUPS => ['list']]);

        } catch
        (GuzzleException $e) {
            if ($e instanceof RequestException && $e->getResponse()->getStatusCode() === 404) {
                return $this->json(null, Response::HTTP_NOT_FOUND);
            }
            $logger->error($e->getMessage());
            return $this->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

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

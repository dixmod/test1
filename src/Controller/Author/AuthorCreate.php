<?php

declare(strict_types=1);

namespace App\Controller\Author;

use App\Dto\Request\Author\AuthorCreateDto;
use App\Factory\FormFactory;
use App\Factory\Response\AuthorFactory;
use App\Form\Type\Author\AuthorCreateType;
use App\Service\Author\Creator;
use App\Dto\Response\Author\AuthorDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class AuthorCreate extends AbstractController
{
    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/author/create", name="author_create", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Создать автора",
     *     tags={"Author"},
     *     operationId="AuthorCreate",
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref=@Model(type=AuthorCreateDto::class))
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              ref=@Model(type=AuthorDto::class)
     *          )
     *    )
     * )
     */
    public function __invoke(Request $request, Creator $create): Response
    {
        /** @var AuthorCreateDto $requestDto */
        $requestDto = $this->formFactory->create(AuthorCreateType::class)
            ->submitRequest($request)
            ->validate()
            ->getData()
        ;

        $author = $create->create($requestDto);

        return $this->json(AuthorFactory::create($author)->jsonSerialize());
    }
}

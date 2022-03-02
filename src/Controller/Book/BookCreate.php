<?php

declare(strict_types=1);

namespace App\Controller\Book;

use App\Dto\Request\Book\BookCreateDto;
use App\Factory\FormFactory;
use App\Form\Type\Book\BookCreateType;
use App\Service\Book\Creator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Dto\Response\Book\BookDto;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class BookCreate extends AbstractController
{
    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/book/create", name="book_create", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Создать книгу",
     *     tags={"Book"},
     *     operationId="BookCreate",
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref=@Model(type=BookCreateDto::class))
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Returns the rewards of an user",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(ref=@Model(type=BookDto::class))
     *          )
     *      )
     * )
     */
    public function __invoke(Request $request, Creator $creator): Response
    {
        /** @var BookCreateDto $requestDto */
        $requestDto = $this->formFactory->create(BookCreateType::class)
            ->submitRequest($request)
            ->validate()
            ->getData();

        $book = $creator->create($requestDto);

        return $this->json($book);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Book;

use App\Dto\Request\Book\BookSearchDto;
use App\Factory\FormFactory;
use App\Form\Type\Book\BookSearchType;
use App\Service\Book\Finder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Dto\Response\Book\BookDto;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class BookSearch extends AbstractController
{
    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/book/search", name="book_search", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Поиск книги",
     *     tags={"Book"},
     *     operationId="BookSearch",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              ref=@Model(type=BookSearchDto::class)
     *          )
     *     ),
     *     @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\Schema(
     *         type="array",
     *         @OA\Items(ref=@Model(type=BookDto::class))
     *      )
     *    )
     * )
     */
    public function __invoke(
        Request $request,
        Finder $finder
    ): Response {
        /** @var BookSearchDto $requestDto */
        $requestDto = $this->formFactory->create(BookSearchType::class)
            ->submitRequest($request)
            ->validate()
            ->getData()
        ;

        $books = $finder->find($requestDto);

        return $this->json($books);
    }
}

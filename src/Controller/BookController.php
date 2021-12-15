<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\Book\BookCreateDto;
use App\Dto\Request\Book\BookSearchDto;
use App\Factory\FormFactory;
use App\Form\Type\Book\BookCreateType;
use App\Form\Type\Book\BookSearchType;
use App\Service\Book\Creator;
use App\Service\Book\Finder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/book/create", name="book_create", methods={"POST"})
     */
    public function createAction(Request $request, Creator $creator): Response
    {
        /** @var BookCreateDto $requestDto */
        $requestDto = $this->formFactory->create(BookCreateType::class)
            ->submitRequest($request)
            ->validate()
            ->getData()
        ;

        $book = $creator->create($requestDto);

        return $this->json($book);
    }

    /**
     * @Route("/book/search", name="book_search", methods={"POST"})
     */
    public function searchAction(
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

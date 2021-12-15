<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\Author\AuthorCreateDto;
use App\Factory\FormFactory;
use App\Factory\Response\AuthorFactory;
use App\Form\Type\Author\AuthorCreateType;
use App\Form\Type\Book\BookSearchType;
use App\Service\Author\Creator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/author/create", name="author_create", methods={"POST"})
     */
    public function createAction(Request $request, Creator $create): Response
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

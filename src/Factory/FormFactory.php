<?php

declare(strict_types=1);

namespace App\Factory;

use App\Form\AppForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class FormFactory
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @throws InvalidOptionsException
     */
    public function create(string $formType, $data = null, array $options = []): AppForm
    {
        return new AppForm($this->formFactory->create($formType, $data, $options));
    }
}

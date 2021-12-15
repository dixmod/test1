<?php

declare(strict_types=1);

namespace App\Form;

use App\Exception\Http\FormValidationException;
use Cassandra\Exception\ValidationException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use function array_merge;
use function array_unique;
use function array_values;

class AppForm
{
    /**
     * @var FormInterface<mixed>
     */
    protected $form;

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * @param FormInterface<mixed> $form
     * @param Request              $request
     */
    public function __construct(FormInterface $form, ?Request $request = null)
    {
        $this->form = $form;
        $this->request = $request;
    }

    /**
     * @return AppForm
     */
    public function submitRequest(Request $request): self
    {
        $this->form->handleRequest($request);

        return $this;
    }

    /**
     * @param array<string|array|null> $data
     *
     * @return AppForm
     */
    public function submitArray(array $data, bool $clearMissing = true): self
    {
        $this->form->submit($data, $clearMissing);

        return $this;
    }

    /**
     * @throws ValidationException
     *
     * @return AppForm
     */
    public function validate(): self
    {
        if (false === $this->form->isSubmitted() || false === $this->form->isValid()) {
            $this->throwFormValidationException();
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->form->getData();
    }

    /**
     * @throws ValidationException
     */
    protected function throwFormValidationException(): void
    {
        if (!$this->form->isSubmitted()) {
            throw new ValidationException('Form not submitted');
        }

        $errors = $this->form->getErrors(true);
        $fields = [];

        foreach ($errors as $error) {
            $fields[] = $this->getErrors($error);
        }

        $fieldsWithErrors = array_values(array_unique(array_merge(...$fields)));

        throw new ValidationException('Validation error');
    }

    /**
     * @param FormError|FormErrorIterator $error
     *
     * @return array<string>
     */
    private function getErrors($error): array
    {
        $ret = [];
        if ($error instanceof FormError) {
            $form = $error->getOrigin();
            if ($form instanceof FormInterface) {
                $ret[] = [
                    $form->getName(),
                ];
            }
        }

        if ($error instanceof FormErrorIterator) {
            foreach ($error as $item) {
                $ret[] = $this->getErrors($item);
            }
        }

        return array_merge(...$ret);
    }
}

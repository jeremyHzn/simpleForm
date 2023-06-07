<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final readonly class FormErrorService implements FormErrorInterface
{
    private SessionInterface $session;

    public function __construct(private RequestStack $requestStack)
    {
        $this->session = $this
            ->requestStack
            ->getSession();
    }

    public function getSubmittedDataFromSession(): ?array
    {
        return $this
                ->session
                ->remove(
                    name: 'submitted_data',
                );
    }

    public function saveSubmittedDataInSession(array $submittedData): void
    {
        $this
            ->session
            ->set(
                name: 'submitted_data',
                value: $submittedData
            );
    }

    public function addFormErrorsInSession(FormInterface $form): void
    {
        $formErrors = $form->getErrors(
            deep: true
        );

        if (count($formErrors) === 0) {
            return;
        }

        $formErrorsForSession = [];

        foreach ($formErrors as $formError) {
            /** @var FormError $formError */
            $formErrorsForSession[] = [
                'message' => $formError->getMessage(),
                'origin' => $formError
                    ->getOrigin()
                    ?->getName()
            ];
        }

        $this
            ->session
            ->set(
                name: 'form_errors',
                value: $formErrorsForSession
            );
    }

    public function addFormErrorsFromPreviousSubmittedDataIfExists(FormInterface $form): void
    {
        $formErrors = $this
            ->session
            ->remove(
                name: 'form_errors',
            );

        if (
            is_array($formErrors) === false
            ||
            count($formErrors) === 0
        ) {
            return;
        }

        foreach ($formErrors as $formError) {
            [
                'message' => $message,
                'origin' => $origin
            ] = $formError;

            $form
                ->get(
                    name: $origin
                )
                ->addError(
                    error: new FormError(
                        message: $message
                    )
                );
        }
    }
}

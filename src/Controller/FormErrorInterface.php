<?php

namespace App\Controller;

use Symfony\Component\Form\FormInterface;

interface FormErrorInterface
{
    public function saveSubmittedDataInSession(array $submittedData): void;

    public function addFormErrorsInSession(FormInterface $form): void;

    public function getSubmittedDataFromSession(): ?array;

    public function addFormErrorsFromPreviousSubmittedDataIfExists(FormInterface $form): void;

}
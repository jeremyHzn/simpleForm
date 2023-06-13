<?php

namespace App\Controller;

use Symfony\Component\Form\FormInterface;

/**
 * Interface FormErrorInterface
 * @package App\Controller
 */
interface FormErrorInterface
{
    /**
     * @param array $submittedData
     * @return void
     */
    public function saveSubmittedDataInSession(array $submittedData): void;

    /**
     * @param FormInterface $form
     * @return void
     */
    public function addFormErrorsInSession(FormInterface $form): void;

    /**
     * @return array|null
     */
    public function getSubmittedDataFromSession(): ?array;

    /**
     * @param FormInterface $form
     * @return void
     */
    public function addFormErrorsFromPreviousSubmittedDataIfExists(FormInterface $form): void;

}
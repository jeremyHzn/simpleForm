<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Questions;
use App\Form\SatisfactionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MainController extends AbstractController
{
    #[Route(path: '/', name: 'app_main', methods: ['GET'])]
    public function index(): Response
    {
        $question = new Questions();

        $questionForm = $this->createForm(
            type: SatisfactionFormType::class,
            data: $question,
            options:[
                'action' => $this->generateUrl('app_main'),
                'method' => 'POST',
            ]
        );

        return $this->render(
            view: 'main/index.html.twig',
            parameters: [
                'questionForm' => $questionForm->createView(),
            ]
        );
    }
}

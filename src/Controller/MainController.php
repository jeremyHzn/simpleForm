<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\SatisfactionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, EntityManagerInterface $me): Response
    {
        $question = new Questions();

        $questionForm = $this->createForm(SatisfactionFormType::class, $question);

        $questionForm->handleRequest($request);



        return $this->render('main/index.html.twig', [
            'questionForm' => $questionForm->createView(),
        ]);

    }
}

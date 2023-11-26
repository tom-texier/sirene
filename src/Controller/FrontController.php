<?php

namespace App\Controller;

use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="app_front_home")
     */
    public function index(): Response
    {
        $searchForm = $this->createForm(SearchType::class);

        return $this->render('front/home.html.twig', [
            'searchForm' => $searchForm->createView(),
        ]);
    }
}

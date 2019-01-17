<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Bry\TestController;

class HomeController extends AbstractController {


    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response {

        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route("/infos", name="infos")
     * @return Response
     */
    public function infos(): Response {
        return $this->render('pages/infos.html.twig');
    }



}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    #[Route('/aperitivo', name: 'redirect_aperitivo')]
    public function index(): Response
    {
        return $this->redirectToRoute('locale', ['slug' => 'frascolino']);

    }
}

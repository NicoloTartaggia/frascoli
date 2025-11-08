<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax/home-imgs", name="home_img")
     */
     public function login(): Response {


         $webPath = '/assets/static/home/';
         $directory = $this->getParameter('kernel.project_dir') . '/public' . $webPath;


         $images = glob($directory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);


         if ($images) {
             $randomImage = $images[array_rand($images)];
             return new Response($webPath . basename($randomImage));
         } else {
             return new Response($webPath . 'no-img.png');
         }

     }


  }
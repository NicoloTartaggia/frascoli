<?php

namespace App\Controller;

use App\Entity\Luogo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em,Request $request): Response
    {

        $locali = $em->getRepository(Luogo::class)->findAll();
        return $this->render('app/index.html.twig', [
            'locali'  => $locali
        ]);
    }


    /**
     * @Route("/viaggio", name="viaggio")
     */
    public function viaggio(EntityManagerInterface $em,Request $request): Response
    {

        return $this->render('app/viaggio.html.twig', [

        ]);
    }


    /**
     * @Route("/cucina", name="cucina")
     */
    public function cucina(EntityManagerInterface $em,Request $request): Response
    {

        return $this->render('app/cucina.html.twig', [

        ]);
    }

    /**
     * @Route("/prenota", name="prenota")
     */
    public function prenota(EntityManagerInterface $em,Request $request): Response
    {

        $locali = $em->getRepository(Luogo::class)->findAll();

        $form = $this->createFormBuilder()
            ->add('luogo', EntityType::class, [
                'class' => Luogo::class,
                'choice_label' => 'nomeCover',
                'label' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-main'
                ],
                'label' => 'Prenota ora',
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $localeData = $form->getData();

            $locale = $localeData['luogo'];

            return $this->redirect('https://call.suerte.studio/?utm=frascoli&tel=' . $locale->getTelefono());
        }

        return $this->render('app/prenota.html.twig', [
            'locali'  => $locali,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/prenota/{slug}", name="prenota_singolo")
     */
    public function prenotaSingolo(EntityManagerInterface $em,Request $request, $slug): Response
    {

        $locale = $em->getRepository(Luogo::class)->findOneBy(['slug' => $slug]);

        if (!$locale) {
            throw $this->createNotFoundException('Questo locale non esiste, ancora.');
        }

        return $this->redirect('https://call.suerte.studio/?utm=frascoli&tel=' . $locale->getTelefono());
    }

    /**
     * @Route("/menu/{slug}", name="memu_singolo")
     */
    public function menuSingolo(EntityManagerInterface $em,Request $request, $slug): Response
    {

        $locale = $em->getRepository(Luogo::class)->findOneBy(['slug' => $slug]);

        if (!$locale) {
            throw $this->createNotFoundException('Questo locale non esiste, ancora.');
        }

        $fileName = $locale->getMenu();

        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/menu/' . $fileName;

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Il file del menu non è stato trovato.');
        }

        return new BinaryFileResponse($filePath);
    }


    /**
     * @Route("/locali/{slug}", name="locale")
     */
    public function locale(EntityManagerInterface $em,Request $request, $slug): Response
    {

        $locale = $em->getRepository(Luogo::class)->findOneBy(['slug' => $slug]);

        if (!$locale) {
            throw $this->createNotFoundException('Questo locale non esiste, ancora.');
        }

        if (!$locale->isAttivo()) {
            return $this->render('app/locali/locale-disattivato.html.twig', [
                'locale' => $locale
            ]);
        }

        $template = "app/locali/" . $locale->getSlug() . ".html.twig";
        return $this->render($template, [
            'locale' => $locale
        ]);
    }

    /**
     * @Route("/organizza-evento", name="organizza_evento")
     */
    public function organizzaEvento(EntityManagerInterface $em,Request $request): Response
    {

        return $this->render('app/organizza-evento.html.twig', [

        ]);
    }

    /**
     * @Route("/contatti", name="contatti")
     */
    public function contatti(EntityManagerInterface $em,Request $request): Response
    {

        return $this->render('app/contatti.html.twig', [

        ]);
    }


    /**
     * @Route("/credits", name="credits")
     */
    public function credits(EntityManagerInterface $em,Request $request): Response
    {

        return $this->render('app/cucina.html.twig', [

        ]);
    }
}

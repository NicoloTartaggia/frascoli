<?php

namespace App\Controller\Admin;

use App\Entity\Luogo;
use App\Entity\User;
use App\Entity\EventRequest;
use App\Helpers\GitUtils;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;



class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(LuogoCrudController::class)->generateUrl());

    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)

            ->setName($user->getNome())

            // you can return an URL with the avatar image
            ->setAvatarUrl("uploads/profili/" . $user->getImgProfilo())
            // use this method if you don't want to display the user image
            ;

    }

    public function configureDashboard(): Dashboard
    {
        $git = new GitUtils();
        $v = $git->getLastCommit();
        $appV = $git->getAppV();

        return Dashboard::new()
            ->setTitle("Frascoli<br><span style=\"color: #8E8E8E;font-size: 12px; text-transform: uppercase\">
                $appV - $v
            </span>")
            ->setFaviconPath('assets/static/favicon.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Luoghi', 'fas fa-map-marker-alt', Luogo::class);

        yield MenuItem::linkToCrud('Utenti', 'fas fa-users', User::class);

        yield MenuItem::linkToCrud('Richieste di eventi', 'fas fa-calendar-alt', EventRequest::class);
    }




}

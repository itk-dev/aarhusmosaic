<?php

namespace App\Controller\Admin;

use App\Entity\ApiUser;
use App\Entity\Screen;
use App\Entity\Tile;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $dashboard = $this->adminUrlGenerator
            ->setController(TileCrudController::class)->setAction(Crud::PAGE_INDEX)
            ->generateUrl();

        return $this->redirect($dashboard);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Aarhus Mosaic');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Tiles', 'fas fa-image', Tile::class);
        yield MenuItem::linkToCrud('Screens', 'fas fa-display', Screen::class);
        yield MenuItem::linkToCrud('API Users', 'fas fa-user-pen', ApiUser::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
    }
}

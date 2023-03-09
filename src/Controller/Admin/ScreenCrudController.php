<?php

namespace App\Controller\Admin;

use App\Entity\Screen;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ScreenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Screen::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

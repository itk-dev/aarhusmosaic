<?php

namespace App\Controller\Admin;

use App\Entity\ApiUser;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ApiUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ApiUser::class;
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

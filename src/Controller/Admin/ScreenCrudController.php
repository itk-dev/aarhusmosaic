<?php

namespace App\Controller\Admin;

use App\Entity\Screen;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ScreenCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UrlGeneratorInterface $router
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Screen::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            IntegerField::new('gridColumns'),
            IntegerField::new('gridRows'),
            TextField::new('screenUrl')
                ->setLabel('Url')
                ->setDisabled(true)
                // This only applies to index and detail pages.
                ->formatValue(function ($value) {
                    return $this->router->generate('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL).$value;
                }),
            AssociationField::new('apiUser')->hideOnIndex()->setRequired(true),
            AssociationField::new('tags')->hideOnIndex()->setRequired(true),
            CodeEditorField::new('variant')->hideOnIndex(),
            DateField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateField::new('updatedAt')->hideOnForm(),
        ];
    }
}

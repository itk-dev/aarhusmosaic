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
            TextField::new('title')
                ->setHelp('The title is only used in this administrative user interface. So use something that makes it easy to identify later on.'),
            IntegerField::new('gridColumns')
                ->setHelp('Number of columns to use on the screen.'),
            IntegerField::new('gridRows')
                ->setHelp('Number of rows to use on the screen.'),
            TextField::new('screenUrl')
                ->setLabel('Url')
                ->setDisabled(true)
                // This only applies to index and detail pages.
                ->formatValue(function ($value) {
                    return $this->router->generate('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL).$value;
                })
                ->setHelp('Not editable. Will be generated base one the screen ID and API user selected.'),
            AssociationField::new('apiUser')->hideOnIndex()->setRequired(true)
                ->setHelp('The API user that should be used to access this screen.'),
            AssociationField::new('tags')->hideOnIndex()->setRequired(true)
                ->setHelp('Filter screen content based on these tags. If more than one tag is selected, all tags are required on a tile to display it on the screen.'),
            CodeEditorField::new('variant')->hideOnIndex()
                ->setHelp('Paste this text and correct as desired: {"showIcons":false,"showBorders":false,"gridExpose":2,"exposeShowBorder":true,"exposeShowIcon":true,"mosaicLogo":true,"exposeTimeout":4} '),
            DateField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateField::new('updatedAt')->hideOnForm(),
        ];
    }
}

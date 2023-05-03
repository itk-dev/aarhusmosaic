<?php

namespace App\Controller\Admin;

use App\Entity\Tile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tile::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('description')
                ->setHelp('The description is show on the tile in the mosaic.'),
            ImageField::new('image')->setUploadDir('/public/tiles'),
            AssociationField::new('tags')->hideOnIndex()->setRequired(true)
                ->setHelp('Tags are used to decide on which screens this tile should be displayed.'),
            EmailField::new('mail')
                ->setHelp('Mail address is required for user uploaded images in the case of "aktindsigt" requests.'),
            BooleanField::new('accepted')
                ->setHelp('Tile is only display on screens if they have been accepted.'),
            CodeEditorField::new('extra')->hideOnIndex()
                ->setHelp('All extra fields from "selvbetjening" from is encoded as json in this field.'),
            DateField::new('createdAt')->hideOnForm(),
            DateField::new('updatedAt')->hideOnForm(),
        ];
    }
}

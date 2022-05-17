<?php

namespace App\Controller\Admin;

use App\Entity\Events;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class EventsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Events::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            // idField::new('id'),
            AssociationField::new('user'),
            AssociationField::new('category'),
            TextField::new('nom'),
            TextField::new('description'),
            ImageField::new('image')
                ->setBasePath('images/events')
                ->setUploadDir('public/images/events')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            DateTimeField::new('updated_at'),

        ];
    }
}

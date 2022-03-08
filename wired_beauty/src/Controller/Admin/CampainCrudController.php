<?php

namespace App\Controller\Admin;

use App\Entity\Campain;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CampainCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Campain::class;
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

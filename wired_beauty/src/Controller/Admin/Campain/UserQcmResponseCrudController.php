<?php

namespace App\Controller\Admin\Campain;

use App\Entity\UserQcmResponse;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserQcmResponseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserQcmResponse::class;
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

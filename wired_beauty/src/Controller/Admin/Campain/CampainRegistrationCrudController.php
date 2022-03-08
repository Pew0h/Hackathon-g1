<?php

namespace App\Controller\Admin\Campain;

use App\Entity\CampainRegistration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class CampainRegistrationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CampainRegistration::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new("tester", "User"),
            AssociationField::new("campain", "Campain"),
            BooleanField::new("status", "Regsitration status")
        ];
    }
}

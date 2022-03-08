<?php

namespace App\Controller\Admin\Campain;

use App\Entity\Qcm;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QcmCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Qcm::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new("campain"),
            AssociationField::new("questions")
        ];
    }
}

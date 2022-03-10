<?php

namespace App\Controller\Admin\Campain;

use App\Controller\Admin\AbstractBaseCrudController;
use App\Entity\Qcm;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QcmCrudController extends AbstractBaseCrudController
{
    public function __construct()
    {
        parent::__construct("Qcm", "Survey Forms", "Add new survey form");
    }

    public static function getEntityFqcn(): string
    {
        return Qcm::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->addCssClass('js-row-edit-action'),
            AssociationField::new("campain"),
            AssociationField::new("questions")
        ];
    }
}

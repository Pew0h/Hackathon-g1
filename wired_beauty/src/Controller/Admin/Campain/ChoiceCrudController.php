<?php

namespace App\Controller\Admin\Campain;

use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChoiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Choice::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('value')->addCssClass('js-row-edit-action'),
            AssociationField::new("question")
        ];
    }
}

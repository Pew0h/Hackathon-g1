<?php

namespace App\Controller\Admin;

use App\Entity\Campain;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CampainCrudController extends AbstractBaseCrudController
{

    public function __construct() {
        parent::__construct("Campain");
    }

    public static function getEntityFqcn(): string
    {
        return Campain::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->addCssClass('js-row-edit-action'),
            TextEditorField::new("description"),
            AssociationField::new("company"),
            AssociationField::new("product"),
            DateField::new("startDate"),
            DateField::new("endDate"),
        ];
    }
}

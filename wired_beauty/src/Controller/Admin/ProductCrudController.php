<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AbstractBaseCrudController;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractBaseCrudController
{

    public function __construct()
    {
        parent::__construct("Product");
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel("Title")->addCssClass('js-row-edit-action'),
            TextEditorField::new('description'),
            ImageField::new("image")->setBasePath("uploads")->setUploadDir("public/uploads"),
            TextField::new("uv_protection")->setLabel("Protection UV")->hideOnIndex(),
            AssociationField::new("company", "Company")->setRequired(true),
            AssociationField::new("campain", "Campain")->setRequired(false),
        ];
    }
}

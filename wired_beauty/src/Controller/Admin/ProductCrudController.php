<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AbstractBaseCrudController;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Component\Routing\Annotation\Route;

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

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('campain'))
            ->add(EntityFilter::new('company'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel("Title")->addCssClass('js-row-edit-action'),
            TextEditorField::new('description'),
            ImageField::new("image")->setBasePath("uploads")->setUploadDir("public/uploads"),
            NumberField::new("uv_protection")->setLabel("Protection UV")->hideOnIndex(),
            AssociationField::new("company", "Company")->setRequired(true),
            AssociationField::new("campain", "Campain")->setRequired(false),
        ];
    }
}

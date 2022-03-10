<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CompanyCrudController extends AbstractBaseCrudController
{

    public function __construct() {
        parent::__construct("Company", "Companies");
    }

    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new("name")->setLabel("Title")->addCssClass('js-row-edit-action'),
            TextEditorField::new("description"),
            ImageField::new("image")->setBasePath('uploads')->setUploadDir('public/uploads'),
            AssociationField::new("products")->setFormTypeOptions(['by_reference' => false,]),
            AssociationField::new("campains")->setFormTypeOptions(['by_reference' => false,]),
        ];
    }
}

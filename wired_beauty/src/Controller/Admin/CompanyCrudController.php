<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $company = new Company();
        return $company;
    }

    public function configureCrud(Crud $crud): Crud {
        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new("name")->setLabel("Title"),
            TextEditorField::new("description"),
            ImageField::new("image")->setBasePath('uploads')->setUploadDir('public/uploads'),
            CollectionField::new("campains")
        ];
    }
}

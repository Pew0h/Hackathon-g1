<?php

namespace App\Controller\Admin\Campain;

use App\Controller\Admin\AbstractBaseCrudController;
use App\Entity\UserQcmResponse;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class UserQcmResponseCrudController extends AbstractBaseCrudController
{

    public function __construct()
    {
        parent::__construct("UserQcmResponse", "Survey Answers", "Add new survey answer");
    }

    public static function getEntityFqcn(): string
    {
        return UserQcmResponse::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('content'),
            AssociationField::new('campainRegistration'),
        ];
    }
}

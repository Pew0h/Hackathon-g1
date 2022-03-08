<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('fullname')->onlyOnIndex()->addCssClass('js-row-edit-action'),
            TextField::new("firstname")->onlyOnForms(),
            TextField::new("lastname")->onlyOnForms(),
            TextField::new("email")->setSortable(true),
            ChoiceField::new('roles')
            ->setRequired(true)
            ->allowMultipleChoices()
            ->setChoices([
                'Admin'           => User::ROLE_ADMIN,
                'Tester'       => User::ROLE_USER
            ]),
            NumberField::new("age")->onlyOnForms(),
            NumberField::new("height")->onlyOnForms(),
            NumberField::new("weight")->onlyOnForms(),
            AssociationField::new("campainRegistrations")->onlyOnForms()->setDisabled()
        ];
    }
}

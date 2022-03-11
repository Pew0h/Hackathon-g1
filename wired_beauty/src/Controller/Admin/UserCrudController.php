<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Func;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractBaseCrudController
{
    public $hasherPassword;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct("User");
        $this->hasherPassword = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ArrayFilter::new('roles')->setChoices([
                "Admin" => "ROLE_ADMIN",
                "Tester" => "ROLE_USER",
            ]));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('fullname')->onlyOnIndex()->addCssClass('js-row-edit-action'),
            TextField::new("firstname")->onlyOnForms(),
            TextField::new("lastname")->onlyOnForms(),
            TextField::new("email")->setSortable(true),
            TextField::new('password')->setFormType(PasswordType::class)->hideWhenUpdating()->hideOnIndex()->hideOnDetail(),
            ChoiceField::new('roles')
                ->setRequired(true)
                ->allowMultipleChoices()
                ->setChoices([
                    'Admin'           => User::ROLE_ADMIN,
                    'Tester'       => User::ROLE_USER
                ]),
            NumberField::new("age"),
            NumberField::new("height")->onlyOnForms(),
            NumberField::new("weight")->onlyOnForms(),
            NumberField::new("latitude")->onlyOnForms(),
            NumberField::new("longitude")->onlyOnForms(),
            AssociationField::new("campainRegistrations")->onlyOnForms()->setDisabled()
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setPassword(
            $this->hasherPassword->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            )
        );

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setPassword(
            $this->hasherPassword->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            )
        );

        parent::persistEntity($entityManager, $entityInstance);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public $hasherPassword;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->hasherPassword = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
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
            
        dd($entityInstance, $entityManager);
        parent::persistEntity($entityManager, $entityInstance);
    }

    private function encodePassword($user, $password)
    {
        return $this->hasherPassword->hash;
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
            NumberField::new("age")->onlyOnForms(),
            NumberField::new("height")->onlyOnForms(),
            NumberField::new("weight")->onlyOnForms(),
            NumberField::new("latitude")->onlyOnForms(),
            NumberField::new("longitude")->onlyOnForms(),
            AssociationField::new("campainRegistrations")->onlyOnForms()->setDisabled()
        ];
    }
}

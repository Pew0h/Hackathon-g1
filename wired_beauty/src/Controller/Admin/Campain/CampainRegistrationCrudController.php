<?php

namespace App\Controller\Admin\Campain;

use App\Controller\Admin\AbstractBaseCrudController;
use App\Entity\CampainRegistration;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class CampainRegistrationCrudController extends AbstractBaseCrudController
{

    public function __construct()
    {
        parent::__construct("Campain Registration", "Campain registrations", "Add new campain registration");
    }

    public static function getEntityFqcn(): string
    {
        return CampainRegistration::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new("tester", "User")->addCssClass('js-row-edit-action'),
            AssociationField::new("campain", "Campain"),
            AssociationField::new("userQcmResponse", "User Survey Response"),
            ChoiceField::new("status")->setChoices([
                "Pending" => CampainRegistration::STATUS_PENDING,
                "Accepted" => CampainRegistration::STATUS_ACCEPTED,
                "Refused" => CampainRegistration::STATUS_REFUSED,
            ])->hideWhenCreating(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->getStatus() === null) {
            $entityInstance->setStatus(0);
        }
        parent::persistEntity($entityManager, $entityInstance);
    }
}

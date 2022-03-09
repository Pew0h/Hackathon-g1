<?php

namespace App\Controller\Admin\Campain;

use App\Controller\Admin\AbstractBaseCrudController;
use App\Entity\CampainRegistration;
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
        parent::__construct("CampainRegistration", "Campain registrations", "Add new campain registration");
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
            ChoiceField::new("status", "Registration status")->allowMultipleChoices(false)->renderExpanded()->setChoices([
                "Accepted" => CampainRegistration::STATUS_ACCEPTED,
                "Pending" => CampainRegistration::STATUS_PENDING,
                "Refused" => CampainRegistration::STATUS_ACCEPTED,
            ])->setFormattedValue(CampainRegistration::STATUS_PENDING),
        ];
    }
}

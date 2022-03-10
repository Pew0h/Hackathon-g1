<?php

namespace App\Controller\Admin\Campain;

use App\Controller\Admin\AbstractBaseCrudController;
use App\Entity\CampainRegistration;
use App\Repository\CampainRegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CampainRegistrationCrudController extends AbstractBaseCrudController
{

    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct("Campain Registration", "Campain registrations", "Add new campain registration");

        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return CampainRegistration::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('status')->setChoices([
                "Pending" => CampainRegistration::STATUS_PENDING,
                "Accepted" => CampainRegistration::STATUS_ACCEPTED,
                "Completed" => CampainRegistration::STATUS_COMPLETED,
                "Refused" => CampainRegistration::STATUS_REFUSED,
            ]));
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

    public function configureActions(Actions $actions): Actions
    {
        $setPendingStatus = Action::new('setPendingStatus', 'Set pending status')
            ->linkToCrudAction('setPendingStatus')
            ->createAsGlobalAction()
            ->addCssClass('btn');
        $setAcceptedStatus = Action::new('setAcceptedStatus', 'Set accepted status')
            ->linkToCrudAction('setAcceptedStatus')
            ->createAsGlobalAction()
            ->addCssClass('btn');
        $setConfirmedStatus = Action::new('setConfirmedStatus', 'Set confirmed status')
            ->linkToCrudAction('setConfirmedStatus')
            ->createAsGlobalAction()
            ->addCssClass('btn');
        $setRejectedStatus = Action::new('setRejectedStatus', 'Set rejected status')
            ->linkToCrudAction('setRejectedStatus')
            ->createAsGlobalAction()
            ->addCssClass('btn');

        return $actions
            ->addBatchAction($setPendingStatus)
            ->addBatchAction($setAcceptedStatus)
            ->addBatchAction($setRejectedStatus)
            ->addBatchAction($setConfirmedStatus);
    }

    public function setPendingStatus(BatchActionDto $batchActionDto): RedirectResponse
    {
        $this->setStatus($batchActionDto, 0);
        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function setAcceptedStatus(BatchActionDto $batchActionDto): RedirectResponse
    {
        $this->setStatus($batchActionDto, 1);
        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function setConfirmedStatus(BatchActionDto $batchActionDto): RedirectResponse
    {
        $this->setStatus($batchActionDto, 2);
        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function setRejectedStatus(BatchActionDto $batchActionDto): RedirectResponse
    {
        $this->setStatus($batchActionDto, 3);
        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function setStatus(BatchActionDto $batchActionDto, $status)
    {
        foreach ($batchActionDto->getEntityIds() as $entity_id) {
            $campainRegistration = $this->em->getRepository(CampainRegistration::class)->find($entity_id);
            $campainRegistration->setStatus($status);
            $this->em->persist($campainRegistration);
        }
        $this->em->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->getStatus() === null) {
            $entityInstance->setStatus(0);
        }
        parent::persistEntity($entityManager, $entityInstance);
    }
}

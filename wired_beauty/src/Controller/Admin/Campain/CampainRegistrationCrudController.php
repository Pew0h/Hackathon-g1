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
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use Symfony\Component\Form\FormBuilderInterface;
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
                "Completed" => CampainRegistration::STATUS_COMPLETED,
                "Refused" => CampainRegistration::STATUS_REFUSED,
            ])->hideWhenCreating(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $setPendingStatus = Action::new('setPendingStatus', 'Set status to "Pending"')
            ->linkToCrudAction('setPendingStatus')
            ->createAsGlobalAction()
            ->addCssClass('btn');
        $setPendingStatusSingle = Action::new('setPendingStatusSingle', 'Set status to "Pending"')
            ->linkToCrudAction('setPendingStatusSingle');

        $setAcceptedStatus = Action::new('setAcceptedStatus', 'Set status to "Accepted"')
            ->linkToCrudAction('setAcceptedStatus')
            ->createAsGlobalAction()
            ->addCssClass('btn');
        $setAcceptedStatusSingle = Action::new('setAcceptedStatusSingle', 'Set status to "Accepted"')
            ->linkToCrudAction('setAcceptedStatusSingle');

        $setConfirmedStatus = Action::new('setConfirmedStatus', 'Set status to "Confirmed"')
            ->linkToCrudAction('setConfirmedStatus')
            ->createAsGlobalAction()
            ->addCssClass('btn');
        $setConfirmedStatusSingle = Action::new('setConfirmedStatusSingle', 'Set status to "Confirmed"')
            ->linkToCrudAction('setConfirmedStatusSingle');

        $setRejectedStatus = Action::new('setRejectedStatus', 'Set status to "Rejected"')
            ->linkToCrudAction('setRejectedStatus')
            ->createAsGlobalAction()
            ->addCssClass('btn');
        $setRejectedStatusSingle = Action::new('setRejectedStatusSingle', 'Set status to "Rejected"')
            ->linkToCrudAction('setRejectedStatusSingle');



        return $actions
            ->add(Crud::PAGE_INDEX, $setRejectedStatusSingle)
            ->add(Crud::PAGE_INDEX, $setConfirmedStatusSingle)
            ->add(Crud::PAGE_INDEX, $setAcceptedStatusSingle)
            ->add(Crud::PAGE_INDEX, $setPendingStatusSingle)
            ->addBatchAction($setRejectedStatus)
            ->addBatchAction($setConfirmedStatus)
            ->addBatchAction($setAcceptedStatus)
            ->addBatchAction($setPendingStatus);
    }

    public function setPendingStatus(BatchActionDto $batchActionDto): RedirectResponse
    {
        $this->setStatus($batchActionDto, CampainRegistration::STATUS_PENDING);
        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function setPendingStatusSingle(AdminContext $context)
    {
        $campain = $context->getEntity()->getInstance()->setStatus(CampainRegistration::STATUS_PENDING);
        $this->em->persist($campain);
        $this->em->flush();
        return $this->redirect($context->getReferrer());
    }

    public function setAcceptedStatus(BatchActionDto $batchActionDto): RedirectResponse
    {
        $this->setStatus($batchActionDto, CampainRegistration::STATUS_ACCEPTED);
        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function setAcceptedStatusSingle(AdminContext $context)
    {
        $campain = $context->getEntity()->getInstance()->setStatus(CampainRegistration::STATUS_ACCEPTED);
        $this->em->persist($campain);
        $this->em->flush();
        return $this->redirect($context->getReferrer());
    }

    public function setConfirmedStatus(BatchActionDto $batchActionDto): RedirectResponse
    {
        $this->setStatus($batchActionDto, CampainRegistration::STATUS_COMPLETED);
        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function setConfirmedStatusSingle(AdminContext $context)
    {
        $campain = $context->getEntity()->getInstance()->setStatus(CampainRegistration::STATUS_COMPLETED);
        $this->em->persist($campain);
        $this->em->flush();
        return $this->redirect($context->getReferrer());
    }

    public function setRejectedStatus(BatchActionDto $batchActionDto): RedirectResponse
    {
        $this->setStatus($batchActionDto, CampainRegistration::STATUS_REFUSED);
        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function setRejectedStatusSingle(AdminContext $context)
    {
        $campain = $context->getEntity()->getInstance()->setStatus(CampainRegistration::STATUS_REFUSED);
        $this->em->persist($campain);
        $this->em->flush();
        return $this->redirect($context->getReferrer());
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

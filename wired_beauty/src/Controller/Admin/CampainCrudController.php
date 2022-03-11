<?php

namespace App\Controller\Admin;

use App\Controller\ExcelController;
use App\Entity\Campain;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;

class CampainCrudController extends AbstractBaseCrudController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct("Campain");
    }

    public static function getEntityFqcn(): string
    {
        return Campain::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new("product"))
            ->add(EntityFilter::new("company"));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->addCssClass('js-row-edit-action'),
            TextEditorField::new("description"),
            AssociationField::new("qcm")->hideOnIndex()->hideWhenCreating(),
            ImageField::new("qcm_file")->setUploadDir("/public/Excels")->setBasePath("Excels")->hideWhenUpdating()->hideOnIndex(),
            AssociationField::new("company")->addCssClass("company-dep"),
            AssociationField::new("product")->addCssClass("need-company"),
            DateField::new("startDate"),
            DateField::new("endDate"),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);

        if ($entityInstance->getQcmFile()) {
            $file_path = $entityInstance->getQcmFile();
            $excelController = new ExcelController($this->em);
            $qcm_name = $entityInstance->getName() . " | " . explode(".", $entityInstance->getQcmFile())[0];
            $qcm = $excelController->parseExcelToJson($file_path, $entityInstance, $qcm_name);
            $entityInstance->setQcm($qcm);
        }
    }
}

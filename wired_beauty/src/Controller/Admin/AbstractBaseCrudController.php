<?php

namespace App\Controller\Admin;

use Doctrine\Persistence\ObjectManager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Core\Security;

class AbstractBaseCrudController extends AbstractCrudController
{

    private $className;
    private $pageTitle;
    private $addLabel;

    public function __construct($className = "", $pageTitle = "", $addLabel = "")
    {
        if ($className != "") {
            $this->className = $className;
            $pageTitle === "" ? $this->pageTitle = $this->className . "s" : $this->pageTitle = $pageTitle;
            $addLabel === "" ? $this->addLabel = "Add new " . $this->className : $this->addLabel = $addLabel;
        }
    }

    public static function getEntityFqcn(): string
    {
        return "";
    }

    public function configureCrud(Crud $crud): Crud
    {
        if ($this->pageTitle != "") {
            return $crud
                ->setPageTitle("index", $this->pageTitle);
        } else {
            return $crud;
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->addLabel != "") {
            return $actions
                ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                    return $action->setLabel($this->addLabel);
                });
        } else {
            return $actions;
        }
    }
}

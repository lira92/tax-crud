<?php

namespace Tax\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tax\Model\Operator;

class TaxController extends AbstractActionController
{
    /**
    * Entity manager.
    * @var Doctrine\ORM\EntityManager
    */
    private $entityManager;

    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $operators = $this->entityManager->getRepository(Operator::class)->findAll();

        // Render the view template
        return new ViewModel([
            'operators' => $operators
        ]);
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}
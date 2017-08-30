<?php

namespace Tax\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tax\Model\TaxTable;
use Tax\Model\Operator;
use Tax\Form\TaxForm;

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
        $operators = $this->entityManager->getRepository(TaxTable::class)->findAll();

        // Render the view template
        return new ViewModel([
            'operators' => $operators
        ]);
    }

    public function addAction()
    {
        $form = new TaxForm($this->entityManager);
        //$form->setObjectManager($this->entityManager);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $taxTable = new TaxTable();
        $form->setInputFilter($taxTable->getInputFilter());
        $form->setData($request->getPost());;

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $operator_id = $form->getData()['operator_id'];
        $operator = $this->entityManager->getRepository(Operator::class)->findOneBy(['id' => $operator_id]);

        $taxTable->setDescription($form->getData()['description']);
        $taxTable->setEffectiveDate(\DateTime::createFromFormat('Y-m-d', $form->getData()['effective_date']));
        $taxTable->setOperator($operator);
        $this->entityManager->persist($taxTable);
        $this->entityManager->flush();
        return $this->redirect()->toRoute('tax');
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}
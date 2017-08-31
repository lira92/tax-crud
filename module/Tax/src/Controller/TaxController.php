<?php

namespace Tax\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tax\Model\TaxTable;
use Tax\Model\Tax;
use Tax\Model\Operator;
use Tax\Form\TaxTableForm;

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
        $taxTables = $this->entityManager->getRepository(TaxTable::class)->findAll();

        // Render the view template
        return new ViewModel([
            'taxTables' => $taxTables
        ]);
    }

    public function addAction()
    {
        $form = new TaxTableForm($this->entityManager);
        //$form->setObjectManager($this->entityManager);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $taxTable = new TaxTable();
        $form->setInputFilter($taxTable->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $operator_id = $form->getData()['operator_id'];
        $operator = $this->entityManager->getRepository(Operator::class)->findOneBy(['id' => $operator_id]);

        $taxTable->setDescription($form->getData()['description']);
        $taxTable->setEffectiveDate(\DateTime::createFromFormat('Y-m-d', $form->getData()['effective_date']));
        $taxTable->setOperator($operator);

        foreach($form->getData()['taxes'] as $taxData) {
            $tax = new Tax();
            $tax->setValue($taxData['value']);
            $tax->setFromValue($taxData['fromValue']);
            $tax->setUntilValue($taxData['untilValue']);

            $taxTable->addTax($tax);
        }

        $this->entityManager->persist($taxTable);
        $this->entityManager->flush();
        return $this->redirect()->toRoute('tax');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('tax', ['action' => 'add']);
        }

        try {
            $taxTable = $this->entityManager->getRepository(TaxTable::class)->findOneBy(['id' => $id]);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('tax', ['action' => 'index']);
        }

        $form = new TaxTableForm($this->entityManager);
        $form->bind($taxTable);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($taxTable->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $taxTable->setEffectiveDate(\DateTime::createFromFormat('Y-m-d', $form->getData()->getEffectiveDate()));

        $this->entityManager->persist($taxTable);
        $this->entityManager->flush();

        return $this->redirect()->toRoute('tax', ['action' => 'index']);
    }

    public function deleteAction()
    {

    }
}
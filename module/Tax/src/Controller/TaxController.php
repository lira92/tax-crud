<?php

namespace Tax\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Tax\Model\TaxTable;
use Tax\Model\Tax;
use Tax\Model\Operator;
use Tax\Form\TaxTableForm;
use Doctrine\ORM\Query;

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

        return new ViewModel([
            'taxTables' => $taxTables
        ]);
    }

    public function getTaxesAction()
    {
        $taxTables = $this->entityManager
            ->createQuery('SELECT tb, t, o FROM Tax\Model\TaxTable tb JOIN tb.taxes t JOIN tb.operator o')
            ->getResult(Query::HYDRATE_ARRAY);

        return new JsonModel([
            'success' => true,
            'data' => [
                'taxTables' => $taxTables,
            ],
        ]);
    }

    public function addAction()
    {
        $form = new TaxTableForm($this->entityManager);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        $taxTable = new TaxTable();
        $form->bind($taxTable);

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setInputFilter($taxTable->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
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

        $this->entityManager->persist($taxTable);
        $this->entityManager->flush();

        return $this->redirect()->toRoute('tax', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $taxTable = $this->entityManager->getRepository(TaxTable::class)->findOneBy(['id' => $id]);

        if ($this->request->isPost()) 
        {
            try {
                $this->entityManager->remove($taxTable);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                return new JsonModel([
                    'success' => false
                ]);
            }

            return new JsonModel([
                'success' => true
            ]);
        }
    }
}
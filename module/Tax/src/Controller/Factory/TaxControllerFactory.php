<?php
namespace Tax\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Tax\Controller\TaxController;

/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller.
 */
class TaxControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, 
                     $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the controller and inject dependencies
        return new TaxController($entityManager);
    }
}
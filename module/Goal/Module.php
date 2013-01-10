<?php
namespace Goal;

use Goal\Model\Goal;
use Goal\Model\GoalTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
        public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Goal\Model\GoalTable' =>  function($sm) {
                    $tableGateway = $sm->get('GoalTableGateway');
                    $table = new GoalTable($tableGateway);
                    return $table;
                },
                'GoalTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Goal());
                    return new TableGateway('goal', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
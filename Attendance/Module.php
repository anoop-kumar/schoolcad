<?php
namespace Attendance;

// Add these import statements:
use Attendance\Model\Attendance;
use Attendance\Model\AttendanceTable;
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
    
    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Attendance\Model\AttendanceTable' =>  function($sm) {
                    $tableGateway = $sm->get('AttendanceTableGateway');
                    $table = new AttendanceTable($tableGateway);
                    return $table;
                },
                'AttendanceTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Attendance());
                    return new TableGateway('attendance', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}

<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Attendance\Controller\Attendance' => 'Attendance\Controller\AttendanceController',
        ),
    ),
     // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'attendance' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/attendance[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Attendance\Controller\Attendance',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'attendance' => __DIR__ . '/../view',
        ),
    ),
);
<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Goal\Controller\Goal' => 'Goal\Controller\GoalController',
        ),
    ),
    
        // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'goal' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/goal[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Goal\Controller\Goal',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'goal' => __DIR__ . '/../view',
        ),
    ),
);
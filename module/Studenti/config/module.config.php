<?php
namespace Studenti;

use Studenti\Controller\StudentsController;
use Zend\Router\Http\Segment;
use Studenti\Controller\SubjectsController;
use Studenti\Controller\AjaxController;
use Zend\Router\Http\Literal;
use Studenti\Controller\IndexController;
use Studenti\Controller\CoursesController;

return [
    'controllers' => [
        'factories' => [
            //IndexController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'dashboard' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index',
                    ]
                ],
            ],
            'studenti' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/students[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => StudentsController::class,
                        'action' => 'index',
                    ]
                ]
            ],
            'predmeti' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/subjects[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => SubjectsController::class,
                        'action' => 'index',
                    ]
                ]
            ],
            'kursevi' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/courses[/:action[/:studentId[/:subjectId]]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'studentId' => '[0-9]*',
                    	'subjectId' => '[0-9]*',
           
                    ],
                    'defaults' => [
                        'controller' => CoursesController::class,
                        'action' => 'index',
                    ]
                ]
            ],
            'ajax' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/ajax[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => AjaxController::class,
                        'action' => 'some',
                    ]
                ],
            ],
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'studenti' => __DIR__ . '/../view',
        ],
    ],
];
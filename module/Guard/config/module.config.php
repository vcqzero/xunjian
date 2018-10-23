<?php
namespace Guard;

// use Zend\ServiceManager\Factory\InvokableFactory;
// use Zend\Router\Http\Segment;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Hostname;
use Api\Service\UserManager;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            //以下路由只有在规定的域名下才会匹配
            "guard.xunjina.com" => [
                'type' => Hostname::class,
                'options' => [
                    'route' => ':subdomain.xunjina.com',
                    'constraints' => [
                        'subdomain' => 'guard'
                    ],
                    'defaults' => [
                        'subdomain' => 'guard'
                    ],
                ],
                
                'child_routes'=>[
                    'home' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    
                    'auth' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/auth[/:action]',
                            'defaults' => [
                                'controller' => Controller\AuthController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    
                    //值班版块
                    'shift' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/shift[/:action]',
                            'defaults' => [
                                'controller' => Controller\ShiftController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    
                ],//child_routes end
            ],//admin route end
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
            Controller\ShiftController::class => Controller\Factory\ShiftControllerFactory::class,
        ],
        
    ],
    
    'permission' => [
        Controller\IndexController::class => [
            'allow'=> [
                UserManager::ROLE_WORKYARD_GUARD,
            ],
        ],
        Controller\AuthController::class => [
            'allow'=> [
                UserManager::ROLE_WORKYARD_GUARD,
                UserManager::ROLE_GUEST,
            ],
        ],
        Controller\ShiftController::class => [
            'allow'=> [
                UserManager::ROLE_WORKYARD_GUARD,
            ],
        ],
    ],
    
    'view_manager' => [
//         'display_not_found_reason' => true,
//         'display_exceptions'       => true,
//         'doctype'                  => 'HTML5',
//         'not_found_template'       => 'error/404',
//         'exception_template'       => 'error/index',
//         'template_map' => [
//             'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//             //             'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
//             'error/404'               => __DIR__ . '/../view/error/my404.phtml',
//             'error/index'             => __DIR__ . '/../view/error/my500.phtml',
//         ],
        'template_path_stack' => [
            'Guard' => __DIR__ . '/../view',
        ],
    ],
    
];

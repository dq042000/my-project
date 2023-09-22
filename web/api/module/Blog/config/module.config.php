<?php

namespace Blog;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
            Model\PostRepositoryInterface::class => Model\LaminasDbSqlRepository::class,
            Model\PostCommandInterface::class => Model\LaminasDbSqlCommand::class,
        ],
        'factories' => [
            Model\PostRepository::class => InvokableFactory::class,
            Model\LaminasDbSqlRepository::class => Factory\LaminasDbSqlRepositoryFactory::class,
            Model\PostCommand::class => InvokableFactory::class,
            Model\LaminasDbSqlCommand::class => Factory\LaminasDbSqlCommandFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Factory\ListControllerFactory::class,
            Controller\WriteController::class => Factory\WriteControllerFactory::class,
            Controller\DeleteController::class => Factory\DeleteControllerFactory::class,
        ],
    ],
    // This lines opens the configuration for the RouteManager
    // 這行代碼開啟了路由管理器(RouteManager)的配置
    'router' => [
        // Open configuration for all possible routes
        // 開啟所有可能路由(routes)的配置
        'routes' => [
            // Define a new route called "blog"
            // 定義一個名為 'blog' 的新路由(route)
            'blog' => [
                // Define a "literal" route type
                // 定義一個 'Literal' 路由(route)類型
                'type' => Literal::class,
                // Configure the route itself
                // 配置路由(route)本身
                'options' => [
                    // Listen to "/blog" as uri:
                    // 監聽 '/blog' 作為 uri:
                    'route' => '/blog',
                    // Define default controller and action to be called when
                    // this route is matched
                    // 當此路由匹配時，請定義要調用的默認控制器和動作
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'detail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/:id',
                            'defaults' => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ], 
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/edit/:id',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'edit',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/delete/:id',
                            'defaults' => [
                                'controller' => Controller\DeleteController::class,
                                'action'     => 'delete',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view', 
        ],
    ],
];
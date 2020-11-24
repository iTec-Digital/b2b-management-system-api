<?php

declare(strict_types=1);

use App\GraphQl\Mutations\SwitchBranch\SwitchBranch;
use App\GraphQL\Mutations\UAP\UpdateUserUAP;
use App\GraphQL\Queries\BranchList\BranchList;
use App\GraphQL\Queries\Core\Connectivity\Connectivity;
use App\GraphQL\Queries\Login\Login;
use App\GraphQL\Queries\Logout\Logout;
use App\GraphQL\Queries\UAP\GetModules;
use App\GraphQL\Queries\User\User;

use App\GraphQL\Queries\UserList\UserList;
use App\GraphQL\Types\Branch\BranchType;
use App\GraphQL\Types\Branch\Responses\BranchListResponseType;
use App\GraphQL\Types\Core\JsonResponse\JsonResponseType;
use App\GraphQL\Types\UAP\AppModuleType;
use App\GraphQL\Types\UAP\ModulePermissionType;
use App\GraphQL\Types\UAP\Responses\UAPResponseType;
use App\GraphQL\Types\UserList\Responses\UserListResponseType;
use GraphQL\Types\User\Response\UserResponseType;
use GraphQL\Types\User\UserType;


return [

    // The prefix for routes
    'prefix' => '____graphql',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // Same route for both query and mutation
    //
    // 'routes' => 'path/to/query/{graphql_schema?}',
    //
    // or define each route
    //
    // 'routes' => [
    //     'query' => 'query/{graphql_schema?}',
    //     'mutation' => 'mutation/{graphql_schema?}',
    // ]
    //
    'routes' => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Rebing\GraphQL\GraphQLController@query',
    //     'mutation' => '\Rebing\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers' => \Rebing\GraphQL\GraphQLController::class.'@query',

    // Any middleware for the graphql route group
    'middleware' => [],

    // Additional route group attributes
    //
    // Example:
    //
    // 'route_group_attributes' => ['guard' => 'api']
    //
    'route_group_attributes' => [],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'default_schema' => 'default',

    // The schemas for query and/or mutation. It expects an array of schemas to provide
    // both the 'query' fields and the 'mutation' fields.
    //
    // You can also provide a middleware that will only apply to the given schema
    //
    // Example:
    //
    //  'schema' => 'default',
    //
    //  'schemas' => [
    //      'default' => [
    //          'query' => [
    //              'users' => 'App\GraphQL\Query\UsersQuery'
    //          ],
    //          'mutation' => [
    //
    //          ]
    //      ],
    //      'user' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\ProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //      'user/me' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\MyProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //  ]
    //
    'schemas' => [
        'default' => [
            'query' => [
                'FRONT_END_CONNECTIVITY' => Connectivity::class,
            ],
            'mutation' => [
                // 'example_mutation'  => ExampleMutation::class,
            ],
            'middleware' => [],
            'method' => ['get', 'post'],
        ],

        'public' => [
            'query' => [
                'Login' => Login::class,
            ],
            'mutation' => [

            ],
            'middleware' => [],
        ],

        'private' => [
            'query' => [
                'User' => User::class,
                'BranchList' => BranchList::class,
                'GetModules' => GetModules::class,
                'UserList' => UserList::class,
                'Logout' => Logout::class,
            ],
            'mutation' => [
                'SwitchBranch' => SwitchBranch::class,
                'UpdateUserUAP' => UpdateUserUAP::class,
            ],
            'middleware' => ['jwt-auth'],
            'method' => ['any'],
        ]
    ],

    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'App\GraphQL\Type\UserType'
    // ]
    //
    'types' => [
        //Core Response (Known as JsonResponse)
        'JsonResponse' => JsonResponseType::class,

        //Login Module
        'LoginResponse' => App\GraphQL\Types\Login\Responses\LoginResponseType::class,

        //Branch Module
        'Branch' => BranchType::class,
        'BranchListResponse' => BranchListResponseType::class,

        //User Module
        'User' => UserType::class,
        'UserResponse' => UserResponseType::class,

        //User List Module
        'UserListResponse' => UserListResponseType::class,

        //UAP Module
        'AppModule' => AppModuleType::class,
        'ModulePermission' => ModulePermissionType::class,
        'UAPResponse' => UAPResponseType::class,
    ],

    // The types will be loaded on demand. Default is to load all types on each request
    // Can increase performance on schemes with many types
    // Presupposes the config type key to match the type class name property
    'lazyload_types' => false,

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],

    /*
     * Custom Error Handling
     *
     * Expected handler signature is: function (array $errors, callable $formatter): array
     *
     * The default handler will pass exceptions to laravel Error Handling mechanism
     */
    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key' => 'variables',

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://webonyx.github.io/graphql-php/security
     * for details. Disabled by default.
     */
    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    /*
     * You can define your own pagination type.
     * Reference \Rebing\GraphQL\Support\PaginationType::class
     */
    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     */
    'graphiql' => [
        'prefix' => '/graphiql',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],

    /*
     * Overrides the default field resolver
     * See http://webonyx.github.io/graphql-php/data-fetching/#default-field-resolver
     *
     * Example:
     *
     * ```php
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     * },
     * ```
     * or
     * ```php
     * 'defaultFieldResolver' => [SomeKlass::class, 'someMethod'],
     * ```
     */
    'defaultFieldResolver' => null,

    /*
     * Any headers that will be added to the response returned by the default controller
     */
    'headers' => [],

    /*
     * Any JSON encoding options when returning a response from the default controller
     * See http://php.net/manual/function.json-encode.php for the full list of options
     */
    'json_encoding_options' => 0,
];

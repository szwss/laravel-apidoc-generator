<?php

return [

    /*
     * The output path for the generated documentation.
     */
    'output' => 'public/'.env('API_DOC_PATH','apidocs'),

    /*
     * 指定静态资源文件的url前缀
     * 转换为/开头的url，防止局域网共享时其他访问者无法访问静态资源的问题
     */
    'resource_prefix' => '/'.env('API_DOC_PATH','apidocs').'/',

    /*
     * 默认Accept，当router为Dingo，并且Dingo开启了严格模式，则默认显示
     * */
    'default_accept' => 'application/'.env('API_STANDARDS_TREE','x').'.'.env('API_SUBTYPE','laravel').'.'.env('API_VERSION','v1').'+json',

    /*
     * 默认是否显示content_type，为false不显示，如自定义则直接指定其内容为
     * application/json
     * */
    'default_content_type' => false,

    /*
     * api文档默认请求域名，为false，则以config('app.url')值为准
     * 局域网访问请指定其访问域名
     * */
    'docs_url' => 'http://192.168.8.111:8888',

    /*
     * The router to be used (Laravel or Dingo).
     */
    'router' => 'laravel',

    /*
     * Generate a Postman collection in addition to HTML docs.
     */
    'postman' => true,

    /*
     * The routes for which documentation should be generated.
     * Each group contains rules defining which routes should be included ('match', 'include' and 'exclude' sections)
     * and rules which should be applied to them ('apply' section).
     */
    'routes' => [
        [
            /*
             * Specify conditions to determine what routes will be parsed in this group.
             * A route must fulfill ALL conditions to pass.
             */
            'match' => [

                /*
                 * Match only routes whose domains match this pattern (use * as a wildcard to match any characters).
                 */
                'domains' => [
                    '*',
                    // 'domain1.*',
                ],

                /*
                 * Match only routes whose paths match this pattern (use * as a wildcard to match any characters).
                 */
                'prefixes' => [
                    '*',
                    // 'users/*',
                ],

                /*
                 * Match only routes registered under this version. This option is ignored for Laravel router.
                 * Note that wildcards are not supported.
                 */
                'versions' => [
                    'v1',
                ],
            ],

            /*
             * Include these routes when generating documentation,
             * even if they did not match the rules above.
             * Note that the route must be referenced by name here (wildcards are supported).
             */
            'include' => [
                // 'users.index', 'healthcheck*'
            ],

            /*
             * Exclude these routes when generating documentation,
             * even if they matched the rules above.
             * Note that the route must be referenced by name here (wildcards are supported).
             */
            'exclude' => [
                // 'users.create', 'admin.*'
            ],

            /*
             * Specify rules to be applied to all the routes in this group when generating documentation
             */
            'apply' => [
                /*
                 * Specify headers to be added to the example requests
                 */
                'headers' => [
                    // 'Authorization' => 'Bearer {token}',
                    // 'Api-Version' => 'v2',
                ],

                /*
                 * If no @response or @transformer declarations are found for the route,
                 * we'll try to get a sample response by attempting an API call.
                 * Configure the settings for the API call here,
                 */
                'response_calls' => [
                    /*
                     * API calls will be made only for routes in this group matching these HTTP methods (GET, POST, etc).
                     * List the methods here or use '*' to mean all methods. Leave empty to disable API calls.
                     */
                    'methods' => ['GET'],

                    /*
                     * For URLs which have parameters (/users/{user}, /orders/{id?}),
                     * specify what values the parameters should be replaced with.
                     * Note that you must specify the full parameter, including curly brackets and question marks if any.
                     */
                    'bindings' => [
                        // '{user}' => 1
                    ],

                    /*
                     * Environment variables which should be set for the API call.
                     * This is a good place to ensure that notifications, emails
                     * and other external services are not triggered during the documentation API calls
                     */
                    'env' => [
                        'APP_ENV' => 'documentation',
                        'APP_DEBUG' => false,
                        // 'env_var' => 'value',
                    ],

                    /*
                     * Headers which should be sent with the API call.
                     */
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        // 'key' => 'value',
                    ],

                    /*
                     * Query parameters which should be sent with the API call.
                     */
                    'query' => [
                        // 'key' => 'value',
                    ],

                    /*
                     * Body parameters which should be sent with the API call.
                     */
                    'body' => [
                        // 'key' => 'value',
                    ],
                ],
            ],
        ],
    ],

    /*
     * Custom logo path. Will be copied during generate command. Set this to false to use the default logo.
     *
     * Change to an absolute path to use your custom logo. For example:
     * 'logo' => resource_path('views') . '/api/logo.png'
     *
     * If you want to use this, please be aware of the following rules:
     * - size: 230 x 52
     */
    'logo' => false,
];

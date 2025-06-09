protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    // other middleware aliases...
    'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
];

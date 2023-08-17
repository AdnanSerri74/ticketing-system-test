<?php

use app\Core\Env;
use app\Core\Request;
use app\Core\Response;
use app\Core\Router;
use app\Core\Session;
use app\Core\ValidationException;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/errors/{$code}.view.php");
    die();
}

function authorise(bool $condition, $status = Response::FORBIDDEN): bool
{
    if (!$condition)
        abort($status);

    return true;
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);

    return require base_path('views/' . $path . '.php');
}

function redirect(string $to): void
{
    header("location: {$to}");
    exit();
}

function old($key, $default = '')
{
    return \app\Core\Session::get('old')[$key] ?? $default;
}

function config(string $path)
{
    return require base_path("config/{$path}.php");
}

function controller(string $controller): string
{
    $controllersDefaultPath = config('app')['controllers_default_path'] ?? 'app/Http/Controllers';

    return "$controllersDefaultPath/{$controller}";
}

function loadController(string $controller, string $function): mixed
{
    $controllerClass = controller($controller);

    $controllerClass = str_replace('/', '\\', $controllerClass);

    $instance = new $controllerClass();

    return $instance->$function();
}

function env($key, $default = null): string|null
{
    if (!isset($_ENV[$key]))
        new Env();

    return $_ENV[$key] ?? $default;
}

function registerClasses(): void
{
    spl_autoload_register(function (string $class) {

        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        require base_path("{$class}.php");
    });
}

function registerRoutes(): Router
{
    $router = new Router();

    require base_path('routes/web.php');

    return $router;
}

function identifyCurrentRouteInfo(): array
{
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

    return compact('uri', 'method');
}

function handleRequest(Router $router, array $routeInfo)
{
    try {

        $router->route($routeInfo['uri'], $routeInfo['method']);

    } catch (ValidationException $exception) {
        Session::flash('errors', $exception->errors);
        Session::flash('old', $exception->old);

        return redirect($router->previousUrl());
    }

    Session::disposeFlash();
}

function queryString(string $key, $value, $remove)
{
    parse_str($_SERVER['QUERY_STRING'] ?? '', $query_string);
    $query_string[$key] = $value;

    if (array_key_exists($remove, $query_string))
        unset($query_string[$remove]);

    return http_build_query($query_string);
}

function request(string $key = null)
{
    if ($key)
        return (new Request())->get($key);

    return new Request();
}

function asset(string $path): void
{
    echo '/assets/' . $path;
}
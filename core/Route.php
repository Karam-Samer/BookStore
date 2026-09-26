<?php

class Route
{
    private static array $routes = [];

    public static function get(string $url, string $controller, string $action, array $middlewares = []): void
    {
        self::$routes[] = [
            'url' => $url,
            'method' => 'GET',
            'controller' => $controller,
            'action' => $action,
            'middlewares' => $middlewares
        ];
    }

    public static function post(string $url, string $controller, string $action, array $middlewares = []): void
    {
        self::$routes[] = [
            'url' => $url,
            'method' => 'POST',
            'controller' => $controller,
            'action' => $action,
            'middlewares' => $middlewares
        ];
    }

    public static function routes(): array
    {
        return self::$routes;
    }

    public static function dispatch()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $method = $_SERVER['REQUEST_METHOD'];

        $flag = false;

        foreach (self::$routes as $route) {
            $args = self::matchRoute(BASE_URL . $route['url'], $url);

            if ($args !== false) {
                if ($route['method'] !== $method) {
                    $flag = true;
                    continue;
                }

                $flag = false;

                self::handleMiddlewares($route['middlewares']);

                $obj = new $route['controller']();

                $obj->{$route['action']}(...$args);
                return;
            }
        }

        if ($flag) {
            Response::error("Method Not Allowed", 405);
        }

        Response::error("404 Not Found", 404);
    }

    private static function matchRoute(string $route, string $url): false|array
    {
        $regex = "/\{([A-Za-z_][A-Za-z0-9_]*)\}/";
        $pattern = preg_replace($regex, '([^/]+)', $route);
        $pattern = "#^{$pattern}$#";
        if (!preg_match($pattern, $url, $matches)) {
            return false;
        }
        unset($matches[0]);
        return $matches;
    }

    private static function handleMiddlewares(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $args = [];
            if (str_contains($middleware, ":")) {
                $arr = explode(":", $middleware);
                $middleware = $arr[0];
                if (str_contains($arr[1], ",")) {
                    $args = explode(",", $arr[1]);
                } else {
                    $args = [$arr[1]];
                }
            }
            (new $middleware())->handle(...$args);
        }
    }
}

<?php

namespace Utils;

use Utils\TwigService;

class Router {
  private static array $routes = [];

  public static function GET(string $path, $callback) {
    self::$routes['GET'][$path] = $callback;
  }

  public static function POST(string $path, $callback) {
    self::$routes['POST'][$path] = $callback;
  }

  public static function dispatch($method, $uri) {
    $uri = parse_url($uri, PHP_URL_PATH);

    foreach (self::$routes[$method] as $route => $callback) {
      $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
      $pattern = '#^' . $pattern . '$#';

      if (preg_match($pattern, $uri, $matches)) {
          array_shift($matches);

          if (is_array($callback)) {
              $controller = new $callback[0]();
              $method = $callback[1];

              return call_user_func_array([$controller, $method], $matches);
          }

          return call_user_func_array($callback, $matches);
      }
    }

    http_response_code(404);
    self::render404();
  }

  private static function render404(): void {
    TwigService::render('404.html.twig');
  }
}
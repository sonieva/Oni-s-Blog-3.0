<?php

namespace Utils;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigService {
  private static ?Environment $twig = null;

  private static function init(): void {
    if (self::$twig === null) {
      $loader = new FilesystemLoader(__DIR__ . '/../../templates');
      self::$twig = new Environment($loader, [
        'cache' => false,
        'debug' => true
      ]);
    }
  }

  public static function render(string $view, array $data = []): void {
    self::init();
    
    self::$twig->addGlobal('user', Auth::getUser());
    echo self::$twig->render($view, $data);
  }

  public static function renderTemplate(string $view, array $data = []): string {
    self::init();
    return self::$twig->render($view, $data);
  }
}

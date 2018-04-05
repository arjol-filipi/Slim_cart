<?php
use function DI\get;
use Cart\Models\Product;
use Slim\Views\Twig;
use Cart\Basket\Basket;
use Slim\Views\TwigExtension;
use Interop\Container\ContainerInterface;
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
use Cart\Support\Storage\SessionStorage;
use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Validation\Contracts\ValidatorInterface;
use Cart\Validation\Validator;

return [
  // Router container
  'router' => get(Slim\Router::class),
  ValidatorInterface::class => function(ContainerInterface $c){
    		return new Validator;
    },
  // Storage Interface
  StorageInterface::class => function(ContainerInterface $c) {
    return new SessionStorage('cart');
  },
  Basket::class => function(ContainerInterface $c) {
    return new Basket(
      $c->get(SessionStorage::class),
      $c->get(Product::class)
    );
  },
  // Twig container
  Twig::class => function (ContainerInterface $c) {
    $twig = new Twig(__DIR__ . '/../resources/views', [
      'cache' => false
    ]);
    $twig->addExtension(new TwigExtension(
      $c->get('router'),
      $c->get('request')->getUri()
    ));
    $twig->getEnvironment()->addGlobal('basket', $c->get(Basket::class));
    return $twig;
  },
  // Monolog
  //Logger::class => function (ContainerInterface $c) {
   // $log = new Logger('Cart');
  //  $log->pushHandler(new StreamHandler('../logs/app.log', Logger::INFO));
 //   return $log;
 // },
  Product::class => function(ContainerInterface $c) {
    return new Product;
  }
];
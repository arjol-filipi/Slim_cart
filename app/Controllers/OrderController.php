<?php

namespace Cart\Controllers;

use Slim\Views\Twig;
use Slim\Router;
use Cart\Basket\Basket;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Cart\Models\Product;
use Cart\Validation\Contracts\ValidatorInterface;


class OrderController{
    protected $basket;
    protected $router;
    protected $validator;
    public function __construct(Basket $basket,Router $router,ValidatorInterface $validator){
        $this->basket = $basket;
        $this->router = $router;
        $this->validator = $validator;
    }
  public function index(Request $request, Response $response, Twig $view){
    $this->basket->refresh();
    if(!$this->basket->subTotal() ){
        return $response->withRedirect($this->router->pathFor('cart.index'));
    }

    return $view->render($response,'order/index.twig');
    
  }
  public function create(Request $request, Response $response){
        $this->basket->refresh();
        if(!$this->basket->subTotal()){
            //no more stock for us to sell
            return $response->withRedirect($this->router->pathFor('cart.index'));
        }
        var_dump($this->validator);
        die();

  }

}
<?php

namespace Cart\Controllers;
use Slim\Router;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Cart\Models\Product;
class ProductController{
    //public function __construct(Twig $view){
        //$this->$view = $view;}
    
    public function get($slug,Request $request,Router $router, Response $response, Twig $view,Product $product){
        $product = $product->where('slug',$slug)->first();
        if (!$product){
           return $response->withRedirect($router.pathFor('home'));
        }
        return $view->render($response,'products/product.twig',[
            'product' =>$product,
        ]);
    }
}
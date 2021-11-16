<?php
require "../bootstrap.php";
use Src\Controller\UsersController;
use Src\Controller\EventsController;
use Src\Controller\CategoriesController;
use Src\Controller\TicketsController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /use o
// everything else results in a 404 Not Found
if ($uri[1] === 'users')
   {
   
       $userId = null;
       if (isset($uri[2])) 
          {
              $userId = (int) $uri[2];
          }
       $requestMethod = $_SERVER["REQUEST_METHOD"];
       // pass the request method and user ID to the UseController and process the HTTP   request:
       $controller = new UsersController($dbConnection, $requestMethod, $userId);
       $controller->processRequest();
    
   }else if($uri[1] === 'events') 
   {
      $eventId = null;
      if (isset($uri[2])) 
      {
          $eventId = (int) $uri[2];
      }
      $requestMethod = $_SERVER["REQUEST_METHOD"];

      // pass the request method and user ID to the UseController and process the HTTP   request:
      $controller = new EventsController($dbConnection, $requestMethod, $eventId);
      $controller->processRequest();
    
    
   }else if ($uri[1] === 'categories') 

   { 
       $catId = null;
       if (isset($uri[2])) {
          $catId = (int) $uri[2];
       }
       $requestMethod = $_SERVER["REQUEST_METHOD"];
       // pass the request method and user ID to the UseController and process the HTTP   request:
       $controller = new CategoriesController($dbConnection, $requestMethod, $catId);
       $controller->processRequest();
    
   }else if ($uri[1] === 'tickets') 

   { 
       $catId = null;
       if (isset($uri[2])) {
          $ticketId = (int) $uri[2];
       }
       $requestMethod = $_SERVER["REQUEST_METHOD"];
       // pass the request method and user ID to the UseController and process the HTTP   request:
       $controller = new TicketsController($dbConnection, $requestMethod, $ticketId);
       $controller->processRequest();
    
   }
   else
   { 
      header("HTTP/1.1 404 Not Found");
      exit();

}


function authenticate() {
    try {
        switch(true) {
            case array_key_exists('HTTP_AUTHORIZATION', $_SERVER) :
                $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
                break;
            case array_key_exists('Authorization', $_SERVER) :
                $authHeader = $_SERVER['Authorization'];
                break;
            default :
                $authHeader = null;
                break;
        }
        preg_match('/Bearer\s(\S+)/', $authHeader, $matches);
        if(!isset($matches[1])) {
            throw new \Exception('No Bearer Token');
        }
        $jwtVerifier = (new \Okta\JwtVerifier\JwtVerifierBuilder())
            ->setIssuer(getenv('OKTAISSUER'))
            ->setAudience('api://default')
            ->setClientId(getenv('OKTACLIENTID'))
            ->build();
        return $jwtVerifier->verify($matches[1]);
    } catch (\Exception $e) {
        return false;
    }
}
?>

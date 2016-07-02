<?php

//include_once('php/twig/lib/Twig/Autoloader.php');
//Twig_Autoloader::register();

//    require 'vendor/autoload.php';
//print_r($_SERVER['REQUEST_URI']);
////echo $_GET['url'];
//    $router = new App\Router\Router($_GET['url']);
//    $router->get('/', function(){
//        $loader = new Twig_Loader_Filesystem('templates');
//        $twig = new Twig_Environment($loader, array(
//            'cache' => false
//        ));
//        $test = "Acceuil marmiton";
//        $template = $twig->loadTemplate('index.twig');
//        echo $template->render(array('test' => $test, ));
//    });
//    $router->get('/recipe/', function(){
//        echo 'Toutes les recettes';
//        $loader = new Twig_Loader_Filesystem('templates');
//        $twig = new Twig_Environment($loader, array(
//            'cache' => false
//        ));
//        $test = "liste des recettes";
//        $template = $twig->loadTemplate('index.twig');
//        echo $template->render(array('test' => $test, ));
//    });
//    $router->get('/add', function(){
//        echo 'Ajouter une recette';
//        $loader = new Twig_Loader_Filesystem('templates');
//        $twig = new Twig_Environment($loader, array(
//            'cache' => false
//        ));
//        $test = "Ajouter une nouvelle recette";
//        $template = $twig->loadTemplate('newrecipe.twig');
//        echo $template->render(array('test' => $test, ));
//    });
//$router->post('/recette/:slug-:id', function())
//    $router->get('/recette/:id', function($id){ echo 'Afficher la recette'.$id; });
//    $router->post('/recette/:id', function($id){ echo 'Poster la recette'.$id; });
//
//
//    $router->run();

//    $loader = new Twig_Loader_Filesystem('templates');
//    $twig = new Twig_Environment($loader, array(
//        'cache' => false
//    ));
//    $test = "Bonjour";
//    $template = $twig->loadTemplate('index.twig');
//    echo $template->render(array('test' => $test, ));

require 'vendor/autoload.php';
var_dump($_SERVER['REQUEST_URI']);
echo '</br>';
var_dump($_GET);
$path = explode('/', $_SERVER['REQUEST_URI']);
$path = array_filter($path);
//var_dump($path);

//$router = new App\Router\Router($_GET['url']);
$router = new App\Router\Router("recette/1");
    include 'src/Config/Routes.php';
$router->run();
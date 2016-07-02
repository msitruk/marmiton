<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 22/06/16
 * Time: 14:04
 */

namespace App\Controller;

//require './vendor/autoload.php';

class HomepageController
{
    //private $twig;
    //private $pdo;
//    public function __construct()
//    {
//        $this->pdo = new dbTool();
//        $this->twig = new \Smarty();
//    }
    public function home()
    {
        //$getLastRecette = $this->pdo->getLastRecette();
        $loader = new \Twig_Loader_Filesystem('./templates');
        $twig = new \Twig_Environment($loader, array(
        'cache' => false
        ));
        $test = "Acceuil marmiton";
        $template = $twig->loadTemplate('index.twig');
        echo $template->render(array('test' => $test, ));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 22/06/16
 * Time: 15:21
 */

namespace App\Controller;
use App\Model\Database;

/**
 * Class RecetteController cette classe permet de gérer les recettes, soumission, enregistrement et affichage
 * @package App\Controller
 */
class RecetteController
{
    private $_id;

    public function AddRecetteView()
    {
        $loader = new \Twig_Loader_Filesystem('templates');
        $twig = new \Twig_Environment($loader, array(
            'cache' => false
        ));
        $fil = "Ajouter une nouvelle recette";
        $template = $twig->loadTemplate('newrecipe.twig');
        echo $template->render(array('fil' => $fil, ));
    }

    public function AddRecetteInsert()
    {
        $database = new Database();
        $database->insertRecipe($_POST, $_FILES);
    }

    public function showRecette()
    {
        $loader = new \Twig_Loader_Filesystem('templates');
        $twig = new \Twig_Environment($loader, array(
            'cache' => false
        ));
        $fil = "Détail d'une recette";
        $template = $twig->loadTemplate('recipe.twig');
        echo $template->render(array(
            'fil' => $fil,
            ));
    }
}
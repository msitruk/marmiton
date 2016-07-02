<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 22/06/16
 * Time: 13:58
 */

$router->get('/', "Homepage#home");
$router->get('/add', "Recette#AddRecetteView");
$router->post('/add', "Recette#AddRecetteInsert");
$router->get('/recette/:id', "Recette#showRecette")->with('id', '[0-9]+')/*->with('slug','([a-z\-0-9]+)')*/;
$router->get('/posts', function(){ echo "Bienvenue sur ma homepage !"; });
//$router->get('/recettes/:id', "recette#RecetteView");
$router->post('/posts/:id', function($id){ echo "Voila l'article $id"; });
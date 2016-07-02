<?php
  include_once('php/twig/lib/Twig/Autoloader.php');
  Twig_Autoloader::register();
  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader, array(
					'cache' => false
					));
  $test = "Bonjour";
  $template = $twig->loadTemplate('newrecipe.twig');
  echo $template->render(array('test' => $test, ));
?>

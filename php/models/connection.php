<?php
function connection ()
{
	try
	{
		$connection = new PDO('mysql:host=localhost;', 'root', '');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	return ($connection);
}
?>

<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 01/07/16
 * Time: 09:15
 */

namespace App\Model;
use \PDO;


class Database
{

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;

    /**
     * Database constructor.
     * @param $db_name
     * @param string $db_user
     * @param string $db_pass
     * @param string $db_host
     */
    public function __construct($db_name = 'marmiton', $db_user = 'root', $db_pass = 'pf69ppyo', $db_host = 'localhost')
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    private function getPDO()
    {
        if($this->pdo === null)
        {
            //die("mysql:host=$this->db_host;dbname=$this->db_name;", $this->db_user, $this->db_pass);
            $pdo = new PDO("mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8", $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    private function query($statement)
    {
        $req = $this->getPDO()->query($statement);
        $datas = $req->fetchAll(PDO::FETCH_OBJ);
        return $datas;
    }

    public function insertRecipe($post, $files)
    {

        //on rajoute les infos dans la table recette
        $pdo = $this->getPDO();
        $req = $pdo->prepare('INSERT INTO recette (nom, type, vegetarien, difficulte, cout, prephour, prepmin, cuisshour, cuissmin, portionqty, portionunity, boisson, remarques, typecuisson) VALUES(:nom, :type, :vegetarien, :difficulte, :cout, :prephour, :prepmin, :cuisshour, :cuissmin, :portionqty, :portionunity, :boisson, :remarques, :typecuisson)');
        $req->execute(array(
            'nom' => $post["recipeName"],
            'type' => $post["recipeType"],
            'vegetarien' => $post["recipeVegetarian"],
            'difficulte' => $post["recipeDifficulty"],
            'cout' => $post["recipeCost"],
            'prephour' => $post["recipePrepHour"],
            'prepmin' => $post["recipePrepMin"],
            'cuisshour' => $post["recipeBakingHour"],
            'cuissmin' => $post["recipeBakingMin"],
            'portionqty' => $post["recipePortionValue"],
            'portionunity' => $post["recipePortionUnit"],
            'boisson' => $post["recipeDrink"],
            'remarques' => $post["recipeNote"],
            'typecuisson' => $post["recipeBakingType"]
        ));

        //on recupère la dernière id ajouté en base
        $lastId = $pdo->lastInsertId();

        //on rajoute les infos dans la table etapes en pécisant la dernière id recette
        for ($i = 1; isset($post['recipeStep'.$i]); $i++)
        {
            $req = $pdo->prepare('INSERT INTO etapes (idrecette, rang, indications) VALUES (:idrecette, :rang, :indications)');
            $req->execute(array(
                'idrecette' => $lastId,
                'rang' => $i,
                'indications' => $post['recipeStep'.$i]
            ));
        }

        //on rajoute les infos dans la table ingrédients en précisant la dernière id recette
        for ($i = 1; isset($post['recipeIngredientQty'.$i]); $i++)
        {
            $req = $pdo->prepare('INSERT INTO ingredients (quantite, nom, idrecette) VALUES (:quantite, :nom, :idrecette)');
            $req->execute(array(
                'quantite' => $post['recipeIngredientQty'.$i],
                'nom' => $post['recipeIngredientName'.$i],
                'idrecette' => $lastId
            ));
        }

        // si $files exist on ajoute la photo de la recette dans la tables photos
        if (isset($files))
        {
            $req = $pdo->prepare('INSERT INTO photos (path, idrecette) VALUES (:path, :idrecette)');
            $req->execute(array(
                'path' => $files["recipePhoto"]["tmp_name"],
                'idrecette' => $lastId
            ));
        }
    }

}
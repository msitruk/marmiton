<?php
function rename_table($connection, $name_database, $old_table, $new_table)
{
  $sql = "RENAME TABLE $name_database."."$old_table  TO $name_database."."$new_table";
  try
    {
      $req = $connection->query($sql);
      echo"success ..";
    }
  catch (PDOException $e)
    {
      echo "Rename  failed";
    }
}

function delete_element($connection, $name_database, $table, $element)
{
  $sql = "ALTER TABLE $name_database."."$table DROP $element";
  $nb = nb_column ($connection, $name_database,  $table);
  try
    {
      if ($nb != 1)
        {
          $req1 = $connection->query($sql);
          echo " Success<br>";
        }
      else
        {
	  echo "Vous ne pouvez effacer tous les champs avec ALTER TABLE. Utilisez DROP TABLE";
        }
    }
  catch (PDOException $e)
    {
      echo "Delete element Failed";
    }
}

function add_table($connection, $name_database, $name_table, $array)
{
  $arraystr = test_PrimaryKey($array);
  var_dump($arraystr);
  $nb_array = count($arraystr);
  $s = "CREATE TABLE $name_database.$name_table (";
  for ($i = 0; $i < $nb_array; $i++)
    {
      $str = implode(" ",$arraystr[$i]);
      if ($i != ($nb_array - 1))
        {
	  $s = $s.$str." , ";
        }
      else
        {
	  $s = $s.$str;
        }
    }
  $s = $s.")";
  try
    {
      $req = $connection->query($s);
      echo"success ..";
    }
  catch (PDOException $e)
    {
      echo "create table failed";
    }
}

function test_PrimaryKey ($array)
{
  $nb_array = count($array);
  for ($x = 0; $x != $nb_array; $x++)
    {
      $element = in_array("AUTO_INCREMENT", $array[$x]);
      $i_AI = array_search("id", $array[$x]);
      if ($element == true )
        {
	  $tab = array();
	  $tab['primary'] = "PRIMARY KEY (".$array[$x]['fieldName'].")";
	  array_push($array, $tab);
        }
    }
  return($array);
}

function empty_table($connection, $name_database, $name_table)
{
  $sql = "TRUNCATE TABLE $name_database.$name_table";
  try
    {
      $req = $connection->query($sql);
      echo ("Sucess ");
    }
  catch (PDOException $e)
    {
      echo "Failed ...";
    }
}

function edit_element($connection, $name_database, $name_table, $name_element, $array)
{
  $nb_array = count($array);
  $sql = "ALTER TABLE $name_database.$name_table CHANGE $name_element ";
  for ($i = 0; $i < $nb_array; $i++)
    {
      if ($i != ($nb_array - 1))
        {
	  $sql = $sql.$array[$i]." ";
        }
      else
        {
	  $sql = $sql.$array[$i];
        }
    }
  try
    {
      $req = $connection->query($sql);
      echo"success ..";
    }
  catch (PDOException $e)
    {
      echo "Alter table failed";
    }
}

function add_element($connection, $db, $table, $array)
{
  $sql = "ALTER TABLE $db.$table ADD ";
  $array = array_filter($array);
  $array =  array_values($array);
  $nb_array = count($array);
  $i = 0;
  while ( $i < $nb_array)
    {
      if ($array[0] <> true)
	{
	  $sql = $sql." ' ".$array[0]." ' ";
	}
      else
	{
	  $sql = $sql.$array[$i]." ";
	}
      $i = $i + 1;
    }
  try
    {
      $req = $connection->query($sql);
      echo "Insertion sucess";
    }
  catch (PDOException $e)
    {
      echo "Insertion failed";
    }
}

function list_column($connection, $table)
{
  $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '"."$table"."' ";
  $req = $connection->query($sql);
  $bases = array();
  $i = 0;
  while ($row = $req->fetch())
    {
      $bases["base".$i] = $row[0];
      $i = $i + 1;
    }
  return($bases);
}

function add_data($connection, $db, $table, $array)
{
  $sql = "Insert into $db.$table values (";
  $nb_array = count($array);
  $i = 0;
  while ($i < ($nb_array - 1))
    {
      if ($array[0] <> true)
        {
	  $sql = $sql." ' NULL ' , ";
        }
      else
        {
	  $sql = $sql."'".$array[$i]." ' , ";
        }
      $i = $i + 1;
    }
  $end_array = end($array);
  $sql = $sql."'".$end_array."')";
  try
    {
      $req = $connection->query($sql);
      echo "Insertion sucess";
    }
  catch (PDOException $e)
    {
      echo "Insertion failed";
    }
}

function search_primary($login, $db, $table)
{
  $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE CONSTRAINT_SCHEMA='$db' AND CONSTRAINT_NAME='PRIMARY' AND TABLE_NAME='$table'";
  $req = $login->query($sql);
  while ($primary = $req->fetch())
    {
      $return = $primary["COLUMN_NAME"];
    }
  return ($return);
}

function add_primaryKey($connection, $db, $table, $data)
{
  $search = search_primary($connection, $db, $table);
  var_dump($search);
  if (is_null($search))
    {
      $sql = "ALTER TABLE $db.$table ADD PRIMARY KEY(`$data`)";
      $sth = $connection->prepare($sql);
      $sth->execute();
      $return = array();
      if (!$sth->execute())
	{
	  $return = ($sth->errorInfo());
	  return ($return[2]);
	}
      else
	{
	  $result = $sth->fetch();
	  return ("Sucess regarde dans ta table");
	}
    }
  else
    {
      $sql = "ALTER TABLE $db.$table DROP PRIMARY KEY, ADD PRIMARY KEY(`$data`)";
      $sth = $connection->prepare($sql);
      $sth->execute();
      $return = array();
      if (!$sth->execute())
	{
	  $return = ($sth->errorInfo());
	  return ($return[2]);
	}
      else
	{
	  $result = $sth->fetch();
	  return ("sucess vérifie dans ta table");
	}
    }
}


function edit_data($connection, $name_database, $name_table, $array, $id_data, $id_name)
{
  $nb_array = count($array);
  $nb_cl = list_column($connection, $name_table);
  $sql = "UPDATE $name_database.$name_table SET ";
  for ($i=0; $i < ($nb_array - 1); $i++)
    {
      if ($i != $nb_array)
        {
          $protect = $connection->quote($array[$i]);
          $sql = $sql.$nb_cl["base".$i]." = ".$protect." , ";
        }
    }
  $end = end($array);
  $sql= $sql.$nb_cl["base".$i]." = ".$end." ";
  $sql = $sql."WHERE $name_table.$id_name = $id_data";
  echo $sql;
  try
    {
      $req = $connection->query($sql);
      echo"success ..";
    }
  catch (PDOException $e)
    {
      echo "edit data failed";
    }
}

function delete_data($connection, $name_database, $name_table, $id_name, $id_value)
{
  $sql = "DELETE FROM $name_database.$name_table WHERE $id_name = $id_value";
    try
    {
      $req = $connection->query($sql);
      echo"success ..";
    }
  catch (PDOException $e)
    {
      echo "delete data failed";
    }
}

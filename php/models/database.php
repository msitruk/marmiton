<?php
function show_database($connection)
{
  $sql = 'SHOW DATABASES';
  $req = $connection->query($sql);
  $bases = array();
  $i = 0;
  while ($row = $req->fetch())
    {
      $bases["base".$i] = $row[0];
      $i = $i + 1;
    }
  $req->closeCursor();
  return ($bases);
}

function insert_database($name_database, $connection)
{
  $sql = "CREATE DATABASE ".$name_database;
  try
    {
      $connection->exec($sql);
      echo "Database created successfully<br>";
    }
  catch (PDOException $e)
    {
      echo "No Create database";
    }
}

function delete_database($name_database, $connection)
{
  $sql = "DROP DATABASE $name_database";
  try
    {
      $req1 = $connection->query($sql);
      echo "Database deleted successfully<br>";
    }
  catch (PDOException $e)
    {
      echo "Delete Failed";
    }
}

function list_table_database($connection, $name_database)
{
  $i = 0;
  $sql = "select table_name from information_schema.tables where TABLE_SCHEMA='".$name_database."'";
  $tables = array();
  try
    {
      $req = $connection->query($sql);
    }
  catch (PDOException $e)
    {
      echo "List table Failed";
    }
  while ($row = $req->fetch())
    {
      $tables["table".$i] = $row[0];
      $i = $i + 1;
    }
  $req->closeCursor();
  return ($tables);
}

function rename_database($new_name, $old_name)
{
  $connection = new PDO('mysql:host=localhost;dbname='.$old_name.'', 'root', '');
  $sql = "CREATE DATABASE $new_name; ";
  $req = $connection->query($sql);
  $nb_db = nb_database($connection, $old_name);
  $i = 0;
  $connection->query($sql);
  $listdb = list_table_database($connection, $old_name);
  if (!empty($listdb))
  {
   $sql2 =  "RENAME TABLE ";
    while ($i < ($nb_db - 1))
      {
        $sql2 = $sql2."$old_name.".$listdb['table'.$i]." TO $new_name.".$listdb['table'.$i]. " , ";
        $i = $i + 1;
      }
    $end = end($listdb);
    $sql2 = $sql2 .$end." TO $new_name.".$listdb['table'.$i]."; DROP DATABASE ".$old_name.";";
  }
  else
  {
    $sql2 = "DROP DATABASE ".$old_name.";";
  }

 try
    {
      $connection->query($sql2);
    }
  catch (PDOException $e)
    {
      echo "Rename Failed";
    }
}

function show_table_database($connection, $name_database)
{
  $i = 0;
  $sql = "select table_name from information_schema.tables where TABLE_SCHEMA='".$name_database."'";
  try
    {
      $req = $connection->query($sql);
    }
  catch (PDOException $e)
    {
      echo "Show table Failed";
    }
  while ($row = $req->fetch())
    {
      $tables["table".$i] = $row[0];
      $i = $i + 1;
    }
  $req->closeCursor();
  return ($tables);
}

function nb_database($connection, $name_database)
{
  $i = 0;
  $sql = "select table_name from information_schema.tables where TABLE_SCHEMA='".$name_database."'";
  try
    {
      $req = $connection->query($sql);
    }
  catch (PDOException $e)
    {
      echo "Nb_database Failed ...";
    }
  while ($row = $req->fetch())
    {
      $tables["table".$i] = $row[0];
      $i = $i + 1;
    }
  $req->closeCursor();
  return ($i);
}

function statistics_database($connection, $name_database)
{
  $i = 1;
  $sql = "select table_name, data_length, CREATE_time from information_schema.tables where TABLE_SCHEMA='".$name_database."'";

  try
    {
      $req = $connection->query($sql);
    }
  catch (PDOException $e)
    {
      echo "Statistics Failed !!";
    }
  while ($row = $req->fetch())
    {
      $tables[$i]["tableName"] = $row[0];
      $tables[$i]["tableLenght"] = $row[1];
      $tables[$i]["tableDate"] = $row[2];
      $i = $i + 1;
    }
  $req->closeCursor();
  return ($tables);
}
?>

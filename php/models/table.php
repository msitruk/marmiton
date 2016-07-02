<?php
function list_table($connection, $base, $table)
{
  $sql = "select column_name, column_type, DATA_TYPE from information_schema.columns where table_schema = '$base' and table_name= '$table'";
  $req = $connection->query($sql);
  $field = array();
  $i = 0;
  while ($row = $req->fetch())
    {
      $field[$i]["Name"] = $row[0];
      $field[$i]["Type"] = $row[1];
      $field[$i]["typename"] = $row[2];
      $i = $i + 1;
    }
  $req->closeCursor();
  return ($field);
}

function delete_table($table, $basename, $connection)
{
  $sql = "DROP TABLE $basename.$table";
  try
    {
      $connection->query($sql);
      echo "Database deleted successfully<br>";
    }
  catch (PDOException $e)
    {
      echo "Delete Database failed";
    }
}

function nb_column($connection, $db, $table)
{
  $i = 0;
  $sql = "select * from information_schema.columns where table_schema = '"."$db"."' and table_name= '"."$table"."' ";
  try
    {
      $req = $connection->query($sql);
    }
  catch (PDOException $e)
    {
      echo "Show table of database failed";
    }
  while ($row = $req->fetch())
    {
      $tables["table".$i] = $row[0];
      $i = $i + 1;
    }
  $req->closeCursor();
  return ($i);
}

function show_table($connection, $base, $table)
{
  $sql = "SELECT * FROM $base".".$table";
  $req = $connection->query($sql);
  $lignes = array();
  $i = 0;
  $j = nb_column($connection, $base, $table);
  while ($row = $req->fetch(PDO::FETCH_ASSOC))
    {
      $h = 0;
      foreach ($row as $value) {
	$lignes[$i][$h] = $value;
	$h = $h + 1;
      }
      $i = $i + 1;
    }
  $req->closeCursor();
  return ($lignes);
}

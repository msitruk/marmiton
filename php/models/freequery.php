<?php
function free_request($connection, $request)
{
  $sth = $connection->prepare($request);
  $test = $sth->execute();
  $return = array();
  if ($test == FALSE)
  {
    $return = ($sth->errorInfo());
  }
  else
  {
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    $return = $result;
    if (empty($return))
    {
      $return = ("Requête effectuée.");
    }
  }
   return ($return);
}

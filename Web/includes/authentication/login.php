<?php
function login($name, $password){
  if (!isset($_SESSION)){
    session_start();
  }

  $linkDB = connectToDataBase();
  $result = $linkDB->query("SELECT * FROM Entitys
                          WHERE Name = '$name'
                          and Password = '$password'");
  if (!$result){
    return false;
  }

  if ($result->num_rows > 0){
    $row = $result->fetch_row();
    $_SESSION['user'] = $row[0];
    return true;
  }
  return false;
}
?>

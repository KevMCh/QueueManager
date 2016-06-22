<?php
DEFINE('DB_USERNAME', '****');
DEFINE('DB_PASSWORD', '****');
DEFINE('DB_HOST', '****');
DEFINE('DB_DATABASE', 'QueueManager');

function connectToDataBase(){
  $linkDB = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  if(!$linkDB){
    throw new Exception('Error al conectar a la base de datos');
  } else {
    return $linkDB;
  }
}
?>

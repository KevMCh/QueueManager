<?php
# Attributes to connect with the database
DEFINE('DB_USERNAME', '****');
DEFINE('DB_PASSWORD', '****');
DEFINE('DB_HOST', '****');
DEFINE('DB_DATABASE', 'QueueManager');

# Function that connects the database
function connectToDataBase(){
  $linkDB = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  if(!$linkDB){
    throw new Exception('Error al conectar a la base de datos');
  } else {
    return $linkDB;
  }
}

# Function that disconnects the database
function disconnectDataBase($conexion){
    $close = mysqli_close($conexion);
    return $close;
}
?>

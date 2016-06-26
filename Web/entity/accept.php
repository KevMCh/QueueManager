<?php
require_once ("../includes/link.php");
header('refresh:5; url=/');

$name = $_POST['name'];
$password = $_POST['password'];
$linkDB = connectToDataBase();

?>
<html lang="es">
    <head>
        <title>Queue Manager</title>
        <meta charset="UTF-8">
    </head>
<body>
  <body>
    <?php
    $queryUser = "SELECT * FROM Entitys WHERE Name = '$name'";
    $resultUser = $linkDB->query($queryUser);

    if (!$resultUser || $resultUser->num_rows == 0) {

      $sql = "INSERT INTO Entitys (Name, Password)" .
             "VALUES ('$name', '$password')";

      $result = mysqli_query($sql);

      if ($linkDB->query($sql) === TRUE) {
        echo "<h1>Bienvenido </h1>";
        echo "¡¡Ya tienes tú cuenta!!.\n";
      } else {
        echo "Error: <br>" . $linkDB->error;
      }
    } else {
      echo "El nombre de usuario ya esta ocupado";
    }
    disconnectDataBase($linkDB);
    ?>
  </body>
</body>
</html>

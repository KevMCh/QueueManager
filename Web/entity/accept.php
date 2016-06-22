<?php
require_once ("../includes/link.php");
header('refresh:5; url=/');

$name = $_POST['name'];
$password = $_POST['password'];
$linkDB = connectToDataBase();
$sql = "INSERT INTO Entitys (Name, Password)" .
       "VALUES ('$name', '$password')";

$result = mysqli_query($sql);
?>
<html lang="es">
    <head>
        <title>Queue Manager</title>
        <meta charset="UTF-8">
    </head>
<body>
  <body>
    <h1>Bienvenido </h1>
    <?php
    if ($linkDB->query($sql) === TRUE) {
      echo "¡¡Ya tienes tú cuenta!!.\n";
    } else {
      echo "Error: " . $sql . "<br>" . $linkDB->error;
    }
    ?>
  </body>
</body>
</html>

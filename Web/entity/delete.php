<?php
require_once ("../includes/link.php");
require_once ("../includes/authentication/isAuth.php");
require_once ("../includes/authentication/logout.php");
header('refresh:2; url=/');

$idEntity = $_GET['idEntity'];
$linkDB = connectToDataBase();
$sqlEntity = "DELETE FROM Entitys WHERE ID = $idEntity";
$sqlQueue = "DELETE FROM Queues WHERE IDEntity = $idEntity";
$sqlUser = "DELETE FROM UsersQueue WHERE IDQueue IN " .
           "(SELECT ID FROM Queues WHERE IDEntity = $idEntity)";

$resultUser = mysqli_query($sqlUser);
$resultQueue = mysqli_query($sqlQueue);
$resultEntity = mysqli_query($sqlEntity);
?>
<html lang="es">
    <head>
        <title>Queue Manager</title>
        <meta charset="UTF-8">
    </head>
<body>
  <body>
    <?php
    if (($linkDB->query($sqlUser) === TRUE) &&
        ($linkDB->query($sqlQueue) === TRUE) &&
        ($linkDB->query($sqlEntity) === TRUE)) {
      logout();
      echo "Cuenta elminada..\n";
    } else {
      echo "Error: <br>" . $linkDB->error;
    }
    ?>
  </body>
</body>
</html>

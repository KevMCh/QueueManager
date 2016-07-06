<?php
require_once ("../includes/link.php");
require_once ("../includes/authentication/isAuth.php");
require_once ("../includes/authentication/logout.php");
header('refresh:2; url=/');

$idEntity = $_GET['idEntity'];
$linkDB = connectToDataBase();
$sqlEntity = "DELETE FROM Entitys WHERE ID = $idEntity";
$sqlQueue = "DELETE FROM Queues WHERE IDEntity = $idEntity";
$sqlIDQueues = "SELECT ID FROM Queues WHERE IDEntity = $idEntity";
$sqlUser = "DELETE FROM UsersQueue WHERE IDQueue IN " .
           "(SELECT ID FROM Queues WHERE IDEntity = $idEntity)";

$resultUser = mysqli_query($sqlUser);

if ($result = $linkDB->query($sqlIDQueues)) {
  while ($row = $result->fetch_row()) {
    $file = "../queue/temp/" . $row[0] . ".png";
    unlink($file);
  }
}

$resultQueue = mysqli_query($sqlQueue);
$resultEntity = mysqli_query($sqlEntity);
?>
<html lang="es">
    <head>
        <title>Turn - Time</title>
        <meta charset="UTF-8">
    </head>
<body>
  <body>
    <?php
    if (($linkDB->query($sqlUser) === TRUE) &&
        ($linkDB->query($sqlQueue) === TRUE) &&
        ($linkDB->query($sqlEntity) === TRUE)) {
      logout();
      ?>
      <?php
    } else {
    ?>
      <h2>Uppss.. ¡Que vergüenza!</h2>
      <p>Nos hemos encontrado con errores en nuestro servidor,
        por favor contacta con tu administrador.</p>
      <br>
      <h4>Error:</h4>
      <br>
    <?php
      echo $linkDB -> error;
    }
    ?>
    <?php
    include ("../includes/footer.php");
    ?>
  </body>
</body>
</html>

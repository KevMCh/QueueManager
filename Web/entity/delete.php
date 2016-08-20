<?php
require_once ("../includes/link.php");
require_once ("../includes/authentication/isAuth.php");
require_once ("../includes/authentication/logout.php");
header('refresh:2; url=/');

$idEntity = $_GET['idEntity'];
$linkDB = connectToDataBase();
$sqlEntity = "DELETE FROM Entitys WHERE ID = $idEntity";
$sqlIDQueues = "SELECT ID FROM Queues WHERE IDEntity = $idEntity";

if ($result = $linkDB->query($sqlIDQueues)) {
  # Delete the files of the queue
  while ($row = $result->fetch_row()) {
    $file = "../queue/temp/" . $row[0] . ".png";
    unlink($file);
  }
}

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
    # Delete a entity
    if ($linkDB->query($sqlEntity) === TRUE) {
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

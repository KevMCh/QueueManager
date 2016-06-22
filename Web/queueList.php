<?php
require_once ("includes/link.php");
require_once ("includes/authentication/isAuth.php");
if (!isAuth()){
  header('Location: /');
}
?>
<html lang="es">
    <head>
        <title>Queue Manager</title>
        <meta charset="UTF-8">
    </head>
<body>
  <?php
  include ("includes/navBar.php");
  ?>
  <h1> Lista de colas </h1>
  <?php
  $idEntity = $_SESSION['user'];
  $linkDB = connectToDataBase();
  $query = "SELECT * FROM Queues WHERE IDEntity = $idEntity";

  if ($result = $linkDB->query($query)) {
    echo "<ul>";
    while ($row = $result->fetch_row()) {
      printf ("<li><a href='/listOfUser.php/?idQueue=%s'>%s</a></li><br>",
      $row[0], $row[2]);

      printf ("<a href='/queue/delete.php/?idQueue=%s&idEntity=%s'><button>
      Eliminar </button></a>", $row[0], $idEntity);
    }
    echo "</ul>";

    $result->close();
  }
  $linkDB->close();
  echo "<form action='/queue/createNewQueue.php' method='post'>
          <input type='hidden' name='idEntity' value=$idEntity />
          <input type='text' name='nameQueue' value='Nombre' />
          <input type='submit' value='Crear cola' />
        </form>";
  ?>
</body>
</html>

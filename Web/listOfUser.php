<?php
include ("includes/link.php");
include ("includes/authentication/isAuth.php");
if (!isAuth()){
  header('Location: /index.php');
}
?>
<html lang="es">
    <head>
        <title>Queue Manager</title>
        <meta charset="UTF-8">
    </head>
<body>
  <body>
    <?php
    include ("includes/navBar.php");
    $idQueue = $_GET['idQueue'];
    echo "<h2> QR Code </h2> <br> <img src='/newQueue/temp/$idQueue.png' />
          <h2> Usuarios en la cola </h2>";

    $linkDB = connectToDataBase();

    $queryUsers = "SELECT * FROM UsersQueue WHERE IDQueue = $idQueue";

    if ($resultUser = $linkDB -> query($queryUsers)) {

      $next = $resultUser -> fetch_row();
      while ($next[3]){
        $next = $resultUser -> fetch_row();
      }

      if($next) {
        echo "<h3>Atender: </h3>";
        printf("<b>Identificador del usuario:</b> %s <b>IDQueue:</b> %s   ", $row[2], $row[1]);
        echo "<form method='post' action='/changeStateUser.php'>
                <input type='hidden' name='idQueue' value='$row[1]'>
                <input type='hidden' name='idUser' value='$row[2]'>
                <input type='hidden' name='attended' value='$row[3]'>
                <input type='Submit' value='Atendido'>
              </form>";
      }

      $row = $resultUser -> fetch_row();
      if($row) {
        echo "<h3> Siguentes usuarios: </h3>";
        echo "<ul>";
        while ($row = $resultUser -> fetch_row()) {
          printf("<li>Identificador del usuario: %s IDQueue: %s   ",
          $row[2], $row[1]);

          if($row[3]){
            echo "Atendido";
          } else {
            echo "En espera";
          }
          echo "<form method='post' action='/changeStateUser.php'>
                  <input type='hidden' name='idQueue' value='$row[1]'>
                  <input type='hidden' name='idUser' value='$row[2]'>
                  <input type='hidden' name='attended' value='$row[3]'>
                  <input type='Submit' value='Cambiar estado'>
                </form>";
          echo "</li><br>";
        }
        echo "</ul>";
      }
      $resultUser -> close();
    }
    $linkDB->close();
    ?>
  </body>
</body>
</html>

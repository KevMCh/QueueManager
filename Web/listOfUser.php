<?php
require_once ("includes/link.php");
require_once ("includes/authentication/isAuth.php");
if (!isAuth()){
  header('Location: /');
}
?>
<html lang="es">
    <head>
      <title>Turn - Time</title>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="/includes/style.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
<body>
<?php
include ("includes/navBar.php");
$linkDB = connectToDataBase();
$idQueue = $_GET['idQueue'];
$idEntity = $_SESSION['user'];
$queryQueue = "SELECT * FROM Queues WHERE ID = $idQueue " .
              "AND IDEntity = $idEntity";

if ($resultQueue = $linkDB -> query($queryQueue)) {
  $rowQueue = $resultQueue -> fetch_row();
  echo "<h1 class='text-center'>Gestión de la cola '$rowQueue[2]'</h1><hr>";
?>

<div class="row">
  <div class="col-sm-3 col-sm-offset-1">
    <?php
    echo "<h2>Datos:</h2><hr><br><br>";
    echo "<b>Identificador: </b> $rowQueue[0]<br><br>";
    echo "<b>Name: </b> $rowQueue[2]<br><br>";
    echo "<b>Turno: </b> $rowQueue[3]<br><br>";
    ?>
    <hr>
    <form method="post" action="/queue/newTurn/attendedClient.php">
      <?php
      $idEntity = $_SESSION['user'];
      echo "<input type='hidden' name='idQueue' value='$rowQueue[0]'> " .
           "<input type='hidden' name='name' value='$rowQueue[2]'> " .
           "<input type='hidden' name='turn' value='$rowQueue[3]'> " .
           "<input type='hidden' name='idEntity' value='$idEntity'>";
      ?>
      <input type="Submit" class='button btn btn-default' name="enviar"
      value="Cliente atendido">
    </form>
    <form method="post" action="/queue/newTurn/incrementTurn.php">
      <?php
      $idEntity = $_SESSION['user'];
      echo "<input type='hidden' name='idQueue' value='$rowQueue[0]'> " .
           "<input type='hidden' name='name' value='$rowQueue[2]'> " .
           "<input type='hidden' name='turn' value='$rowQueue[3]'> " .
           "<input type='hidden' name='idEntity' value='$idEntity'>";
      ?>
      <input type="Submit" class='button btn btn-default' name="enviar"
      value="Siguiente">
    </form>
  </div>
  <div class="col-sm-3 col-sm-offset-2">
    <?php
    echo "<h2> QR Code </h2> <hr> <br>
          <img class='qrImage' src='/queue/temp/$idQueue.png'/>";
    ?>
  </div>
</div>
<br>
<hr>
<h2 class="text-center"> Usuarios en la cola </h2>
<hr>
<br>
<div class='row'>
  <div class="input-group">
    <div class='col-sm-3 col-sm-offset-1'>
      <input type="text" class="form-control" placeholder="Buscar..">
      <span class="input-group-btn">
        <button type="button" class="btn btn-default button">
          <span class="glyphicon glyphicon-search"></span>
        </button>
      </span>
    </div>
  </div>
</div>
<br>
<?php
  $queryClient = "SELECT * FROM UsersQueue WHERE IDQueue = $idQueue " .
                 "ORDER BY Position";
  if ($resultClient = $linkDB -> query($queryClient)) {
    echo "<div class='row'>
            <div class='col-sm-1 col-sm-offset-1'><b>Turno:</b><br></div>
            <div class='col-sm-2'><b>Turno de notificación al usuario:</b><br></div>
            <div class='col-sm-2'><b>Identificador del usuario:</b><br></div>
            <div class='col-sm-2'><b>Hora de creación del turno:</b><br></div>
            <div class='col-sm-2'><b>Estado del turno:</b><br></div>
          </div>
          <br>";

    while($nextClient = $resultClient -> fetch_row()) {
      echo "<div class='row'>";
      printf("<div class='col-sm-1 col-sm-offset-1'>%s</div>",
      $nextClient[0]);

      printf("<div class='col-sm-2'>%s</div>",
      $nextClient[0] - $nextClient[5]);

      printf("<div class='col-sm-2'>%s</div>",
      $nextClient[2]);

      printf("<div class='col-sm-2'>%s</div>",
      $nextClient[3]);

      echo "<div class='col-sm-2'>";
      if($nextClient[4]){

        echo "<button type='button' class='btn btn-success'>
              Atendido
              </button>";
      } else {
        echo "<button type='button' class='btn btn-warning'>
              En espera
              </button>";
      }
      echo "</div>
           <div class='col-sm-2'>";
      echo "<form method='post' action='/changeStateUser.php'>
              <input type='hidden' name='idQueue' value='$nextClient[1]'>
              <input type='hidden' name='idUser' value='$nextClient[2]'>
              <input type='hidden' name='attended' value='$nextClient[3]'>
              <input type='submit' class='btn btn-default button' value='Cambiar estado'>
              </form>";
      echo "</div>";
      echo "</div><br>";
    }
  }
} else {
?>
<div class="text-center">
<h2>Uppss.. ¡Que vergüenza!</h2>
<p>Nos hemos encontrado con errores en nuestro servidor,
  por favor contacta con tu administrador.</p>
  <br>
  <h4>Error:</h4>
  <br>
  <?php
  echo $linkDB -> error . "</div>";
}
$resultQueue -> close();
$linkDB->close();

include ("includes/footer.php");
?>
</body>
</html>

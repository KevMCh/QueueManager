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
  ?>
  <h1 class="text-center"> Listado de colas </h1>
  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav">
        <a data-toggle="popover" title="Datos para la cola" data-content="
        <?php
        $idEntity = $_SESSION['user'];
        echo "<form action='/queue/createNewQueue.php' method='post'>
                <input type='hidden' name='idEntity' value=$idEntity/>
                <input type='text' name='nameQueue' value='Nombre'/>
                <hr>
                <input type='submit' class='btn btn-default button' value='Crear' />
              </form>";
        ?>"><button type='button' class='btn btn-defaul tbutton'>Crear nueva cola
        </button></a>
        <script>
        $(document).ready(function(){
          $('[data-toggle="popover"]').popover({
            html: true
          });
        });
        </script>
        <hr>
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Buscar..">
          <span class="input-group-btn">
            <button type="button" class="btn btn-default button">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
      </div>
      <div class="col-sm-9">
        <?php
        $idEntity = $_SESSION['user'];
        $linkDB = connectToDataBase();
        $query = "SELECT * FROM Queues WHERE IDEntity = $idEntity";
        if ($result = $linkDB->query($query)) {
          echo "<div class='list-group'>";
          while ($row = $result->fetch_row()) {
          ?>
          <div class='row'>
            <div class='col-sm-6 col-sm-offset-2 queue list-group-item'>
              <?php
              printf ("<h4><a href='/listOfUser.php/?idQueue=%s'>%s</a></h4>",
                      $row[0], $row[2]);
              printf ("<a href='/queue/delete.php/?idQueue=%s&idEntity=%s'>
                      <button type='button' class='btn btn-danger'>
                      <span class='glyphicon glyphicon-remove'></span> </button>
                      </a>", $row[0], $idEntity);
              ?>
            </div>
          </div>
          <?php
          }
          ?>
          </div>
        </div>
      </div>
    </div>
    <?php
    $result->close();
  }
  $linkDB->close();
  ?>
  <?php
  include ("includes/footer.php");
  ?>
</body>
</html>

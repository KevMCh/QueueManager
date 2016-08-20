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
  <div class="container-fluid">
    <div class="row content">
      <?php
      $linkDB = connectToDataBase();
      $idEntity = $_SESSION['user'];

      # Get the details of the entity
      $queryNameEntity = "SELECT * FROM Entitys WHERE ID = '$idEntity'";
      $resultEntity = mysqli_query($linkDB, $queryNameEntity);
      $rowEntity = mysqli_fetch_array($resultEntity);

      printf ("<h1 class='text-center'>%s</h1>", $rowEntity[1]);
      ?>
      <div class='row'>
        <div class='col-sm-9 col-sm-offset-1 queue list-group-item'>
            <div class='col-sm-4'>
              <?php
              printf ("<img src='%s' class='profileImage' alt='profile image'>",
                      $rowEntity[6]);
              ?>
            </div>
            <div class='col-sm-7 col-sm-offset-1 list-group-item'>
              <ul>
                <?php
                printf ("<li><b> Dirección:</b><br> %s </li><br>", $rowEntity[4]);
                printf ("<li><b> Número de contacto:</b><br> %s</li><br>",
                        $rowEntity[3]);
                printf ("<li><b> Descripción de la empresa:</b><br>%s</li><br>",
                        $rowEntity[5]);
                ?>
              </ul>
            </div>
        </div>
      </div>
    </div>
  </div>
  <h2 class="text-center"> Listado de colas </h2>
  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav">
        <a data-toggle="popover" title="Datos para la cola" data-content="
        <?php
        # Form to create a new queue
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
        # Show list of queues
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

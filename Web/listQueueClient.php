<?php
require_once ("includes/link.php");
require_once ("includes/authentication/isAuth.php");
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
  <h1 class="text-center"> Listado de colas </h1>
  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav">
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
        # Show all queues
        $linkDB = connectToDataBase();
        $query = "SELECT * FROM Queues";
        if ($result = $linkDB->query($query)) {
          echo "<div class='list-group'>";
          while ($row = $result->fetch_row()) {
          ?>
          <div class='row'>
            <div class='col-sm-6 col-sm-offset-2 queue list-group-item'>
              <?php

              # Get the name of the entity
              $idEntity = $row[1];
              $queryNameEntity = "SELECT * FROM Entitys WHERE ID = '$idEntity'";
              $resultEntity = mysqli_query($linkDB, $queryNameEntity);
              $rowEntity = mysqli_fetch_array($resultEntity);
              $nameEntity = $rowEntity[1];

              printf ("<h4>%s <small>(Establecimiento: %s)</small> </h4>",
                       $row[2], $nameEntity);
              printf ("<a href='queue/generateTicket.php?idQueue=%s&idEntity=%s'>
                      <button type='button' class='btn btn-warning'>
                      Coger número
                      </button>
                      </a>", $row[0], $row[1]);
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

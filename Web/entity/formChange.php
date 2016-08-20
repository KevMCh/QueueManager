<?php
# Get the name of the entity
$queryNameEntity = "SELECT * FROM Entitys WHERE ID = '$idEntity'";
$resultEntity = mysqli_query($linkDB, $queryNameEntity);
$rowEntity = mysqli_fetch_array($resultEntity);
?>
<h1 class="text-center">Cambiar datos </h1>
<form class="login" method="post" action="/entity/changeData.php">
  Nombre:
  <br>
  <?php
  printf("<input type='text' name='name' value='%s'>", $rowEntity[1]);
  ?>
  <br><br>
  Contraseña antigüa:
  <br>
  <input type='password' name='oldPassword'>
  <br>
  Contraseña nueva:
  <br>
  <input type='password' name='newPassword'>
  <br><br>
  Número de contacto:
  <br>
  <?php
  printf("<input type='contactNumber' name='contactNumber' value='%s'>",
         $rowEntity[3]);
  ?>
  <br><br>
  Dirección:
  <br>
  <?php
  printf("<input type='address' name='address' value='%s'>", $rowEntity[4]);
  ?>
  <br><br>
  Breve descripción de la empresa:
  <br>
  <?php
  printf("<input type='companyDescription' name='companyDescription' value='%s'>",
          $rowEntity[5]);
  ?>
  <br><br>
  URL de la imagen de perfil:
  <br>
  <?php
  printf("<input type='urlImage' name='urlImage' value='%s'>",
          $rowEntity[6]);
  ?>
  <br><br><br>

  <input type="Submit" class='button btn btn-default' name="enviar"
  value="Aceptar información">
</form>

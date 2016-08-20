<?php
require_once ("../includes/authentication/isAuth.php");
require_once ("../includes/link.php");
require_once ("../includes/authentication/login.php");
if (!isAuth()){
  header('Location: /');
}

$linkDB = connectToDataBase();
$idEntity = $_SESSION['user'];

if($_POST) {
  if(!empty($_POST['name']) && !empty($_POST['oldPassword']) &&
     !empty($_POST['contactNumber']) && !empty($_POST['address']) &&
     !empty($_POST['companyDescription']) && !empty($_POST['urlImage']) &&
     !empty($_POST['newPassword'])) {

       $queryUser = "SELECT * FROM Entitys WHERE ID = '$idEntity'";
       $resultUser = $linkDB->query($queryUser);
       $rowUser = mysqli_fetch_array($resultUser);

       $oldPassword = $_POST['oldPassword'];

       if($oldPassword == $rowUser[2]) {

         $name = $_POST['name'];
         $newPassword = $_POST['newPassword'];
         $contactNumber = $_POST['contactNumber'];
         $address = $_POST['address'];
         $companyDescription = $_POST['companyDescription'];
         $urlImage = $_POST['urlImage'];

         # Check is the name is used
         $queryExistUser = "SELECT * FROM Entitys WHERE Name = '$name'";
         $resultExistUser = $linkDB->query($queryExistUser);
         $rowExistUser = mysqli_fetch_array($resultExistUser);
         if ((!$resultExistUser || $resultExistUser->num_rows == 0) ||
             ($rowUser[1] == $name)) {

           # Create a user
           $sql = "UPDATE Entitys SET Name = '$name', Password = '$newPassword', " .
                  "ContactNumber = '$contactNumber', Address = '$address', " .
                  "CompanyDescription = '$companyDescription', URLImage = '$urlImage' " .
                  "WHERE ID = '$idEntity'";

           $result = mysqli_query($sql);
           if ($linkDB -> query($sql) === TRUE) {
             login($name, $password);
             header('Location: /');
             exit;
           } else {
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
             <body class="text-center">
               <h2>Uppss.. ¡Que vergüenza!</h2>
               <p>Nos hemos encontrado con errores en nuestro servidor,
                  por favor contacta con tu administrador.</p>
               <br>
               <h4>Error:</h4>
               <br>
           <?php
               echo $linkDB -> error;
             }
           } else {
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
             <body class="text-center">
             <h3 class="error">Lo sentimos, el nombre de usuario que ha escogido
                               ya esta ocupado</h3>
             <?php
             include('formChange.php');
           }
           disconnectDataBase($linkDB);

           } else {
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
             <body class="text-center">
             <?php
           echo '<h3 class="error">Contraseña incorrecta</h3>';
           include('formChange.php');
           }
         } else {
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
           <body class="text-center">
           <?php
         echo '<h3 class="error">Rellene todos los campos de texto</h3>';
         include('formChange.php');
         }

  } else {
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
    <body class="text-center">
    <?php
  include('formChange.php');
  }
  include ("../includes/footer.php");
  ?>
</body class="text-center">
</html>

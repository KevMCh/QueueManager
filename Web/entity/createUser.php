<?php
require_once ("../includes/authentication/isAuth.php");
require_once ("../includes/link.php");
require_once ("../includes/authentication/login.php");

if($_POST) {
  if(!empty($_POST['name']) && !empty($_POST['password']) &&
     !empty($_POST['contactNumber']) && !empty($_POST['address']) &&
     !empty($_POST['companyDescription']) && !empty($_POST['urlImage'])) {

    $name = $_POST['name'];
    $password = $_POST['password'];
    $contactNumber = $_POST['contactNumber'];
    $address = $_POST['address'];
    $companyDescription = $_POST['companyDescription'];
    $urlImage = $_POST['urlImage'];
    $linkDB = connectToDataBase();

    # Check is the name is used
    $queryUser = "SELECT * FROM Entitys WHERE Name = '$name'";
    $resultUser = $linkDB->query($queryUser);
    if (!$resultUser || $resultUser->num_rows == 0) {

      # Create a user
      $sql = "INSERT INTO Entitys (Name, Password, ContactNumber, Address, " .
             "CompanyDescription, URLImage) VALUES ('$name', '$password', " .
             "'$contactNumber', '$address', '$companyDescription', " .
             "'$urlImage')";

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
        include('form.php');
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
    echo '<h3 class="error">Rellene todos los campos de texto</h3>';
    include('form.php');
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
  include('form.php');
  }
  include ("../includes/footer.php");
  ?>
</body class="text-center">
</html>

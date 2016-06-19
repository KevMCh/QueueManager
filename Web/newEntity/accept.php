<?php
include ("/includes/link.php");
?>
<html lang="es">
    <head>
        <title>Queue Manager</title>
        <meta charset="UTF-8">
    </head>
<body>
  <body>
    <h1>Bienvenido </h1>
    <?php
    $name = $_POST['name'];
    $password = $_POST['password'];
    $sql = "INSERT INTO Entitys (Name, Password)" .
     "VALUES ('$name', '$password')";
    $result = mysqli_query($sql);

    if ($linkDB->query($sql) === TRUE) {
        echo "¡¡Ya tienes tú cuenta!!.\n";
    } else {
        echo "Error: " . $sql . "<br>" . $linkDB->error;
    }
    ?>
  </body>
</body>
</html>

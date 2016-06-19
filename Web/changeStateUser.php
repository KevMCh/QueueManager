<?php
include ("includes/link.php");
include ("includes/authentication/isAuth.php");

if (!isAuth()){
  header('Location: /');
}

$idQueue = $_POST['idQueue'];
$idUser = $_POST['idUser'];
$attended = $_POST['attended'];

$newState = !($attended);

$linkDB = connectToDataBase();
$query = "UPDATE UsersQueue SET Attended = '$newState'
          WHERE IDQueue = '$idQueue' AND IDUser = '$idUser'
          AND Attended = '$attended'";

if ($linkDB->query($query) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $linkDB->error;
  exit;
}
header('Location: /listOfUser.php/?idQueue=%s');
?>

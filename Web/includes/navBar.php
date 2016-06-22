<?php
echo "<a href='/includes/authentication/logout.php'> <button> Cerrar sesión </button></a>";
$user = $_SESSION['user'];
echo "<a href='/entity/delete.php/?idEntity=$user'> <button> Eliminar cuenta </button></a>";
?>

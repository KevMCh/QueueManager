<?php
include ("isAuth.php");
if (isAuth()) {
  if (!isset($_SESSION)){
    session_start();
  }

  unset($_SESSION['user']);
  session_destroy();
  echo 'Sesión cerrada. <a href="/">Iniciar nueva sesión</a>';

} else {
  echo 'Error: No existe ninguna sesión activa.';
}
?>

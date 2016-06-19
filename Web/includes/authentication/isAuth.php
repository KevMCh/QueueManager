<?php
function isAuth(){
  if (!isset($_SESSION) ){
    session_start();
  }
  if (isset($_SESSION['user'])){
    return true;
  } else {
    return false;
  }
}
?>

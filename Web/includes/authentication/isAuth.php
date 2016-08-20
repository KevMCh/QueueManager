<?php
# Function checks if there is an authenticated user
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

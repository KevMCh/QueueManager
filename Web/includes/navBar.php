<nav id="navbar" class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <a class="navbar-brand" href="/">
      <img src="/includes/logo.png" alt="logo" height="50" width="50">
    </a>
  </div>
  <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="/">Inicio</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
          Settings <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <?php
          $user = $_SESSION['user'];
          echo "<li><a href='/entity/delete.php/?idEntity=$user'>Eliminar cuenta</a></li>";
          ?>
        </ul>
      </li>
      <li><a href='/includes/authentication/logout.php'>Cerrar sesión</a></li>
    </ul>
  </div>
</nav>

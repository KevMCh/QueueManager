<nav id="navbar" class="navbar navbar-default" role="navigation">
  <div class="navbar-header logo">
    <a class="navbar-brand" href="/">
      <img  src="/includes/logo.png" alt="logo" height="50" width="50">
    </a>
  </div>

  <div class="navbar-header logo">
    <h3> Turn - Time <small>Gestión de turnos online</small></h3>
  </div>

  <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="/">Inicio</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
          Settings <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li>
            <a href='/entity/changeData.php'>
              <span class="glyphicon glyphicon-cog">
                Cambiar datos
              </span>
            </a>
          </li>
          <li role="separator" class="divider"></li>
          <li>
            <?php
            $user = $_SESSION['user'];
            echo "<li>
                    <a href='/entity/delete.php/?idEntity=$user'>
                      <span class='glyphicon glyphicon-exclamation-sign error'>
                        Eliminar cuenta
                      </span>
                    </a>
                  </li>";
            ?>
          </li>
        </ul>
      </li>
      <li><a href='/includes/authentication/logout.php'>Cerrar sesión</a></li>
    </ul>
  </div>
</nav>

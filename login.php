<!DOCTYPE html>
<!--Apartado visual del login -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/all.min.css">
    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="bootstrap/bootstrap.bundle.min.js"></script>
    <title>CAPITALS</title>
</head>
<body>
    <?php
    
    ?>
     <p><center>Bienvenido</center></p>
    <div class="container">
        <div class="row m-5 no-gutters shadow-lg">
            <div class="col-md-6 d-none d-md-block">
                <img src="img/logo.png">
               </div>
            <div class="col-md-6 bg-white p-5">
                <h3 class="pb-3">Iniciar sesión</h3>
                <div>

                    <form action="login2_iniciar_sesion.php" method="post">
                        <div class="form-group pb-3">
                           <p>Usuario:</p> <input type="text" placeholder="Igresar Usuario" class="form-control" name="usuario" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group pb-3">
                          <p>Contraseña</p>  <input type="password" placeholder="Ingresar Contraseña" class="form-control" name="password" id="exampleInputPassword1">
                        </div>

                          
                        <div class="pb-2">
                            <button type="submit" name="ingresar" class="btn btn-success">Iniciar sesion</button>
                        </div>

                
                        <a class="btn btn-success" href="agregar_usuario.php" role="button" >Crear cuenta</a>
                    </form>
                    <ul class="nav nav-pills">
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Usuario</a>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="login.php">Vendedor</a></li>
      <li><a class="dropdown-item" href="login2.php">Admin</a></li>
    
    </ul>
  </li> 
</ul>  
                </div>
            </div>
        </div>
    </div>  




</body>
</html>

<?php  
    
    session_start();
    $idTipoUsuario = $_SESSION['rol'];
     ?>




<!DOCTYPE html>
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
    <link rel="stylesheet" href="CSS/intento.css">
  
</head>
<body>

<?php if ($idTipoUsuario == 1) { ?>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
  <img src="img/letras.png" width=300px high=200px align="left">	

  <!--Informaciòn basica -->
    <a class="btn btn-success" href="login.php role="button" >Inicio</a>

<!--Cargar los productos -->
<a class="btn btn-success" href="index_producto.php" role="button" >Ventas</a>

 <!--Informacion de los productos -->
<a class="btn btn-success" href="agregar_producto.php" role="button" >Productos</a>


 <!--Apartado Usuarios  -->
 <a class="btn btn-success" href="agregar_usuario.php" role="button" >Crear usuarios</a>

  <!--Apartado Usuarios  -->
  <a class="btn btn-success" href="index_usuario.php" role="button" >Usuarios</a>

<!--Creación de clientes-->
<a class="btn btn-success" href="agregar_cliente.php" role="button" >Crear clientes</a>


<!--Disponibilidad de los productos -->
<a class="btn btn-success" href="" role="button" >Inventario</a>

<!--Cuanto y que productos hay -->
<a class="btn btn-success" href="" role="button" >Reportes</a>

<!--Cambiar la contraseña-->
<a class="btn btn-success" href="editar_usuario.php" role="button" >Cambiar la contraseña</a>

<!--Crerrar sesion  -->
<a class="btn btn-success" href="logoutad.php" role="button" >Cerrar sesion</a>
  </div>
</nav>


<?php } else { ?>
    <nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
  <img src="img/letras.png" width=300px high=200px align="left">	

  <!--Informaciòn basica -->
    <a class="btn btn-success" href="login.php" role="button" >Inicio</a>

<!--Cargar los productos -->
<a class="btn btn-success" href="index_producto.php" role="button" >Ventas</a>

 <!--Informacion de los productos -->
<a class="btn btn-success" href="agregar_producto.php" role="button" >Productos</a>

 <!--Editar Producto -->
 <a class="btn btn-success" href="editar_producto.php" role="button" >Editar Productos</a>

 <!--Apartado Usuarios  -->
 <a class="btn btn-success" href="agregar_usuario.php" role="button" >Crear usuarios</a>

  <!--Apartado Usuarios  -->
  <a class="btn btn-success" href="index_usuario.php" role="button" >Usuarios</a>

<!--Edicion de clientes-->
<a class="btn btn-success" href="editar_usuario.php" role="button" >Editar Usuario</a>

<!--Creación de clientes-->
<a class="btn btn-success" href="agregar_cliente.php" role="button" >Crear clientes</a>

<!--Clientes de alta-->
<a class="btn btn-success" href="clientesalta.php" role="button" >Clientes</a>

 <!--Editar Cliente -->
 <a class="btn btn-success" href="editar_cliente.php" role="button" >Editar Clientes</a>


<!--Cambiar la contraseña-->
<a class="btn btn-success" href="" role="button" >Cambiar la contraseña</a>

<!--Crerrar sesion  -->
<a class="btn btn-success" href="logoutad.php" role="button" >Cerrar sesion</a>
  </div>
</nav>
    

    <?php } ?>
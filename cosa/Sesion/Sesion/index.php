<?php

$mysqli = new mysqli("localhost", "root", "", "proyecto");//CONEXION A BASE DE DATOS
session_start();

if ($_POST) { //va a guardar lo que lleve en método post
    $curp = $_POST['curp']; //ACA ES PARA QUE LO DEL FORMULARIO SE GUARDE EN UNA VARIABLE 
    $password = $_POST['password'];//ACA ES PARA QUE LO DEL FORMULARIO SE GUARDE EN UNA VARIABLE 

    $sql = "SELECT `datosGenerales`.`Nombre`, `usuarios`.`CURP`, `usuarios`.`CONTRASEÑA` FROM `datosGenerales`, `usuarios` where `datosGenerales`.`CURP`='$curp' and `usuarios`.`CURP`= '$curp';"; 
//ACA ES SELECCIONAR, PRIMERO VA EL NOMBRE DE BASE DE DATOS Y DESPUES EL LOCAL 
    
    $resultado = $mysqli->query($sql);//METES EN UNA VARIABLE LO DE MYSQLI
    $num = $resultado->num_rows;

    if ($num > 0) {//si hay màs de un resultado asi 
        $row = $resultado->fetch_assoc();
        $password_bd = $row['CONTRASEÑA']; //aqui haces que le tome prioridad al apartado de contraseña
  

        if ($password_bd == $password) { //si la contraseña de base de datos es igual a la de formulario
            $_SESSION['nombre']=$row['Nombre'];//consigues el nombre y la guardas 
            header("Location: mensaje.php"); //si puedes iniciar sesión te manda a esto que es el mensaje
 
        }
        else{
           
echo'<script type="text/javascript"> alert("contraseña incorrecta"); window.location.href="index.php";</script>';
        //si la contraseña no es igual muestra un alert que dice contraseña incorrecta
}
    } 
        else{
            echo"NO EXISTE USUARIO";//en caso de que no se encuentre el usuario
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-info">

<form method="POST" action=""> <!--generas un metodo POST--> 

<div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4"><b>
                                            <h3>Proyecto </h3>
                                        </b>LOGIN
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Curp</label><input class="form-control py-4" id="curp" name="curp" type="text" placeholder="Ingresa tu curp" /></div> <!--generas un label para curp--> 
                                        <div class="form-group"><label class="small mb-1" for="inputPassword">Password</label><input class="form-control py-4" id="password" name="password" type="password" placeholder="Ingresa tu contraseña" /></div><!--generas un label para contraseña--> 
                                        <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button type="submit" class="btn btn-outline-primary">Login</button> <!--creas un boton--> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

</form>

</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
</html>
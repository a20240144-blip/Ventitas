<?php

$mysqli = new mysqli("localhost", "root", "", "examen");//CONEXION A BASE DE DATOS
session_start();

if ($_POST) { //va a guardar lo que lleve en método post
    $nombrep=$_POST['nombrep']; //ACA ES PARA QUE LO DEL FORMULARIO SE GUARDE EN UNA VARIABLE 
   
    $sql = "SELECT `datosgenerales`.`Apellidos`, `datoshijo`.`Nombreh` FROM `datosgenerales`, `datoshijo` where `datosgenerales`.`Apellidos`='$nombrep'"; 

    
    $resultado = $mysqli->query($sql);//METES EN UNA VARIABLE LO DE MYSQLI
    $num = $resultado->num_rows;


    if ($num > 0) {//si hay màs de un resultado asi 
        $row = $resultado->fetch_assoc();
       $nombreh_bd=$row['Nombreh'];
     echo "Tú hijo es:".$nombreh_bd;
  
    }

    else{
        echo "no hay hijos";
    }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombre de hijo</title>
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
                                        </b>Examen
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                       <div class="form-group"><label class="small mb-1" for="inputPassword">Nombre papá</label><input class="form-control py-4" id="nombrep" name="nombrep" type="nombrep" placeholder="Ingresa tu nombre Papá" /></div><!--generas un label para contraseña--> 
                                        
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
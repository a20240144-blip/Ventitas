<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar</title>
</head>
<body>
<form action="Formulario.html" method="POST">
<?php

$mostrar=1;
if(isset($_POST["button"])){

    //recibir datos
   
   
 //ESTA PARTE DEL CODIGO TE DICE SI ERES MAYOR DE EDAD
 
 

$curp=$_POST["curp"];

$password=$_POST["password"];
$ds=(int)$password;


if($curp==""){
    echo ("Te fala agregar tu curp");
    echo ("<br>");
}


echo ("Tu nombre es:".$curp);
echo ("<br>");
echo ("Tu password es:".$password);
echo ("<br>");






}

?>
<button name="button2" >Datos confirmados</button>
</body>
</html>
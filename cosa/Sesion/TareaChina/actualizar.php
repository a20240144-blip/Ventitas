<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios</title>
</head>
<body>
<?php 
    include ("conexion.php");
    $query="SELECT * FROM datosgenerales WHERE id=:id";    
    $gsentence=$conexion->prepare($query);
    $gsentence->bindParam(":id",$_GET["id"]);
    $gsentence->execute(); 
    $row = $gsentence->fetch();
?>
    <h1>Formulario para modificar Datos Generales</h1>
    <form action="confirmarActualizar.php" method="POST">
        <label for="id">Id:</label>
        <input type="text" name="id" value="<?php echo $row["id"]; ?>" readonly><br>
        <label for="name">Nombre:</label>
        <input type="text" name="name" value="<?php echo $row["nombre"]; ?>"><br>
        <label for="lastName">Apellidos:</label>
        <input type="text" name="lastName" value="<?php echo $row["apellidos"]; ?>"><br>
        <label for="sex">Sexo:</label>
        <input type="text" name="sex" value="<?php echo $row["sexo"]; ?>"><br>
        <button name="updateButton">Actualizar</button>
    </form>
        <?php           
            $conexion=null;
        ?>            
</body>
</html>
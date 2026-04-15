<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Registros</title>
</head>
<body>
    <?php 
        if (isset($_POST["insert"])){
            //Obtener datos para ser agregados
            $name = $_POST["name"];
            $lastname = $_POST["lastname"];
            $sex = $_POST["sex"];
            //Establecer la conexión a la BD
            include("conexion.php");
            //Generar la consulta
            $query="INSERT INTO datosgenerales (sexo,apellidos,nombre) VALUES (:sexo,:apellidos,:nombre)";
            $gsentence=$conexion->prepare($query);
            $gsentence->bindParam(":sexo",$sex);
            $gsentence->bindParam(":apellidos",$lastname);
            $gsentence->bindParam(":nombre",$name);
            $gsentence->execute();
            header("Location: principal.php");
            $conexion=null;
        }
    ?>
    <form action="insertar.php" method="POST">
        <label for="name">Nombre:</label>
        <input type="text" name="name">
        <label for="lastname">Apellidos: </label>
        <input type="text" name="lastname">
        <select name="sex">
            <option value="H">Hombre</option>
            <option value="M">Mujer</option>            
        </select>
        <button name="insert">Agregar</button>
    </form>
</body>
</html>
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
    $query="SELECT * FROM datosgenerales";
    $gsentence=$conexion->prepare($query);
    $gsentence->execute(); 
?>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Sexo</th>
            <th>Acciones</th>
        </tr>
        <?php 
            while ($row = $gsentence->fetch()){
                echo "<tr>";
                echo "<td>".$row["nombre"]."</td>";
                echo "<td>".$row["apellidos"]."</td>";
                echo "<td>".$row["sexo"]."</td>";
                echo "<td><a href=confirmarEliminar.php?id=".$row["id"].">Eliminar</a>|<a href=actualizar.php?id=".$row["id"].">Modificar</a></td>";
                echo "</tr>";
            } //Cierre de ciclo WHILE
            $conexion=null;
        ?>        
    </table>

<br><br>
<button type="button" id="boton" onclick="accionPDF()">Descargar PDF</button>

<script>
  function accionPDF(){
    window.location.href = 'pdf.php';
  }
</script>

</body>
</html>
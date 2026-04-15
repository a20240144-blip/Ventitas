<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAPITALS</title>
    <link rel="stylesheet" href="CSS/estilo.css">
</head>
<body>
    
<?php

session_start();
session_destroy();
session_regenerate_id();
session_unset();
header("Location:login.php");

?>

</body>
</html>
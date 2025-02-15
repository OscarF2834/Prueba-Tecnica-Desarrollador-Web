/* Aqui lo que se hara es la conexion con la base de datos
ponemos, los parametros de host, user, password y el nombre de
la base de datos
*/ 

<?php
$host = "localhost";
$user = "root"; 
$password = "";
$dbname = "tareas_db";

/* condicional que permite mostrar cuando la conexion no se pueda dar */
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

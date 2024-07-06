<?php
require __DIR__ . '/../config/variables.php';

$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    die("<p>No existen autos</p>");
}

$sql = "SELECT placa, marca, modelo, color FROM $table_name";
$result = $conn->query($sql);

return $result;
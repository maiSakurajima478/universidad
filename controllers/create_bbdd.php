<?php

require "../config/variables.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SHOW DATABASES LIKE '".$db_name."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('La base de datos ya existe'); window.history.back();</script>";
    } else {
        $sql = "CREATE DATABASE ".$db_name;
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Base de datos \'$db_name\' creada exitosamente'); window.history.back();</script>";
        } else {
            echo "<script>alert('Error al crear la base de datos: " . $conn->error . "'); window.history.back();</script>";
        }
    }
    $conn->close();
}
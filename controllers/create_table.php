<?php

require "../config/variables.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SHOW DATABASES LIKE '" . $conn->real_escape_string($db_name) . "'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "<script>alert('La base de datos no existe'); window.history.back();</script>";
    } else {
        $conn->select_db($db_name);

        $sql = "SHOW TABLES LIKE '" . $conn->real_escape_string($table_name) . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<script>alert('La tabla ya existe'); window.history.back();</script>";
        } else {

            $table_structure = "
                placa VARCHAR(6) PRIMARY KEY NOT NULL,
                marca VARCHAR(15) NOT NULL,
                modelo INT NOT NULL,
                color VARCHAR(10) NOT NULL
            ";

            $sql = "CREATE TABLE " . $conn->real_escape_string($table_name) . " (" . $table_structure . ")";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Tabla \'$table_name\' creada exitosamente'); window.history.back();</script>";
            } else {
                echo "<script>alert('Error al crear la tabla: " . $conn->error . "'); window.history.back();</script>";
            }
        }
    }

    $conn->close();
}
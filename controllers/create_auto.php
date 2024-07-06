<?php
require "../config/variables.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $db_name = $conn->real_escape_string($db_name);
    $table_name = $conn->real_escape_string($table_name);

    $sql = "SHOW DATABASES LIKE '$db_name'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 0) {
        echo "<script>alert('La base de datos no existe'); window.history.back();</script>";
    } else {
        $conn->select_db($db_name);
        $sql = "SHOW TABLES LIKE '$table_name'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            echo "<script>alert('La tabla no existe, crea la tabla primero'); window.history.back();</script>";
        } else {
            $placa = $conn->real_escape_string($_POST['placa']);
            $sql_check_placa = "SELECT placa FROM $table_name WHERE placa = '$placa'";
            $result_check_placa = $conn->query($sql_check_placa);

            if ($result_check_placa->num_rows > 0) {
                echo "<script>alert('La placa \'$placa\' ya existe en la tabla'); window.history.back();</script>";
            } else {
                $marca = $conn->real_escape_string($_POST['marca']);
                $modelo = intval($_POST['modelo']);
                $color = $conn->real_escape_string($_POST['color']);
                
                if (!preg_match("/^[A-Za-z]{3}[0-9]{3}$/", $placa)) {
                    echo "<script>alert('La placa debe comenzar con 3 letras seguidas de 3 números'); window.history.back();</script>";
                }
                else if (!preg_match("/^[0-9]{4}$/", $_POST['modelo'])) {
                    echo "<script>alert('El modelo debe contener exactamente 4 números'); window.history.back();</script>";
                }
                else if (!preg_match("/^[A-Za-z]+$/", $color)) {
                    echo "<script>alert('El color debe contener solo letras'); window.history.back();</script>";
                } else {
                    $sql_insert = "INSERT INTO $table_name (placa, marca, modelo, color) VALUES ('$placa', '$marca', $modelo, '$color')";
                    if ($conn->query($sql_insert) === TRUE) {
                        echo "<script>alert('Dato insertado correctamente'); window.location.href = '../index.php';</script>";
                    } else {
                        echo "<script>alert('Error al insertar dato: " . $conn->error . "'); window.history.back();</script>";
                    }
                }
            }
        }
    }

    $conn->close();
}
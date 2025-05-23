<?php
$servername = "localhost";
$username = "dbadmin"; // Замените на имя пользователя MySQL
$password = "Pasta007"; // Замените на пароль MySQL
$dbname = "minecraft_users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php

$server_name = 'localhost:8889';
$username = 'root';
$password = 'root';
$database = 'MenuRamah';

$conn = new mysqli($server_name, $username, $password, $database);

if ($conn->connect_error) {
    echo "<script> console.log('dbhandler encountered a fatal error')</script>";
    die('Connection failed: ' .  $conn->connect_error);
} else {
    echo "<script> console.log('PHP: dbhandler successfully connected')</script>";
}
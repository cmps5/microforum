<?php

// create database
include 'config.php';

$connection = new PDO("mysql:host=$host", $user, $db_password);
$engine = $connection->prepare(
    "CREATE DATABASE IF NOT EXISTS $data_base
    DEFAULT CHARACTER SET utf8mb4"
);
$engine->execute();
$connection = null;

echo '<p>Database created successfully</p><hr>';

?>
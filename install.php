<?php

// create database
include 'config.php';

$connection = new PDO("mysql:host=$host", $user, $db_password);
$engine = $connection->prepare(
    "CREATE DATABASE IF NOT EXISTS $data_base
    DEFAULT CHARACTER SET utf8"
);
$engine->execute();
$connection = null;

echo '<p>Database created successfully</p><hr>';

/**
 * Create tables
 */

// users table
$connection = new PDO("mysql:host=$host;dbname=$data_base;charset=utf8", $user, $db_password);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255)
)";

$engine = $connection->prepare($sql);
$engine->execute();

echo "<p>Table 'users' created successfully</p><hr>";

?>
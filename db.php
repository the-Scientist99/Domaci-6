<?php

$dbconn = mysqli_connect("localhost", "root", "", "nekretnina_db");

$dsn = "mysql:host=localhost;dbname=nekretnina_db";
$user = "root";
$pass = "";

$pdo = new PDO($dsn, $user, $pass);

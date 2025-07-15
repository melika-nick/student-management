<?php
// run this file only one time to create an default user(username: admin, pass:1234)

require_once './Database.php';

$db = new Database();
$conn = $db->connect();

$username = "admin";
$password = password_hash("1234", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, 'admin')";
$stmt = $conn->prepare($sql);
$stmt->execute(['username' => $username, 'password' => $password]);

echo "default user created";
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$remember = isset($_POST['remember']);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=student_db;charset=utf8", 'root', '1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo -> prepare($sql);
    $stmt->execute([
        ':username'=>$username,
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user && password_verify($password, $user['password'])){
        $_SESSION['user']=[
            'id'=>$user['id'],
            'username'=>$user['username'],
            'role' =>$user['role']
        ];
        if ($remember) {
            setcookie('remember_user', $user['username'], time() + (86400 * 30), "/");
        }
        header('Location: ./dashboard.php');
    }else{
        header('Location: ./login.php');
    }
    exit();
}catch (PDOException $e){
    die("login error " . $e->getMessage());
}
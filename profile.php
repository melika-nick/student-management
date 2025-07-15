<?php
require_once './Database.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}
try{
    $message = '';
    $userId = $_SESSION['user']['id'];
    $current_pass = trim(isset($_POST['current_pass']) ?? '');
    $new_pass = trim(isset($_POST['new_pass']) ?? '');
    $confirm_pass = trim(isset($_POST['confirm_pass']) ?? '');
    $db = new Database();
    $pdo = $db -> connect();
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute(['id'=> $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user || !password_verify($current_pass, $user['password'])) {
        $message = '❌ Current password is incorrect.';
    } elseif (strlen($new_pass) < 4) {
        $message = '❌ New password must be at least 4 characters.';
    } elseif ($new_pass !== $confirm_pass) {
        $message = '❌ Password confirmation does not match.';
    } else {
        // hash new password and save it
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->execute(['password' => $newHashedPassword, 'id' => $userId]);
        $message = '✅ Password changed successfully.';
    }
}catch(PDOException $e){
    die('database connection error'. $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>change password</title>
</head>
<body>
    <h2>change password <br></h2>
    <?php if($message): ?>
        <p><? $message ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label name="current_pass">current password</label>
        <input type="password" name = "current_pass">
        <br><br>
        <label name="new_pass">new password</label>
        <input type="password" name="new_pass">
        <br><br>
        <label name="confirm_pass">confirm password</label>
        <input type="password" name="confirm_pass">
        <br><br>
        <button type="submit">change password</button>
        <a href="./dashboard.php">go back to dashboard</a>
    </form>
</body>
</html>
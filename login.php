<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="check_login.php" method="post">
        <h2>Member Login Form</h2>
        <label>Username</label>
        <input type="text" name="username" required>
        <br><br>
        <label>Password</label>
        <input type="password" name="password" required>
        <br><br>
        <label><input type="checkbox" name="remember">Remember Me</label>
        <br><br>
        <button type="submit">Login</button>
        <a href="./logout.php">Logout</a>
    </form>
</body>
</html>

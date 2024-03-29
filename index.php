<?php
include 'config.php';
session_start();

if (isset($_SESSION['username'])) {
    header("Location: home.php");
}

if (isset($_POST['submit'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $query_sql = "SELECT * FROM users WHERE username = :username AND password = :password";

    $stmt = $db->prepare($query_sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['username'] = $username; // Misalkan username disimpan sebagai username
        header("Location: home.php");
    } else {
        echo "<center><h1> username atau Password Anda Salah. Silahkan Coba Login Kembali.</h1>
            <button><strong><a href='index.php'>Login</a></strong></button></center>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <form action="" method="POST" class="login-email">
        <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
        <div class="input-group">
            <input type="username" placeholder="username" name="username" value="<?php echo isset($username) ? $username : ''; ?>"
                   required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Password" name="password"
                   value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" required>
        </div>
        <div class="input-group">
            <button name="submit" class="btn">Login</button>
        </div>
        <p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
    </form>
</div>
</body>
</html>
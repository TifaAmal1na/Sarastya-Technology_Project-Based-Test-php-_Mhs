<?php
include 'config.php';

error_reporting(0);

session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

// Memeriksa apakah form telah disubmit
if(isset($_POST['submit'])){
    // Mengambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menyiapkan statement SQL UPDATE
    $stmt = $db->prepare("UPDATE users SET username=?, email=?, password=? WHERE username=?");
    // Mengikat parameter ke placeholder dalam statement SQL
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $password);
    $stmt->bindParam(4, $_SESSION['username']);

    // Menjalankan kueri SQL
    if($stmt->execute()){
        $_SESSION['username'] = $username; // Mengupdate session jika username berubah
        echo '<script>alert("Data berhasil diperbarui."); window.location.href = "home.php";</script>';
        exit(); // Menghentikan eksekusi skrip setelah mengarahkan
    } else {
        echo '<script>alert("Gagal memperbarui data.");</script>';
    }
}

// Mengambil informasi pengguna dari database
$stmt = $db->prepare("SELECT * FROM users WHERE username=?");
$stmt->bindParam(1, $_SESSION['username']);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="style.css">

    <title>Edit Profile</title>
</head>
<body style="background-image: 2.jpg;">
    <div class="container">
        <form action="edit.php" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Edit Profile</p>
            <div class="input-group">
                <input type="text" placeholder="Username" name="username" value="<?php echo $userData['username']; ?>" required>
            </div>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" value="<?php echo $userData['email']; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" value="<?php echo $userData['password']; ?>" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Update</button>
            </div>
        </form>
    </div>
</body>
</html>

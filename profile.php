<?php
include 'config.php';

error_reporting(0);

session_start();

// Memeriksa apakah pengguna belum login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit; // Menghentikan eksekusi skrip setelah redirect
}

// Mendapatkan data pengguna yang sedang login
$username = $_SESSION['username'];

// Memeriksa apakah form telah disubmit
if(isset($_POST['submit'])){
    // Mengambil data dari form
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    // Menyiapkan statement SQL UPDATE
    $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE username = ?");
    // Mengikat parameter ke placeholder dalam statement SQL
    $stmt->bindParam(1, $newUsername);
    $stmt->bindParam(2, $newEmail);
    $stmt->bindParam(3, $newPassword);
    $stmt->bindParam(4, $username); // Menggunakan username sebelumnya untuk memperbarui record yang sesuai

    // Menjalankan kueri SQL
    if($stmt->execute()){
        echo "Data berhasil diperbarui.";
        // Mengupdate session jika username diubah
        $_SESSION['username'] = $newUsername;
    } else {
        echo "Gagal memperbarui data.";
    }
}

// Mengambil data pengguna untuk diisi ke dalam form
$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bindParam(1, $username);
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
            <p class="login-register-text">Go back to <a href="index.php">Home</a>.</p>
        </form>
    </div>
</body>
</html>

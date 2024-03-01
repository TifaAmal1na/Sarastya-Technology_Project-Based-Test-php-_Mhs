<?php

$host = "localhost";
$dbuser = "postgres";
$dbpass = "1234";
$port = "5432";
$db_name = "db_anggota";

try {
    $db = new PDO("pgsql:dbname=$db_name;host=$host;port=$port", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    echo "<h3>Maaf, Server Tidak Terhubung: " . $e->getMessage() . "</h3>";
}

?>

<!-- <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=devoice-width, initial-scale=1.0">
    <title>Connect PostgreSQL</title>
</head>
<body>
    <h3>Connect PostgreSQL</h3>
    <hr>
</body>
</html> -->
<?php  
$sName = "localhost";
$uName = "root";
$pass  = "";
$db_name = "sms_db";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo "Connection failed: ". $e->getMessage();
    exit;
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = $data["password"];
    $password2 = $data["password2"];

    // cek username sudah ada atau belum
    $stmt = $conn->prepare("SELECT username FROM admin WHERE username = :username");
    $stmt->execute(['username' => $username]);

    if ($stmt->fetch()) {
        echo "<script>alert('Username sudah terdaftar');</script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
        return false;
    }

    // enkripsi password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
	$stmt = $conn->prepare("INSERT INTO admin (username, password, fname) 
							VALUES (:username, :password, :fname)");
	$stmt->execute([
		'username' => $username,
		'password' => $passwordHash,
		'fname'    => $data["fname"]
	]);

    return $stmt->rowCount();
}

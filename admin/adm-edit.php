<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {

    if (!isset($_GET['admin_id'])) {
        header("Location: adm.php");
        exit();
    }

    include "../DB_connection.php";

    $admin_id = $_GET['admin_id'];

    // Ambil data admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id=?");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        header("Location: adm.php?error=Admin not found");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Admin</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo2.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <?php 
    include "inc/navbar.php";
  ?>
  <div class="container mt-5">
    <a href="adm.php" class="btn btn-dark">Go Back</a>
    <div class="form-wrapper d-flex justify-content-center">
      <form method="post" action="req/adm-update.php" class="form-content">
        <h3>Edit Admin</h3><hr>

        <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger"><?=$_GET['error']?></div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success"><?=$_GET['success']?></div>
        <?php } ?>

        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" name="fname" value="<?=$admin['fname']?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" name="lname" value="<?=$admin['lname']?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" name="username" value="<?=$admin['username']?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password (isi hanya kalau mau ganti)</label>
          <input type="password" class="form-control" name="password" placeholder="Leave blank if not changing">
        </div>
        <input type="hidden" name="admin_id" value="<?=$admin['admin_id']?>">
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit();
}
?>

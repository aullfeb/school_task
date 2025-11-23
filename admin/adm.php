<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
$stmt = $conn->query("SELECT * FROM admin");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Pages</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo2.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
      include "inc/navbar.php";
      if ($admins != 0) {
    ?>
      <div class="container mt-5">
        <a href="index.php" class="btn btn-dark"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
        <a href="adm-add.php" class="btn btn-dark">Add New Admin</a>
          <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger mt-3 n-table" 
                role="alert">
            <?=$_GET['error']?>
          </div>
          <?php } ?>

          <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3 n-table" 
                  role="alert">
              <?=$_GET['success']?>
            </div>
            <?php } ?>
            <div class="table-responsive">
          <table class="table table-bordered mt-3 n-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <!-- <th scope="col">Role</th> -->
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
          <?php if ($admins && count($admins) > 0): ?>
          <?php $i = 0; foreach ($admins as $admin): $i++; ?>
            <tr>
              <th scope="row"><?=$i?></th>
              <td><?=$admin['admin_id']?></td>
              <td><?=$admin['username']?></td>
              <td><?=$admin['fname']?></td>
              <td><?=$admin['lname']?></td>
              <td>
                <a href="adm-edit.php?admin_id=<?=$admin['admin_id']?>" class="btn btn-warning">Edit</a>
                <a href="adm-delete.php?admin_id=<?=$admin['admin_id']?>" class="btn btn-danger">Delete</a>
              </td>
            </tr>
          <?php endforeach ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center">No admins found</td>
                </tr>
              <?php endif ?>
            </tbody>
          </table>
        </div>
          <?php }else{ ?>
              <div class="alert alert-info .w-450 m-5" 
                    role="alert">
                  Empty!
                </div>
          <?php } ?>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
          $("#navLinks li:nth-child(2) a").addClass('active');
        });
    </script>
</body>
</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>
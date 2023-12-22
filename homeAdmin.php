<?php

@include 'koneksi.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM pengguna WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:homeAdmin.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

   <title>Tampilan Halaman Admin</title>

</head>
<body>

<section class="user-accounts">

   <h1 class="title">Halaman Akun Admin</h1>

   <div class="box-container">

      <?php
         $select_users = $conn->prepare("SELECT * FROM pengguna");
         $select_users->execute();
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="<?php if($fetch_users['user_type'] == 'admin'){ echo 'display:none'; };if($fetch_users['user_type'] == 'superadmin'){ echo 'display:none'; }; ?>">
         <p> user id : <span><?= $fetch_users['id']; ?></span></p>
         <p> username : <span><?= $fetch_users['username']; ?></span></p>
         <p> email : <span><?= $fetch_users['email']; ?></span></p>
         <p> user type : <span><?= $fetch_users['user_type']; ?></span></p>
         <a href="homeAdmin.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('yakin hapus?');" class="delete-btn">delete</a>
         <a href="updateUserAdmin.php?id=<?= $fetch_users['id']; ?>" class="option-btn">update</a>
      </div>
      <?php
      }
      ?>
   </div>
   <br><br><br>
   <button style="background-color: rgb(232,76,60)">
		<h2><a href="logout.php">Log Out</a></h2>
   </button>
   <button>
		<h2><a href="listmakanan.php?user_type=admin">Lihat Daftar Makanan</a></h2>
   </button>
   <br><br>
</section>
</body>
</html>
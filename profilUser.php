<?php

@include 'koneksi.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>

   <title>Halaman Profile User</title>

</head>
<body>

<section class="user-accounts">

   <h1 class="title">Akun Saya</h1>

   <div class="box-container">

      <?php
         $select_users = $conn->prepare("SELECT * FROM pengguna");
         $select_users->execute();
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="<?php if($fetch_users['id'] != $user_id){ echo 'display:none'; }; ?>">

         <p> user id : <span><?= $fetch_users['id']; ?></span></p>
         <p> username : <span><?= $fetch_users['username']; ?></span></p>
         <p> email : <span><?= $fetch_users['email']; ?></span></p>
         <p> user type : <span><?= $fetch_users['user_type']; ?></span></p>
         <a href="updateUser.php??id=<?= $fetch_users['id']; ?>" class="option-btn">Update</a>
         <a href="logout.php" class="delete-btn">Logout</a>
      </div>
      <?php
      }
      ?>
   </div>
   <br><br><br>
   <button>
		<h2><a href="listmakanan.php?user_type=user">Lihat Daftar Makanan</a></h2>
   </button>  
</section>
</body>
</html>
<?php

include 'koneksi.php';

session_start();

$admin_id = $_SESSION['admin_id'];
$user_id = $_GET['id'];
if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_profile'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   
   $update_profile = $conn->prepare("UPDATE pengguna SET username = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);




   $old_pass = $_POST['old_pass'];
   $update_pass = $_POST['update_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];

   if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'password lama tidak sama!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'konfirmasi password tidak sama!';
      }else{
         $update_pass_query = $conn->prepare("UPDATE pengguna SET password = ? WHERE id = ?");
         $update_pass_query->execute([$confirm_pass, $user_id]);
         $message[] = 'password berhasil diperbarui!';
      }
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

   <title>Halaman Update User Profile</title>



</head>
<body>

<section class="update-profile">

   <h1 class="title">Halaman Update User Profile</h1>

        <?php
            $select_profile = $conn->prepare("SELECT * FROM pengguna WHERE id = ?");
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>

   <form action="" method="POST" enctype="multipart/form-data">

      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="name" value="<?= $fetch_profile['username']; ?>" placeholder="update username" required class="box"></br></br>
            <span>email :</span>
            <input type="email" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="update email" required class="box"></br></br>

         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
            <span>password lama :</span>
            <input type="password" name="update_pass" placeholder="masukkan password lama" class="box"></br></br>
            <span>password baru :</span>
            <input type="password" name="new_pass" placeholder="masukkan password baru" class="box"></br></br>
            <span>konfirmasi password :</span>
            <input type="password" name="confirm_pass" placeholder="konfirmasi password baru" class="box"></br></br>
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update profile" name="update_profile"></br></br>
         <a href="homeAdmin.php" class="option-btn">Kembali</a>
      </div>
   </form>

</section>

</body>
</html>
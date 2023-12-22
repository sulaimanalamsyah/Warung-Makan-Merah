<?php

include 'koneksi.php';

session_start();

$superadmin_id = $_SESSION['superadmin_id'];
$admin_id = $_SESSION['admin_id'];

$id = $_GET['id'];
if(!(isset($superadmin_id)||(isset($admin_id)))){
   header('location:login.php');
};

if(isset($_POST['update_makanan'])){

   $nama = $_POST['nama'];
   $harga = $_POST['harga'];
   $detail = $_POST['detail'];

   $update_makanan = $conn->prepare("UPDATE makanan SET nama = ?, harga = ?, detail = ? WHERE id = ?");
   $update_makanan->execute([$nama, $harga, $detail, $id]);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

   <title>Halaman Update Makanan</title>


</head>
<body>

<section class="update-profile">

   <h1 class="title">Halaman Update Makanan</h1>

        <?php
            $select_makanan = $conn->prepare("SELECT * FROM makanan WHERE id = ?");
            $select_makanan->execute([$id]);
            $fetch_makanan = $select_makanan->fetch(PDO::FETCH_ASSOC);
        ?>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox" style="text-align: left; margin-left: auto; margin-right: auto;">
            <span>Nama :</span>
            <input type="text" name="nama" value="<?= $fetch_makanan['nama']; ?>" placeholder="update nama makanan" required class="box" style="text-align: center;"></br></br>
            <span>Harga :</span>
            <input type="number" name="harga" value="<?= $fetch_makanan['harga']; ?>" placeholder="update harga" required class="box" style="text-align: center;"></br></br>
            <span>details :</span>
            <input type="text" name="detail" value="<?= $fetch_makanan['detail']; ?>" placeholder="update detail" required class="box" style="text-align: center;"></br></br>
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update makanan" name="update_makanan"></br></br>
         <a href="listmakanan.php?user_type=admin" class="option-btn">Kembali</a>
      </div>
   </form>

</section>

</body>
</html>
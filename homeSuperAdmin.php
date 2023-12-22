<?php

@include 'koneksi.php';

session_start();

$superadmin_id = $_SESSION['superadmin_id'];
if(!isset($superadmin_id)){
   header('location:login.php');
};

if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $user_type = $_POST['user_type'];

    $select = $conn->prepare('SELECT * FROM pengguna WHERE email = ?');
    $select->execute([$email]);

    if($select->rowCount()>0){
        $message[] = "Email sudah digunakan";
    }else{
        if($pass != $cpass){
            $message[] = "Konfirmasi password tidak sama dengan password!";
        }else{
            $insert = $conn->prepare('INSERT INTO pengguna (username, email, password, user_type) VALUES (?, ?, ?, ?)');
            $insert->execute([$nama, $email, $pass, $user_type]);
                    $message[] = "Akun sukses terdaftar!"; 
                    header('location:homeSuperAdmin.php');
                
        }
    }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM pengguna WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:homeSuperAdmin.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

   <title>Tampilan Halaman Super Admin</title>

</head>
<body>

<section class="user-accounts">

   <h1 class="title">Halaman Akun Super Admin</h1>

   <table border-style: solid; border: 5px>

      <?php
         $select_users = $conn->prepare("SELECT * FROM pengguna");
         $select_users->execute();
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="<?php if($fetch_users['user_type'] == 'user'){ echo 'display:none'; };if($fetch_users['user_type'] == 'superadmin'){ echo 'display:none'; }; ?>">

         <p> user id : <span><?= $fetch_users['id']; ?></span></p>
         <p> username : <span><?= $fetch_users['username']; ?></span></p>
         <p> email : <span><?= $fetch_users['email']; ?></span></p>
         <p> user type : <span><?= $fetch_users['user_type']; ?></span></p>
         <a href="homeSuperAdmin.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('yakin hapus?');" class="delete-btn">delete</a>
         <a href="updateAdmin.php?id=<?= $fetch_users['id']; ?>" class="option-btn">update</a>
         <br><br><br>
      </div>
      <?php
      }
      ?>
   </table>
   <br><br><br>

   <table>
        <form enctype="multipart/form-data" method="post">
            <h3 class="title"> Buat Akun Admin </h3>

            <div >
                <div >
                    Masukkan Nama : <input type="text" name="nama" class="box" placeholder="Masukkan nama" required class="box"></br></br>
                    Masukkan Email : <input type="email" name="email" class="box" placeholder="Masukkan email" required class="box"></br></br>
                    Tipe User : <select name="user_type" class="box">
                        <option value="superadmin"disabled hidden>Super Admin</option>
                        <option value="admin" selected>Admin</option>
                        <option value="user"disabled hidden>User</option>
                    </select>
                    </br></br>
                </div>
                <div >
                    Masukkan Password : <input type="password" name="pass" class="box" placeholder="Masukkan password" required class="box"></br></br>
                    Konfirmasi Password : <input type="password" name="cpass" class="box" placeholder="Konfirmasi password" required class="box"></br></br>
                </div>
            </div>
            <div>
                <input type="submit" name="submit" value="Buat Akun Admin" >
            </div>  
        </form>
    </table>
    <br><br><br>
   <button style="background-color: rgb(0,128,0)">
		<h2><a href="logout.php">Log Out</a></h2>
   </button>
   <button style="background-color: rgb(255,0,0)">
		<h2><a href="listmakanan.php?user_type=superadmin">Lihat Daftar Makanan</a></h2>
   </button>
    <br>
</section>
</body>
</html>
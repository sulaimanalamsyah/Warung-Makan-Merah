<?php
    include "koneksi.php";
    if(isset($_POST['submit'])){
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $cpass = $_POST['cpass'];
        $user_type = $_POST['user_type'];
    
        

        $select = $conn->prepare('SELECT * FROM pengguna WHERE email = ?');
        $select->execute([$email]);

        if($select->rowCount()>0){
            $message[] = "Email sudah pernah digunakan";
        }else{
            if($pass != $cpass){
                $message[] = "Konfirmasi password tidak sama dengan password!";
            }else{
                $insert = $conn->prepare('INSERT INTO pengguna (username, email, password, user_type) VALUES (?, ?, ?, ?)');
                $insert->execute([$nama, $email, $pass, $user_type]);
                        $message[] = "Akun sukses terdaftar!"; 
                        header('location:login.php');
                    
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Registrasi Warung Makan Merah</title>


</head>
<body>
    <?php
        if(isset($message)){
            foreach($message as $message){
                echo "
                <div class='message'>
                    <span>$message</span>
                    <i class='fas fa-times' onclick='this.parentElement.remove()'></i>
                </div>
                ";
            }
        }
    ?>
    <section class="form-container">
        <form enctype="multipart/form-data" method="post">
            <h3> Registrasi Warung Makan Merah </h3>
            <input type="text" name="nama" class="box" placeholder="Masukkan username" required></br></br>
            <input type="email" name="email" class="box" placeholder="Masukkan email" required></br></br>
            <input type="password" name="pass" class="box" placeholder="Masukkan password" required></br></br>
            <input type="password" name="cpass" class="box" placeholder="Konfirmasi password" required></br></br>
            <select name="user_type" class="box">
                <option hidden selected disabled>Pilih Tipe User</option>
                <option value="superadmin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select></br></br>
            <input type="submit" name="submit" value="Register" class="btn">
            <p><a href="login.php">Ke halaman login</a></p>
        </form>
    </section>
</body>
</html>
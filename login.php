<?php
    include "koneksi.php";
    session_start();
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $select = $conn->prepare('SELECT * FROM pengguna WHERE email = ? AND password = ?');
        $select->execute([$email, $pass]);
        $row = $select->fetch(PDO::FETCH_ASSOC);

        if($select->rowCount()>0){
            if($row['user_type']=='superadmin'){
                $_SESSION['superadmin_id'] = $row['id'];
                header('location:homeSuperAdmin.php');
            }elseif($row['user_type']=='admin'){
                $_SESSION['admin_id'] = $row['id'];
                header('location:homeAdmin.php');
            }elseif($row['user_type']=='user'){
                $_SESSION['user_id'] = $row['id'];
                header('location:profilUser.php');
            }else{
                $message[] = 'User tidak terdaftar di database!';
            }
        }else{
            $message[]="Email atau password salah!";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Login Warung Makan Merah</title>

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
            <h3> Login Warung Makan Merah </h3>
            <input type="email" name="email" class="box" placeholder="Masukkan email" required></br></br>
            <input type="password" name="pass" class="box" placeholder="Masukkan password" required></br></br>
            <input type="submit" name="submit" value="Log in" class="btn">
            <p><a href="register.php">Registrasi Akun</a></p>
        </form>
    </section>
</body>
</html>
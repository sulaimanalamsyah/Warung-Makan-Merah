<?php
@include 'koneksi.php';

session_start();

$usertype = $_GET['user_type'];

if($usertype == 'superadmin'){
    $superadmin_id = $_SESSION['superadmin_id'];
}else if($usertype == 'admin'){
    $admin_id = $_SESSION['admin_id'];
}else if($usertype == 'user'){
    $user_id = $_SESSION['user_id'];    
}

if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $detail = $_POST['detail'];

    $insert = $conn->prepare('INSERT INTO makanan (nama, harga, detail) VALUES (?, ?, ?)');
    $insert->execute([$nama, $harga, $detail]);
}
if(isset($_GET['delete1'])){

    $delete_id = $_GET['delete1'];
    $delete_users = $conn->prepare("DELETE FROM makanan WHERE id = ?");
    $delete_users->execute([$delete_id]);
    header('location:listmakanan.php?user_type=admin');
 
}
if(isset($_GET['delete2'])){

    $delete_id = $_GET['delete2'];
    $delete_users = $conn->prepare("DELETE FROM makanan WHERE id = ?");
    $delete_users->execute([$delete_id]);
    header('location:listmakanan.php?user_type=superadmin');
 
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Halaman List Makanan</title>

</head>
<body>
    <table border="1"  id="makanan">
        <th>ID</th>
        <th>Nama Barang</th>
        <th>Harga Barang</th>
        <th>Detail Barang</th>
        <th style="<?php if($usertype=='user'){ echo 'display:none'; };?>">Aksi</th>
    
    <?php
         $select_product = $conn->prepare("SELECT * FROM makanan");
         $select_product->execute();
         while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
    ?>        
            <tr>
                <td><?= $fetch_product['id']; ?></td>
                <td><?= $fetch_product['nama']; ?></td>
                <td><?= $fetch_product['harga']; ?></td>
                <td><?= $fetch_product['detail']; ?></td>
                <td style="<?php if($usertype=='user'){ echo 'display:none'; };?>">
                    <a href="listmakanan.php?delete1=<?= $fetch_product['id']; ?>" onclick="return confirm('hapus item?');" style="<?php if($usertype == 'superadmin'){ echo 'display:none'; };?>">Delete</a><a href="listmakanan.php?delete2=<?= $fetch_product['id']; ?>" onclick="return confirm('hapus item?');" style="<?php if($usertype == 'admin'){ echo 'display:none'; };?>">Hapus</a> |
                    <a href="updateMakanan1.php?id=<?= $fetch_product['id']; ?>" style="<?php if($usertype == 'superadmin'){ echo 'display:none'; };?>">Update</a><a href="updateMakanan2.php?id=<?= $fetch_product['id']; ?>" style="<?php if($usertype == 'admin'){ echo 'display:none'; };?>">Update</a>
                </td>
            </tr>
    <?php        
         }
    ?>
    </table>
    <br><br><br>

    <section class="form-container" style="<?php if($usertype=='user'){ echo 'display:none'; };?>">
        <form enctype="multipart/form-data" method="post">
            <h3> Masukkan Makanan Baru </h3>
            <input type="text" name="nama" placeholder="Masukan Nama Makanan" required class="box"></br></br>
            <input type="number" name="harga" placeholder="Masukan Harga Makanan" required class="box"></br></br>
            <textarea name="detail" placeholder="Masukan Detail Makanan" required cols="20" rows="5" class="box"></textarea></br></br>
            <input type="submit" name="submit" value="Masukkan" class="btn">
        </form>
    </section>
    <br><br><br>
    <button class="button-9" role="button" style="<?php if($usertype =='user'){ echo 'display:none'; }else if($usertype == 'admin'){ echo 'display:none'; }; ?>">
		<h2><a href="homeSuperAdmin.php">Kembali</a></h2>
    </button>
    <button class="button-9" role="button" style="<?php if($usertype == 'superadmin'){ echo 'display:none'; }else if($usertype == 'user'){ echo 'display:none'; }; ?>">
		<h2><a href="homeAdmin.php">Kembali</a></h2>
    </button>
    <button class="button-9" role="button" style="<?php if($usertype == 'superadmin'){ echo 'display:none'; }else if($usertype == 'admin'){ echo 'display:none'; }; ?>">
		<h2><a href="profilUser.php">Kembali</a></h2>
    </button>
</body>
</html>
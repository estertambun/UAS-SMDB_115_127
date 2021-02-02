<?php
    session_start();
    include "koneksi.php";
    if(!isset($_SESSION['username'])){
        header ("location:login.php");
    }
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    } 

    //simpan di klik
    if(isset($_POST['bsimpan']))
    {

        //pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE mhs set
                                                nim = '$_POST[tnim]',
                                                nama = '$_POST[tnama]',
                                                kom = '$_POST[tkom]'
                                            WHERE nim = '$_GET[id]'
                                            ");
            if($edit) //jika edit sukses
            {
                echo "<script>
                    alert('Edit data Sukses');
                    document.location='index.php';
                </script>";
            }
            else
            {
                echo "<script>
                alert('Edit data Gagal');
                document.location='index.php';
            </script>";   
            }

        }else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO mhs (nim, nama, kom)
                                        VALUES ('$_POST[tnim]',
                                                '$_POST[tnama]',
                                                '$_POST[tkom]')
                                                ");
            if($simpan) //jika simpan sukses
            {
                echo "<script>
                    alert('Simpan data Sukses!');
                    document.location='index.php';
                </script>";
            }
            else
            {
                echo "<script>
                alert('Simpan data Gagal');
                document.location='index.php';
            </script>";   
            }
        }

    }

    //pengujian jika tombol edit atau hapus diklik
    if(isset($_GET['hal']))
    {
        //pengujian jika edit data 
        if($_GET['hal']== "edit")
        {
            //tampilkan data yg diedit
            $tampil = mysqli_query($koneksi,"SELECT * FROM mhs WHERE nim = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan maka data ditampung dulu kedalam variabel
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $vkom = $data['kom'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //persiapan hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM mhs WHERE nim = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                alert('Hapus data Sukses');
                document.location='index.php';
            </script>"; 
            }
        }
    }

?>


<!DOCTYPE html>
<html>
<head>
    <title>Uas</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
    <!--header start-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <form class="form-inline">
  <a class="nav-link" href="logout.php">Logout</a>
  </form>
</nav>
        <!--header end-->

<div class="container">
    <br><br>
    <!--awal card form-->
    <div class="card mt-3">
    <div class="card-header bg-primary text-white">
        Form input data mahasiswa
    </div>
    <div class="card-body">
        <form method ="post" action="">
            <div class="form-group">
                <label>Nim</label>
                <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="input nim anda" required>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="input nama anda" required>
            </div>
            <div class="form-group">
                <label>Kom</label>
                <select class="form-control" name="tkom">
                    <option value="<?=@$vkom?>"><?=@$vkom?></option>
                    <option value="a">a</option>
                    <option value="b">b</option>
                    <option value="c">c</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
            <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
        </form>
    </div>
    </div>
    <!--akhir card form-->

    <!--awal card table-->
    <div class="card mt-3">
    <div class="card-header bg-success text-white">
        daftar mahasiswa yang hadir
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No</th>
                <th>Nim</th>
                <th>Nama</th>
                <th>Kom</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * FROM mhs ORDER BY nim DESC");
            while($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['nim']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['kom']?></td>
                <td>
                    <a href ="index.php?hal=edit&id=<?=$data['nim']?>" class="btn btn-warning"> Edit </a>
                    <a href ="index.php?hal=hapus&id=<?=$data['nim']?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    </div>
    <!--akhir card table-->
</div>

<script type="text/javascript" src="js/bootstrap.min.css"></script>
</body>
</html>
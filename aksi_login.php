<?php 
session_start();
include ("koneksi.php");
$username = $_POST['username'];
$password = $_POST['password'];
$query=mysqli_query($koneksi, "select * from user where username = '$username' and password = '$password'");

$xxx=mysqli_num_rows($query);
if ($xxx ==TRUE){
    $_SESSION['username']=$username;
    header ("location:index.php");
}
else{
    echo "<script>alert('username atau password salah'); location = 'login.php';</script>";
}
?>
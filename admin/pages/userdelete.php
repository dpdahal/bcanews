<?php 

$id=$_GET['uid'];

$sql="DELETE FROM users WHERE id=$id";
$response = mysqli_query($conn, $sql);
if($response){
    $_SESSION['success'] = "User Deleted Successfully";
    header('location:'.url('admin/users.php'));
}else{
    $_SESSION['error'] = "User Not Deleted";
    header('location:'.url('admin/users.php'));
}
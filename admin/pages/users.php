<?php 
$id=$_SESSION['user']['id'];

$sql="SELECT * FROM users WHERE id!=$id ORDER BY id DESC";
$response = mysqli_query($conn, $sql);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
          <div class="dashboard-card p-3">
            <h2>Users List</h2>
            <hr>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sn</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($response as $key=>$user) : ?>
                    <tr>
                        <td><?=++$key;?></td>
                        <td><?=$user['name'];?></td>
                        <td><?=$user['email'];?></td>
                        <td><?=$user['gender'];?></td>
                        <td>
                            <img src="<?=url('public/users/'.$user['image'])?>"
                            width="60"
                             alt="">
                        </td>
                        <td>
                    <a href="<?=url('admin/updateuser.php?uid='.$user['id'].'')?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                    <a href="<?=url('admin/userdelete.php?uid='.$user['id'].'')?>" 
                    class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                        </td>
                       
                    </tr>   
                    <?php endforeach; ?>                 
                </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
<?php 

$id=$_SESSION['user']['id'];
$sql="SELECT * FROM users WHERE id='$id'";
$result=mysqli_query($conn,$sql);
$user = mysqli_fetch_assoc($result);
$errors=['name'=>'', 'email'=>'','gender'=>''];
$old=[  'name'=>'', 'email'=>'', 'gender'=>''];
$old['name']=$user['name'];
$old['email']=$user['email'];
$old['gender']=$user['gender'];
if(!empty($_POST)){
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $sql="UPDATE users SET name='$name', gender='$gender' WHERE id='$id'";
    $res = mysqli_query($conn,$sql);
    if($res){
        $_SESSION['success']="Profile Updated Successfully";
        header('Location: /bcanews/admin/profile');
        exit();
    }else{
        echo "Error: ".mysqli_error($conn);
    }  
}

?>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-12">
          <div class="dashboard-card p-3">
            <h2>Update Profile</h2>
            <?= message() ?>
            <hr>
            <form action="" method="post">
                    <div class="form-group mb-2">
                        <label for="name">Name:
                            <span class='text-danger'><?= $errors['name'] ?></span>
                        </label>
                        <input type="text" name="name"
                        value="<?= $old['name'] ?>"
                         id="name" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email:
                            <span class='text-danger'><?= $errors['email'] ?></span>
                        </label>
                        <input type="text" name="email"
                        value="<?= $old['email'] ?>"
                        readonly
                        disabled                     
                         id="email" class="form-control">
                    </div>
                
                    <div class="form-group mb-2">
                        <label for="gender">Gender:
                            <span class='text-danger'><?= $errors['gender']?></span>
                        </label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">---Select Gender ---</option>
                            <option value="male"
                            <?=$old['gender']=='male'? 'selected': ''?>
                            >Male</option>
                            <option value="female"
                            <?=$old['gender']=='female'? 'selected': ''?>
                            >Female</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <button class="btn btn-success w-100">Update Record</button>
                    </div>
                </form>

          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
          <div class="dashboard-card p-3">
            <h2>Update Password</h2>

          </div>
        </div>
    </div>
</div>
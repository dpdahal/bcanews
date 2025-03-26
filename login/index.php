<?php 
require_once "../connection.php";


if(isset($_SESSION['user']) || $_SESSION['is_login'] =true){
    header("Location: /bcanews/admin");
    exit();
}


$errors=[
    'email'=>'',
    'password'=>''
];

$old=[
   'email'=>'', 
   'password'=>''
];

if(!empty($_POST)){
   foreach($_POST as $key=>$value){
        if(empty($value)){
            $errors[$key]='This field is required';
        }else{
            $old[$key]=$value;
        }
   }
   
    $email=$_POST['email'];
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email']='Invalid email format';
    }
    $password=$_POST['password'];
    if(!array_filter($errors)){
        $email = $_POST['email'];
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $user;
            $_SESSION['is_login']=true;
            header("Location:/bcanews/admin");
        }else{
            $_SESSION['error'] = "Invalid email or password";
            header("Location:/bcanews/login");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Login</h1>
            </div>
            <div class="col-md-12">
                <?=message()?>
            </div>
            <div class="col-md-12">
                <form action="" method="post">
                    
                    <div class="form-group mb-2">
                        <label for="email">Email:
                            <span class='text-danger'><?= $errors['email'] ?></span>
                        </label>
                        <input type="text" name="email"
                        value="<?= $old['email'] ?>"
                         id="email" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="password">Password:
                            <span class='text-danger'><?= $errors['password'] ?></span>
                        </label>
                        <input type="password" name="password"
                        value="<?= $old['password'] ?>"
                         id="password" class="form-control">
                    </div>
                    
            
                    <div class="form-group mb-2">
                        <button class="btn btn-success w-100">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
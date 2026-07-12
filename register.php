
<?php
include("config/db.php");

if(isset($_POST['register']))
{
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,"
    INSERT INTO users(full_name,email,password)
    VALUES('$name','$email','$password')
    ");

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Create Account</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    font-family:Arial,sans-serif;
}

.register-container{
    width:950px;
    max-width:95%;
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.left-panel{
    background:linear-gradient(135deg,#3b82f6,#1d4ed8);
    color:white;
    padding:45px 30px;
    height:100%;
}

.logo-circle{
    width:80px;
    height:80px;
    background:white;
    color:#1d4ed8;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:24px;
    font-weight:bold;
    margin-bottom:25px;
}

.left-panel h1{
    font-weight:bold;
    margin-bottom:5px;
}

.left-panel h4{
    margin-bottom:25px;
}

.left-panel p{
    font-size:16px;
    line-height:1.8;
}

.right-panel{
    padding:40px 35px;
}

.form-control{
    height:48px;
    border-radius:10px;
}

.btn-register{
    height:48px;
    border-radius:10px;
    font-weight:bold;
}

.footer-text{
    text-align:center;
    color:#666;
    margin-top:25px;
}

</style>

</head>

<body>

<div class="register-container">

<div class="row g-0">

<div class="col-md-5">

<div class="left-panel">

<div class="logo-circle">DG</div>

<h1>Dream Gadget Store</h1>

<h4>Create Account</h4>

<p>
Join Dream Gadget Store today and enjoy
easy shopping, secure checkout, order tracking,
and exclusive access to the latest gadgets.
</p>

</div>

</div>

<div class="col-md-7">

<div class="right-panel">

<h2 class="mb-4">Create Account</h2>

<form method="POST">

<div class="mb-3">

<label>Full Name</label>

<input
type="text"
name="full_name"
class="form-control"
placeholder="Enter Full Name"
required>

</div>

<div class="mb-3">

<label>Email Address</label>

<input
type="email"
name="email"
class="form-control"
placeholder="Enter Email Address"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Create Password"
required>

</div>

<button
name="register"
class="btn btn-success btn-register w-100">
Create Account
</button>

</form>

<hr>

<div class="text-center">

<p>Already have an account?</p>

<a href="login.php"
class="btn btn-primary">
Login Here
</a>

</div>

<div class="footer-text">

Dream Gadget Store Customer Portal<br>
© 2026

</div>

</div>

</div>

</div>

</div>

</body>
</html>

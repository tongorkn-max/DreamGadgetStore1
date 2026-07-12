
<?php
session_start();
include("config/db.php");

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
    "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($query) > 0)
    {
        $user = mysqli_fetch_assoc($query);

        if(password_verify($password,$user['password']))
        {
           
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['full_name'];
$_SESSION['user_email'] = $user['email'];


            header("Location: customer_dashboard.php");
            exit();
        }
    }

    $error = "Invalid Email or Password";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Customer Login</title>

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

.login-container{
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
    height:45px;
    border-radius:10px;
}

.btn-login{
    height:45px;
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

<div class="login-container">

<div class="row g-0">

<div class="col-md-5">

<div class="left-panel">

<div class="logo-circle">DG</div>

<h1>Dream Gadget Store</h1>

<h4>Customer Portal</h4>

<p>
Browse products, manage your cart,
track your orders and enjoy a seamless
shopping experience from your customer dashboard.
</p>

</div>

</div>

<div class="col-md-7">

<div class="right-panel">

<h2 class="mb-4">Customer Login</h2>

<?php
if(isset($error))
{
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

<form method="POST">

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
placeholder="Enter Password"
required>

</div>

<button
name="login"
class="btn btn-primary btn-login w-100">
Login To Account
</button>

</form>

<hr>

<div class="text-center">

<p>Don't have an account?</p>

<a href="register.php"
class="btn btn-success">
Register Account
</a>

<br><br>

<a href="index.php"
class="btn btn-outline-secondary">
← Back To Home
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

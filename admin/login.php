<?php
session_start();
include("../config/db.php");

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
    "SELECT * FROM admin
     WHERE username='$username'
     AND password='$password'");

    if(mysqli_num_rows($query) > 0)
    {
        $admin = mysqli_fetch_assoc($query);

        $_SESSION['admin'] = $admin['username'];
        $_SESSION['admin_id'] = $admin['id'];

        header("Location: dashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid Login Credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Dream Gadget Store - Admin Login</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#0f172a,#1e3a8a);
    height:100vh;
    overflow:hidden;
}

.login-card{
    border:none;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 40px rgba(0,0,0,.30);
}

.brand-side{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    padding:50px 30px;
    height:100%;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.brand-side h1{
    font-weight:bold;
}

.login-side{
    padding:40px;
    background:white;
}

.form-control{
    border-radius:10px;
    padding:12px;
}

.btn-login{
    border-radius:10px;
    padding:12px;
    font-weight:bold;
}

.btn-back{
    border-radius:10px;
    padding:12px;
    font-weight:bold;
    border:2px solid #2563eb;
    color:#2563eb;
    background:#fff;
    transition:.3s;
    text-decoration:none;
    display:block;
    text-align:center;
}

.btn-back:hover{
    background:#2563eb;
    color:#fff;
}

.logo-circle{
    width:90px;
    height:90px;
    border-radius:50%;
    background:white;
    color:#2563eb;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:35px;
    font-weight:bold;
    margin-bottom:20px;
}

@media(max-width:768px){

body{
    overflow:auto;
}

.brand-side{
    padding:35px 25px;
    text-align:center;
}

.login-side{
    padding:30px 25px;
}

}

</style>

</head>

<body>

<div class="container h-100">

<div class="row justify-content-center align-items-center h-100">

<div class="col-lg-10">

<div class="card login-card">

<div class="row g-0">

<div class="col-md-5">

<div class="brand-side">

<div class="logo-circle">
DG
</div>

<h1>Dream Gadget Store</h1>

<h5>Administration Portal</h5>

<p class="mt-4">
Manage products, customers, orders, analytics and monitor your store performance from one professional dashboard.
</p>

</div>

</div>

<div class="col-md-7">

<div class="login-side">

<h2 class="mb-4">
Admin Login
</h2>

<?php
if(isset($error))
{
?>
<div class="alert alert-danger">
<?php echo $error; ?>
</div>
<?php
}
?>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Username
</label>

<input
type="text"
name="username"
class="form-control"
placeholder="Enter Username"
required>

</div>

<div class="mb-4">

<label class="form-label">
Password
</label>

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

Login To Dashboard

</button>

<a href="../index.php" class="btn-back mt-3">
← Back To Store
</a>

</form>

<div class="text-center mt-4 text-muted">

Dream Gadget Store Admin Panel
<br>
© <?php echo date('Y'); ?>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
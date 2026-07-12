<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Customer Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.dashboard-box{
    background:rgba(255,255,255,0.95);
    border-radius:20px;
    padding:40px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.welcome-card{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    padding:35px;
    border-radius:20px;
    margin-bottom:30px;
}

.welcome-card h2{
    font-weight:bold;
    margin-bottom:10px;
}

.stat-card{
    border:none;
    border-radius:18px;
    padding:25px;
    color:white;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}

.orders-card{
    background:linear-gradient(135deg,#10b981,#059669);
}

.cart-card{
    background:linear-gradient(135deg,#f59e0b,#d97706);
}

.account-card{
    background:linear-gradient(135deg,#8b5cf6,#6d28d9);
}

.action-btn{
    padding:12px 25px;
    border-radius:10px;
    font-weight:bold;
}

.section-title{
    font-weight:bold;
    margin-bottom:20px;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container py-5">

<div class="dashboard-box">

<div class="welcome-card">

<h2>
Welcome,
<?php echo $_SESSION['user_name']; ?> 👋
</h2>

<p class="mb-0">
Manage your orders, browse products and enjoy shopping at Dream Gadget Store.
</p>

</div>

<div class="row mb-4">

<div class="col-md-4 mb-3">

<div class="stat-card orders-card">

<h3>📦 Orders</h3>

<p class="mb-0">
Track all your purchases easily.
</p>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="stat-card cart-card">

<h3>🛒 Shopping</h3>

<p class="mb-0">
Browse and buy the latest gadgets.
</p>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="stat-card account-card">

<h3>👤 Account</h3>

<p class="mb-0">
Manage your profile and settings.
</p>

</div>

</div>

</div>

<h4 class="section-title">
Quick Actions
</h4>

<a href="products.php"
class="btn btn-primary action-btn me-2">
🛍 Shop Products
</a>

<a href="order_history.php"
class="btn btn-success action-btn me-2">
📦 My Orders
</a>

<a href="customer_logout.php"
class="btn btn-danger action-btn">
🚪 Logout
</a>

<hr class="my-5">

<div class="text-center">

<h4>Dream Gadget Store</h4>

<p class="text-muted">
Your trusted destination for smartphones, laptops, accessories and smart gadgets.
</p>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
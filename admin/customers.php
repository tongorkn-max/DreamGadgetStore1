<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$customer_count = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM customers")
);

$customers = mysqli_query($conn,"
SELECT * FROM customers
ORDER BY id DESC
");
?>

<!DOCTYPE html>

<html>
<head>

<title>Customers</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/admin.css">
<style>

body{
    background:#eef2f7;
}

.sidebar{
    min-height:100vh;
    background:linear-gradient(180deg,#0f172a,#1e3a8a);
    color:white;
    padding:20px;
    box-shadow:4px 0 15px rgba(0,0,0,0.15);
}

.sidebar h3{
    font-weight:700;
    margin-bottom:20px;
}

.sidebar a{
    color:white;
    text-decoration:none;
    display:block;
    padding:12px 15px;
    margin-bottom:10px;
    border-radius:10px;
    transition:0.3s;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.15);
    transform:translateX(5px);
}

.content{
    padding:30px;
}

.welcome-box{
    background:linear-gradient(135deg,#1e3a8a,#2563eb);
    color:white;
    padding:25px;
    border-radius:18px;
    margin-bottom:25px;
    box-shadow:0 6px 20px rgba(0,0,0,0.15);
}

.welcome-box h2{
    margin-bottom:8px;
}

.welcome-box p{
    margin-bottom:0;
}


.card-box{
    border:none;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

.customer-avatar{
    width:45px;
    height:45px;
    border-radius:50%;
    background:#0d6efd;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<div class="col-md-2 sidebar">

<h3>Dream Gadget Store</h3>

<hr>

<a href="dashboard.php">🏠 Dashboard</a>

<a href="products.php">📦 Products</a>

<a href="orders.php">🛒 Orders</a>

<a href="customers.php">👥 Customers</a>

<a href="messages.php">📩 Messages</a>
    
 <a href="reports.php">📊 Reports</a>

<a href="logout.php">🚪 Logout</a>

</div>

<div class="col-md-10 content">

<div class="welcome-box">

<h2>👥 Customers Management</h2>

<p>
View and manage all registered customers.
</p>

</div>

<div class="row mb-4">

<div class="col-md-3">

<div class="card card-box bg-primary text-white">

<div class="card-body">

<h2><?php echo $customer_count; ?></h2>

<p>Total Customers</p>

</div>

</div>

</div>

</div>

<div class="card card-box">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Customer</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($customers)){ ?>

<tr>

<td>
<strong>#<?php echo $row['id']; ?></strong>
</td>

<td>

<div class="d-flex align-items-center">

<div class="customer-avatar me-3">

<?php
echo strtoupper(substr($row['full_name'],0,1));
?>

</div>

<div>

<strong>
<?php echo $row['full_name']; ?>
</strong>

</div>

</div>

</td>

<td>
<?php echo $row['email']; ?>
</td>

<td>
<?php echo $row['phone']; ?>
</td>

<td>
<?php echo $row['address']; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>

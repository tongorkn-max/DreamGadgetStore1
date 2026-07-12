<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

/* ===========================
   SALES REPORT STATISTICS
=========================== */

$total_sales = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total_amount) AS total
FROM orders
"));

$total_revenue = $total_sales['total'] ?? 0;

$total_orders = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
"));

$completed_orders = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
WHERE status='Delivered'
"));

$pending_payments = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
WHERE payment_status='Pending Verification'
"));

$paid_orders = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
WHERE payment_status='Paid'
"));

$recent_sales = mysqli_query($conn,"
SELECT
orders.id,
customers.full_name,
orders.total_amount,
orders.payment_status,
orders.status,
orders.order_date
FROM orders
LEFT JOIN customers
ON customers.id=orders.customer_id
ORDER BY orders.id DESC
LIMIT 15
");
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Sales Report</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

    <link rel="stylesheet" href="assets/css/admin.css">
<style>

body{
background:#eef2f7;
}

.sidebar{
min-height:100vh;
background:linear-gradient(180deg,#0f172a,#1e3a8a);
padding:20px;
color:white;
}

.sidebar h3{
font-weight:bold;
margin-bottom:20px;
}

.sidebar a{
display:block;
padding:12px;
margin-bottom:10px;
color:white;
text-decoration:none;
border-radius:10px;
transition:.3s;
}

.sidebar a:hover{
background:rgba(255,255,255,.15);
padding-left:18px;
}

.header-box{
background:linear-gradient(135deg,#1e40af,#2563eb);
color:white;
padding:30px;
border-radius:20px;
box-shadow:0 8px 20px rgba(0,0,0,.15);
margin-bottom:30px;
}

.card-box{
background:white;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,.10);
padding:25px;
margin-bottom:25px;
}

.stat-card{
border:none;
border-radius:18px;
color:white;
box-shadow:0 8px 20px rgba(0,0,0,.15);
}

.stat-card .card-body{
padding:25px;
text-align:center;
}

.stat-card h2{
font-size:36px;
font-weight:bold;
margin-bottom:10px;
}

.stat-card p{
margin:0;
font-size:18px;
}

.table th{
background:#0f172a;
color:white;
}

.progress{
height:22px;
border-radius:25px;
}

.progress-bar{
font-weight:bold;
}

.btn-custom{
padding:10px 22px;
border-radius:10px;
font-weight:bold;
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<div class="col-lg-2 sidebar">

<h3>Dream Gadget Store</h3>

<hr>

<a href="dashboard.php">🏠 Dashboard</a>

<a href="products.php">📦 Products</a>

<a href="orders.php">🛒 Orders</a>

<a href="customers.php">👥 Customers</a>

<a href="messages.php">📩 Messages</a>

<a href="categories.php">📂 Categories</a>

<a href="reports.php"
style="background:#2563eb;">
📊 Reports
</a>

<a href="logout.php">🚪 Logout</a>

</div>

<div class="col-lg-10 p-4">

<div class="header-box">

<div class="d-flex justify-content-between align-items-center flex-wrap">

<div>

<h2>💰 Sales Report</h2>

<p class="mb-0">
Monitor revenue, payments, completed orders and overall business performance.
</p>

</div>

<div class="mt-3">

<a href="reports.php"
class="btn btn-light btn-custom">
← Reports
</a>

<a href="print_report.php"
class="btn btn-warning btn-custom">
🖨 Print
</a>

</div>

</div>

</div>

<div class="row">

<div class="col-md-3 mb-4">

<div class="card stat-card bg-success">

<div class="card-body">

<h2>
RWF <?php echo number_format($total_revenue); ?>
</h2>

<p>Total Revenue</p>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card stat-card bg-primary">

<div class="card-body">

<h2>
<?php echo $paid_orders; ?>
</h2>

<p>Paid Orders</p>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card stat-card bg-warning text-dark">

<div class="card-body">

<h2>
<?php echo $pending_payments; ?>
</h2>

<p>Pending Payments</p>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card stat-card bg-danger">

<div class="card-body">

<h2>
<?php echo $completed_orders; ?>
</h2>

<p>Completed Orders</p>

</div>

</div>

</div>

</div>
    
    <div class="row">

<div class="col-lg-6 mb-4">

<div class="card-box">

<h3 class="mb-4">
📈 Sales Analytics
</h3>

<?php
$revenue_percent =
($total_revenue>0)
?
min(round(($total_revenue/3000000)*100),100)
:
0;

$completed_percent =
($total_orders>0)
?
round(($completed_orders/$total_orders)*100)
:
0;

$payment_percent =
($total_orders>0)
?
round(($paid_orders/$total_orders)*100)
:
0;
?>

<label>
<strong>Total Revenue</strong>
</label>

<div class="progress mb-4">

<div
class="progress-bar bg-success"
style="width:<?php echo $revenue_percent;?>%;">

<?php echo $revenue_percent;?>%

</div>

</div>

<label>
<strong>Completed Orders</strong>
</label>

<div class="progress mb-4">

<div
class="progress-bar bg-primary"
style="width:<?php echo $completed_percent;?>%;">

<?php echo $completed_percent;?>%

</div>

</div>

<label>
<strong>Successful Payments</strong>
</label>

<div class="progress">

<div
class="progress-bar bg-warning text-dark"
style="width:<?php echo $payment_percent;?>%;">

<?php echo $payment_percent;?>%

</div>

</div>

</div>

</div>

<div class="col-lg-6 mb-4">

<div class="card-box">

<h3 class="mb-4">
📋 Business Summary
</h3>

<table class="table">

<tr>

<td><strong>Total Revenue</strong></td>

<td>
RWF
<?php echo number_format($total_revenue);?>
</td>

</tr>

<tr>

<td><strong>Total Orders</strong></td>

<td>
<?php echo $total_orders;?>
</td>

</tr>

<tr>

<td><strong>Paid Orders</strong></td>

<td>
<?php echo $paid_orders;?>
</td>

</tr>

<tr>

<td><strong>Completed Orders</strong></td>

<td>
<?php echo $completed_orders;?>
</td>

</tr>

<tr>

<td><strong>Pending Payments</strong></td>

<td>
<?php echo $pending_payments;?>
</td>

</tr>

<tr>

<td><strong>Business Status</strong></td>

<td>

<?php

if($pending_payments>0)
{
echo "<span class='badge bg-warning text-dark'>
Pending Verifications
</span>";
}
else
{
echo "<span class='badge bg-success'>
All Payments Verified
</span>";
}

?>

</td>

</tr>

</table>

</div>

</div>

</div>

<div class="card-box">

<h3 class="mb-4">
🛒 Recent Sales Transactions
</h3>

<table class="table table-bordered table-hover table-striped">

<thead>

<tr>

<th>Order ID</th>

<th>Customer</th>

<th>Total Amount</th>

<th>Payment</th>

<th>Status</th>

<th>Date</th>

</tr>

</thead>

<tbody>
    
    <?php

if(mysqli_num_rows($recent_sales)>0)
{

while($sale=mysqli_fetch_assoc($recent_sales))
{

?>

<tr>

<td>
#<?php echo $sale['id']; ?>
</td>

<td>
<?php echo htmlspecialchars($sale['full_name'] ?? 'Unknown'); ?>
</td>

<td>
RWF <?php echo number_format($sale['total_amount']); ?>
</td>

<td>

<?php

if($sale['payment_status']=="Paid")
{

echo "<span class='badge bg-success'>Paid</span>";

}

elseif($sale['payment_status']=="Pending Verification")
{

echo "<span class='badge bg-warning text-dark'>
Pending
</span>";

}

else
{

echo "<span class='badge bg-secondary'>".$sale['payment_status']."</span>";

}

?>

</td>

<td>

<?php

if($sale['status']=="Delivered")
{

echo "<span class='badge bg-success'>Delivered</span>";

}

elseif($sale['status']=="Pending")
{

echo "<span class='badge bg-warning text-dark'>Pending</span>";

}

elseif($sale['status']=="Cancelled")
{

echo "<span class='badge bg-danger'>Cancelled</span>";

}

else
{

echo "<span class='badge bg-primary'>".$sale['status']."</span>";

}

?>

</td>

<td>

<?php

echo date(
"d M Y",
strtotime($sale['order_date'])
);

?>

</td>

</tr>

<?php

}

}

else

{

?>

<tr>

<td colspan="6"
class="text-center p-5 text-muted">

No sales records available.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<div class="row mt-4">

<div class="col-lg-4 mb-4">

<div class="card-box text-center">

<h4>💰 Total Revenue</h4>

<h2 class="text-success">

RWF
<?php echo number_format($total_revenue); ?>

</h2>

</div>

</div>

<div class="col-lg-4 mb-4">

<div class="card-box text-center">

<h4>🛒 Total Orders</h4>

<h2 class="text-primary">

<?php echo $total_orders; ?>

</h2>

</div>

</div>

<div class="col-lg-4 mb-4">

<div class="card-box text-center">

<h4>✅ Completed Orders</h4>

<h2 class="text-success">

<?php echo $completed_orders; ?>

</h2>

</div>

</div>

</div>
    
    <!-- Footer -->

<div class="card-box mt-4">

<div class="row text-center">

<div class="col-md-3">

<h5 class="text-primary">
📊 Revenue
</h5>

<p>
Monitor total income generated from all completed sales.
</p>

</div>

<div class="col-md-3">

<h5 class="text-success">
🛒 Orders
</h5>

<p>
Track customer orders and delivery performance.
</p>

</div>

<div class="col-md-3">

<h5 class="text-warning">
💳 Payments
</h5>

<p>
Monitor paid and pending payment verification.
</p>

</div>

<div class="col-md-3">

<h5 class="text-danger">
📈 Growth
</h5>

<p>
Analyze business performance using reports and analytics.
</p>

</div>

</div>

<hr>

<div class="text-center">

<p class="mb-1">

<strong>Dream Gadget Store Admin Panel</strong>

</p>

<p class="text-muted">

Sales Report Module

<br>

© <?php echo date("Y"); ?> Dream Gadget Store

</p>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

/* ===========================
   DASHBOARD STATISTICS
=========================== */

$product_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products"));

$order_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM orders"));

$customer_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM customers"));

$total_sales = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total_amount) AS total
FROM orders
"));

$total_revenue = $total_sales['total'] ?? 0;

$pending_payment = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
WHERE payment_status='Pending Verification'
"));

$completed_orders = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
WHERE status='Delivered'
"));

$recent_orders = mysqli_query($conn,"
SELECT
orders.id,
customers.full_name,
orders.total_amount,
orders.payment_status,
orders.order_date
FROM orders
LEFT JOIN customers
ON customers.id = orders.customer_id
ORDER BY orders.id DESC
LIMIT 10
");
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Reports Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
box-shadow:0 8px 25px rgba(0,0,0,.15);
margin-bottom:30px;
}

.stat-card{
border:none;
border-radius:18px;
overflow:hidden;
color:white;
box-shadow:0 8px 20px rgba(0,0,0,.15);
}

.stat-card .card-body{
padding:25px;
text-align:center;
}

.stat-card h2{
font-size:40px;
font-weight:bold;
}

.stat-card p{
margin:0;
font-size:18px;
}

.report-card{
background:white;
border:none;
border-radius:20px;
box-shadow:0 8px 20px rgba(0,0,0,.10);
transition:.3s;
height:100%;
}

.report-card:hover{
transform:translateY(-8px);
}

.report-card .card-body{
padding:30px;
text-align:center;
}

.report-card h4{
margin-top:15px;
font-weight:bold;
}

.report-icon{
font-size:60px;
}

.table-box{
background:white;
padding:25px;
border-radius:20px;
box-shadow:0 8px 20px rgba(0,0,0,.10);
margin-top:35px;
}

.table th{
background:#0f172a;
color:white;
}

.btn-report{
padding:12px 25px;
border-radius:12px;
font-weight:bold;
}

    .analytics-box{
background:white;
padding:25px;
border-radius:20px;
box-shadow:0 8px 20px rgba(0,0,0,.10);
margin-top:35px;
}

.analytics-box h4{
font-weight:bold;
margin-bottom:20px;
}

.progress{
height:24px;
border-radius:30px;
background:#e9ecef;
margin-bottom:20px;
}

.progress-bar{
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

<h2>📊 Reports Dashboard</h2>

<p class="mb-0">
Generate reports, monitor sales,
analyse customers and export business data.
</p>

</div>

<div class="mt-3">

<a href="dashboard.php"
class="btn btn-light btn-report">

🏠 Dashboard

</a>

<a href="print_report.php"
class="btn btn-warning btn-report">

🖨 Print

</a>

<a href="export_pdf.php"
class="btn btn-danger btn-report">

📄 PDF

</a>

<a href="export_excel.php"
class="btn btn-success btn-report">

📊 Excel

</a>

</div>

</div>

</div>

<div class="row">

<div class="col-md-3 mb-4">

<div class="card stat-card bg-primary">

<div class="card-body">

<h2><?php echo $product_count; ?></h2>

<p>Products</p>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card stat-card bg-success">

<div class="card-body">

<h2><?php echo $order_count; ?></h2>

<p>Orders</p>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card stat-card bg-warning text-dark">

<div class="card-body">

<h2><?php echo $customer_count; ?></h2>

<p>Customers</p>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card stat-card"
style="background:#7c3aed;">

<div class="card-body">

<h2>RWF <?php echo number_format($total_revenue); ?></h2>

<p>Total Revenue</p>

</div>

</div>

</div>

</div>
    
    <!-- REPORT SUMMARY -->

<div class="row mt-4">

<div class="col-lg-4 mb-4">

<div class="report-card">

<div class="card-body">

<div class="report-icon">📅</div>

<h4>Monthly Report</h4>

<hr>

<p><strong>Monthly Sales</strong></p>

<h3 class="text-primary">
RWF <?php echo number_format($monthly_sales_total); ?>
</h3>

<p>Total Orders</p>

<h5><?php echo $order_count; ?></h5>

<a href="monthly_report.php"
class="btn btn-primary w-100 mt-3">

Open Monthly Report

</a>

</div>

</div>

</div>

<div class="col-lg-4 mb-4">

<div class="report-card">

<div class="card-body">

<div class="report-icon">📈</div>

<h4>Sales Report</h4>

<hr>

<p><strong>Total Revenue</strong></p>

<h3 class="text-success">

RWF <?php echo number_format($total_revenue); ?>

</h3>

<p>Completed Orders</p>

<h5>

<?php echo $completed_orders; ?>

</h5>

<a href="sales_report.php"
class="btn btn-success w-100 mt-3">

Open Sales Report

</a>

</div>

</div>

</div>

<div class="col-lg-4 mb-4">

<div class="report-card">

<div class="card-body">

<div class="report-icon">👥</div>

<h4>Customer Report</h4>

<hr>

<p><strong>Total Customers</strong></p>

<h3 class="text-warning">

<?php echo $customer_count; ?>

</h3>

<p>Total Products</p>

<h5>

<?php echo $product_count; ?>

</h5>

<a href="customer_report.php"
class="btn btn-warning w-100 mt-3">

Open Customer Report

</a>

</div>

</div>

</div>

</div>

<div class="row">

<div class="col-lg-6 mb-4">

<div class="report-card">

<div class="card-body">

<div class="report-icon">💳</div>

    
<h4>Payment Report</h4>

<hr>

<p>Pending Verification</p>

<h2 class="text-danger">

<?php echo $pending_payment; ?>

</h2>

<a href="payment_report.php"
class="btn btn-danger w-100 mt-3">

Open Payment Report

</a>

</div>

</div>

</div>

<div class="col-lg-6 mb-4">

<div class="report-card">

<div class="card-body">

<div class="report-icon">📆</div>

<h4>Yearly Report</h4>

<hr>

<p>Total Revenue</p>

<h2 class="text-primary">

RWF <?php echo number_format($total_revenue); ?>

</h2>

<a href="yearly_report.php"
class="btn btn-primary w-100 mt-3">

Open Yearly Report

</a>

</div>

</div>

</div>

</div>
    
    <!-- RECENT ORDERS -->

<div class="table-box">

<h3 class="mb-4">🛒 Recent Orders</h3>

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>Order ID</th>

<th>Customer</th>

<th>Total</th>

<th>Payment</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($recent_orders)){ ?>

<tr>

<td>#<?php echo $row['id']; ?></td>

<td><?php echo $row['full_name']; ?></td>

<td>RWF <?php echo number_format($row['total_amount']); ?></td>

<td>

<?php

if($row['payment_status']=="Paid")
{
echo "<span class='badge bg-success'>Paid</span>";
}
elseif($row['payment_status']=="Pending Verification")
{
echo "<span class='badge bg-warning text-dark'>Pending</span>";
}
else
{
echo "<span class='badge bg-secondary'>".$row['payment_status']."</span>";
}

?>

</td>

<td>

<?php echo date("d M Y",strtotime($row['order_date'])); ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<br><br>

<div class="row">

<div class="col-lg-4 mb-4">

<div class="report-card">

<div class="card-body">

<h3>📦 Products</h3>

<hr>

<h1 class="text-primary">

<?php echo $product_count; ?>

</h1>

<p>Total Products Available</p>

</div>

</div>

</div>

<div class="col-lg-4 mb-4">

<div class="report-card">

<div class="card-body">

<h3>👥 Customers</h3>

<hr>

<h1 class="text-success">

<?php echo $customer_count; ?>

</h1>

<p>Registered Customers</p>

</div>

</div>

</div>

<div class="col-lg-4 mb-4">

<div class="report-card">

<div class="card-body">

<h3>💰 Revenue</h3>

<hr>

<h2 class="text-danger">

RWF <?php echo number_format($total_revenue); ?>

</h2>

<p>Total Business Revenue</p>

</div>
    
</div>
    
</div>
    
</div>
    
    <div class="row mt-4">

<div class="col-lg-6 mb-4">

<div class="analytics-box">

<h4>📈 Business Analytics</h4>

<label>Monthly Sales</label>

<div class="progress">

<div class="progress-bar bg-success"

style="width:<?php echo min(round(($total_revenue/3000000)*100),100); ?>%;">

<?php echo min(round(($total_revenue/3000000)*100),100); ?>%

</div>

</div>

<label>Completed Orders</label>

<div class="progress">

<div class="progress-bar bg-primary"

style="width:<?php echo ($order_count>0)?round(($completed_orders/$order_count)*100):0; ?>%;">

<?php echo ($order_count>0)?round(($completed_orders/$order_count)*100):0; ?>%

</div>

</div>

<label>Customer Growth</label>

<div class="progress">

<div class="progress-bar bg-warning"

style="width:<?php echo min($customer_count*10,100); ?>%;">

<?php echo min($customer_count*10,100); ?>%

</div>

</div>

</div>

</div>

<div class="col-lg-6 mb-4">

<div class="analytics-box">

<h4>📊 Business Summary</h4>

<p><strong>Total Revenue:</strong> RWF <?php echo number_format($total_revenue); ?></p>

<p><strong>Total Products:</strong> <?php echo $product_count; ?></p>

<p><strong>Total Customers:</strong> <?php echo $customer_count; ?></p>

<p><strong>Total Orders:</strong> <?php echo $order_count; ?></p>

<p><strong>Completed Orders:</strong> <?php echo $completed_orders; ?></p>

<p><strong>Pending Verification:</strong> <?php echo $pending_payment; ?></p>

</div>

</div>

</div>
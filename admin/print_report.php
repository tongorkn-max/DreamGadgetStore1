<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

/* ===========================
   REPORT STATISTICS
=========================== */

$product_count = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM products
"));

$order_count = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM orders
"));

$customer_count = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM customers
"));

$completed_orders = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM orders
WHERE status='Delivered'
"));

$pending_orders = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM orders
WHERE status='Pending'
"));

$total_sales = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total_amount) AS total
FROM orders
"));

$total_revenue = $total_sales['total'] ?? 0;

$orders = mysqli_query($conn,"
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
");
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Print Report</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

    <link rel="stylesheet" href="assets/css/admin.css">
<style>

body{

background:#f5f5f5;
padding:30px;

font-family:Arial,sans-serif;

}

.report{

background:white;

padding:40px;

border-radius:12px;

box-shadow:0 0 15px rgba(0,0,0,.12);

}

.header{

text-align:center;

margin-bottom:35px;

}

.header h1{

font-weight:bold;

margin-bottom:10px;

}

.header p{

margin:0;

color:#666;

}

.summary-card{

border:1px solid #ddd;

border-radius:10px;

padding:20px;

text-align:center;

margin-bottom:20px;

}

.summary-card h2{

font-size:34px;

font-weight:bold;

margin-bottom:10px;

}

.summary-card p{

margin:0;

font-size:18px;

}

.table th{

background:#0f172a;

color:white;

}

.footer{

margin-top:40px;

text-align:center;

color:#666;

font-size:14px;

}

.no-print{

margin-bottom:25px;

}

@media print{

.no-print{

display:none;

}

body{

background:white;

padding:0;

}

.report{

box-shadow:none;

border:none;

}

}

</style>

</head>

<body>

<div class="no-print text-end">

<a
href="reports.php"
class="btn btn-primary">

← Back to Reports

</a>

<button
onclick="window.print()"
class="btn btn-success">

🖨 Print Report

</button>

</div>

<div class="report">

<div class="header">

<h1>

Dream Gadget Store

</h1>

<h3>

Business Report

</h3>

<p>

Generated on

<?php echo date("d F Y h:i A"); ?>

</p>

</div>

<div class="row">

<div class="col-md-3">

<div class="summary-card">

<h2>

<?php echo $product_count; ?>

</h2>

<p>

Products

</p>

</div>

</div>

<div class="col-md-3">

<div class="summary-card">

<h2>

<?php echo $customer_count; ?>

</h2>

<p>

Customers

</p>

</div>

</div>

<div class="col-md-3">

<div class="summary-card">

<h2>

<?php echo $order_count; ?>

</h2>

<p>

Orders

</p>

</div>

</div>

<div class="col-md-3">

<div class="summary-card">

<h2>

RWF

<?php echo number_format($total_revenue); ?>

</h2>

<p>

Revenue

</p>

</div>

</div>

</div>
    
    <div class="row mt-4">

<div class="col-lg-6">

<div class="summary-card">

<h3 class="mb-4">

📊 Business Summary

</h3>

<table class="table">

<tr>

<td><strong>Total Products</strong></td>

<td><?php echo $product_count; ?></td>

</tr>

<tr>

<td><strong>Total Customers</strong></td>

<td><?php echo $customer_count; ?></td>

</tr>

<tr>

<td><strong>Total Orders</strong></td>

<td><?php echo $order_count; ?></td>

</tr>

<tr>

<td><strong>Completed Orders</strong></td>

<td><?php echo $completed_orders; ?></td>

</tr>

<tr>

<td><strong>Pending Orders</strong></td>

<td><?php echo $pending_orders; ?></td>

</tr>

<tr>

<td><strong>Total Revenue</strong></td>

<td>

RWF <?php echo number_format($total_revenue); ?>

</td>

</tr>

</table>

</div>

</div>

<div class="col-lg-6">

<div class="summary-card">

<h3 class="mb-4">

📈 Business Performance

</h3>

<?php

$completed_percent =
($order_count>0)
?
round(($completed_orders/$order_count)*100)
:
0;

$pending_percent =
($order_count>0)
?
round(($pending_orders/$order_count)*100)
:
0;

?>

<p>

<strong>Completed Orders</strong>

</p>

<div class="progress mb-4">

<div

class="progress-bar bg-success"

style="width:<?php echo $completed_percent; ?>%;">

<?php echo $completed_percent; ?>%

</div>

</div>

<p>

<strong>Pending Orders</strong>

</p>

<div class="progress">

<div

class="progress-bar bg-warning text-dark"

style="width:<?php echo $pending_percent; ?>%;">

<?php echo $pending_percent; ?>%

</div>

</div>

</div>

</div>

</div>

<div class="mt-5">

<h3 class="mb-3">

📋 Complete Order Report

</h3>

<table class="table table-bordered table-striped">

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

if(mysqli_num_rows($orders)>0)
{

while($order=mysqli_fetch_assoc($orders))
{

?>

<tr>

<td>

#<?php echo $order['id']; ?>

</td>

<td>

<?php echo htmlspecialchars($order['full_name'] ?? 'Unknown Customer'); ?>

</td>

<td>

RWF <?php echo number_format($order['total_amount']); ?>

</td>

<td>

<?php

if($order['payment_status']=="Paid")
{

echo "<span class='badge bg-success'>Paid</span>";

}

elseif($order['payment_status']=="Pending Verification")
{

echo "<span class='badge bg-warning text-dark'>Pending Verification</span>";

}

else

{

echo "<span class='badge bg-secondary'>".$order['payment_status']."</span>";

}

?>

</td>

<td>

<?php

if($order['status']=="Delivered")
{

echo "<span class='badge bg-success'>Delivered</span>";

}

elseif($order['status']=="Pending")
{

echo "<span class='badge bg-warning text-dark'>Pending</span>";

}

elseif($order['status']=="Cancelled")
{

echo "<span class='badge bg-danger'>Cancelled</span>";

}

else

{

echo "<span class='badge bg-primary'>".$order['status']."</span>";

}

?>

</td>

<td>

<?php echo date("d M Y",strtotime($order['order_date'])); ?>

</td>

</tr>

<?php

}

}

else

{

?>

<tr>

<td colspan="6" class="text-center p-4">

No orders found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

<div class="row mt-5">

<div class="col-md-4">

<div class="summary-card">

<h3 class="text-success">

RWF <?php echo number_format($total_revenue); ?>

</h3>

<p>Total Business Revenue</p>

</div>

</div>

<div class="col-md-4">

<div class="summary-card">

<h3>

<?php echo $order_count; ?>

</h3>

<p>Total Orders Processed</p>

</div>

</div>

<div class="col-md-4">

<div class="summary-card">

<h3>

<?php echo $customer_count; ?>

</h3>

<p>Total Registered Customers</p>

</div>

</div>

</div>
    
    <div class="footer">

<hr>

<p>

<strong>Dream Gadget Store</strong>

</p>

<p>

Business Report generated on

<strong>

<?php echo date("d F Y"); ?>

</strong>

at

<strong>

<?php echo date("h:i A"); ?>

</strong>

</p>

<p>

This report was generated automatically from the Dream Gadget Store Management System.

</p>

<p>

© <?php echo date("Y"); ?> Dream Gadget Store. All Rights Reserved.

</p>

</div>

</div>

<script>

window.onload=function(){

window.print();

};

</script>

</body>

</html>
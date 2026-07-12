<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$product_count=mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM products
"));

$order_count=mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
"));

$customer_count=mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM customers
"));

$completed_orders=mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
WHERE status='Delivered'
"));

$pending_orders=mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
WHERE status='Pending'
"));

$paid_orders=mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
WHERE payment_status='Paid'
"));

$total_sales=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total_amount) AS total
FROM orders
"));

$total_revenue=$total_sales['total'] ?? 0;

$orders=mysqli_query($conn,"
SELECT
orders.id,
customers.full_name,
customers.phone,
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

<title>Dream Gadget Store PDF Report</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/admin.css">
<style>

body{
background:white;
padding:40px;
font-family:Arial,sans-serif;
}

.header{
text-align:center;
margin-bottom:35px;
}

.header h1{
font-size:36px;
font-weight:bold;
margin-bottom:5px;
}

.header h3{
font-size:22px;
margin-bottom:10px;
}

.summary-card{
border:1px solid #ddd;
border-radius:10px;
padding:20px;
text-align:center;
margin-bottom:20px;
}

.table th{
background:#222;
color:white;
}

.footer{
margin-top:40px;
text-align:center;
font-size:14px;
color:#555;
}

@media print{

button{
display:none;
}

}

</style>

</head>

<body>

<div class="container">

<div class="header">

<h1>Dream Gadget Store</h1>

<h3>Business PDF Report</h3>

<p>

Generated on

<?php echo date("d F Y h:i A"); ?>

</p>

</div>

<div class="row">

<div class="col-md-3">

<div class="summary-card">

<h2><?php echo $product_count; ?></h2>

<p>Products</p>

</div>

</div>

<div class="col-md-3">

<div class="summary-card">

<h2><?php echo $customer_count; ?></h2>

<p>Customers</p>

</div>

</div>

<div class="col-md-3">

<div class="summary-card">

<h2><?php echo $order_count; ?></h2>

<p>Orders</p>

</div>

</div>

<div class="col-md-3">

<div class="summary-card">

<h2>

RWF <?php echo number_format($total_revenue); ?>

</h2>

<p>Revenue</p>

</div>

</div>

</div>
    
    <div class="row mt-4">

<div class="col-lg-6">

<div class="summary-card">

<h3 class="mb-4">

📊 Business Summary

</h3>

<table class="table table-bordered">

<tr>

<th>Total Products</th>

<td><?php echo $product_count; ?></td>

</tr>

<tr>

<th>Total Customers</th>

<td><?php echo $customer_count; ?></td>

</tr>

<tr>

<th>Total Orders</th>

<td><?php echo $order_count; ?></td>

</tr>

<tr>

<th>Completed Orders</th>

<td><?php echo $completed_orders; ?></td>

</tr>

<tr>

<th>Pending Orders</th>

<td><?php echo $pending_orders; ?></td>

</tr>

<tr>

<th>Paid Orders</th>

<td><?php echo $paid_orders; ?></td>

</tr>

<tr>

<th>Total Revenue</th>

<td>

<strong>

RWF <?php echo number_format($total_revenue); ?>

</strong>

</td>

</tr>

</table>

</div>

</div>

<div class="col-lg-6">

<div class="summary-card">

<h3 class="mb-4">

📈 Performance

</h3>

<?php

$completed_percent=
($order_count>0)
?
round(($completed_orders/$order_count)*100)
:
0;

$pending_percent=
($order_count>0)
?
round(($pending_orders/$order_count)*100)
:
0;

$paid_percent=
($order_count>0)
?
round(($paid_orders/$order_count)*100)
:
0;

?>

<p><strong>Completed Orders</strong></p>

<div class="progress mb-3">

<div

class="progress-bar bg-success"

style="width:<?php echo $completed_percent;?>%;">

<?php echo $completed_percent;?>%

</div>

</div>

<p><strong>Pending Orders</strong></p>

<div class="progress mb-3">

<div

class="progress-bar bg-warning text-dark"

style="width:<?php echo $pending_percent;?>%;">

<?php echo $pending_percent;?>%

</div>

</div>

<p><strong>Paid Orders</strong></p>

<div class="progress">

<div

class="progress-bar bg-primary"

style="width:<?php echo $paid_percent;?>%;">

<?php echo $paid_percent;?>%

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

<th>Phone</th>

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

while($row=mysqli_fetch_assoc($orders))
{

?>

<tr>

<td>

#<?php echo $row['id']; ?>

</td>

<td>

<?php echo htmlspecialchars($row['full_name'] ?? 'Unknown Customer'); ?>

</td>

<td>

<?php echo htmlspecialchars($row['phone'] ?? '-'); ?>

</td>

<td>

RWF <?php echo number_format($row['total_amount']); ?>

</td>

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

<?php

if($row['status']=="Delivered")
{

echo "<span class='badge bg-success'>Delivered</span>";

}

elseif($row['status']=="Pending")
{

echo "<span class='badge bg-warning text-dark'>Pending</span>";

}

elseif($row['status']=="Cancelled")
{

echo "<span class='badge bg-danger'>Cancelled</span>";

}

else

{

echo "<span class='badge bg-primary'>".$row['status']."</span>";

}

?>

</td>

<td>

<?php echo date("d M Y",strtotime($row['order_date'])); ?>

</td>

</tr>

<?php

}

}

else

{

?>

<tr>

<td colspan="7" class="text-center p-4">

No orders found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

<div class="footer">

<hr>

<p>

<strong>Dream Gadget Store</strong>

</p>

<p>

Business PDF Report generated on

<strong>

<?php echo date("d F Y"); ?>

</strong>

at

<strong>

<?php echo date("h:i A"); ?>

</strong>

</p>

<p>

© <?php echo date("Y"); ?> Dream Gadget Store. All Rights Reserved.

</p>

</div>
    
    <div class="text-center mt-4">

<button

class="btn btn-danger btn-lg"

onclick="window.print();">

🖨 Download / Save as PDF

</button>

<a

href="reports.php"

class="btn btn-primary btn-lg ms-2">

← Back to Reports

</a>

</div>

</div>

<script>

window.onload=function(){

setTimeout(function(){

window.print();

},500);

};

</script>

</body>

</html>
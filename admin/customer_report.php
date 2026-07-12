<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

/* ===========================
   CUSTOMER REPORT STATISTICS
=========================== */

$total_customers = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM customers
"));

$total_orders = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM orders
"));

$total_sales = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total_amount) AS total
FROM orders
"));

$total_revenue = $total_sales['total'] ?? 0;

$customers = mysqli_query($conn,"
SELECT
customers.id,
customers.full_name,
customers.email,
customers.phone,
customers.created_at,

COUNT(orders.id) AS total_orders,

COALESCE(SUM(orders.total_amount),0)
AS total_spent

FROM customers

LEFT JOIN orders
ON customers.id=orders.customer_id

GROUP BY customers.id

ORDER BY total_spent DESC
");
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Customer Report</title>

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
font-size:36px;
font-weight:bold;
}

.stat-card p{
margin:0;
font-size:18px;
}

.card-box{
background:white;
border-radius:18px;
padding:25px;
box-shadow:0 8px 20px rgba(0,0,0,.10);
margin-bottom:25px;
}

.table th{
background:#0f172a;
color:white;
}

.btn-custom{
padding:10px 22px;
border-radius:10px;
font-weight:bold;
}

.search-box{
background:white;
padding:20px;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,.10);
margin-bottom:25px;
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

<h2>👥 Customer Report</h2>

<p class="mb-0">

View customer registrations, spending,
orders and customer activity.

</p>

</div>

<div class="mt-3">

<a href="reports.php"
class="btn btn-light btn-custom">

← Reports

</a>

<a href="print_customer_report.php"
class="btn btn-warning btn-custom">

🖨 Print

</a>

</div>

</div>

</div>

<div class="row">

<div class="col-md-4 mb-4">

<div class="card stat-card bg-primary">

<div class="card-body">

<h2>

<?php echo $total_customers; ?>

</h2>

<p>Total Customers</p>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card stat-card bg-success">

<div class="card-body">

<h2>

<?php echo $total_orders; ?>

</h2>

<p>Total Orders</p>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card stat-card"
style="background:#7c3aed;">

<div class="card-body">

<h2>

RWF
<?php echo number_format($total_revenue); ?>

</h2>

<p>Total Revenue</p>

</div>

</div>

</div>

</div>
    
    <div class="search-box">

<form method="GET">

<div class="row">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by Customer Name, Email or Phone"
value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

</div>

<div class="col-md-2 d-grid">

<button
type="submit"
class="btn btn-primary">

🔍 Search

</button>

</div>

</div>

</form>

</div>

<?php

$search="";

if(isset($_GET['search']))
{
$search=mysqli_real_escape_string($conn,$_GET['search']);

$customers=mysqli_query($conn,"
SELECT
customers.id,
customers.full_name,
customers.email,
customers.phone,
customers.created_at,

COUNT(orders.id) AS total_orders,

COALESCE(SUM(orders.total_amount),0)
AS total_spent

FROM customers

LEFT JOIN orders
ON customers.id=orders.customer_id

WHERE
customers.full_name LIKE '%$search%'
OR customers.email LIKE '%$search%'
OR customers.phone LIKE '%$search%'

GROUP BY customers.id

ORDER BY total_spent DESC
");
}

?>

<div class="row">

<div class="col-lg-6 mb-4">

<div class="card-box">

<h3 class="mb-4">

📊 Customer Analytics

</h3>

<?php

$order_percent=
($total_orders>0)
?
min(round(($total_orders/20)*100),100)
:
0;

$customer_percent=
($total_customers>0)
?
min(round(($total_customers/20)*100),100)
:
0;

$revenue_percent=
($total_revenue>0)
?
min(round(($total_revenue/3000000)*100),100)
:
0;

?>

<label>

<strong>Registered Customers</strong>

</label>

<div class="progress mb-4">

<div
class="progress-bar bg-primary"
style="width:<?php echo $customer_percent;?>%;">

<?php echo $customer_percent;?>%

</div>

</div>

<label>

<strong>Customer Orders</strong>

</label>

<div class="progress mb-4">

<div
class="progress-bar bg-success"
style="width:<?php echo $order_percent;?>%;">

<?php echo $order_percent;?>%

</div>

</div>

<label>

<strong>Revenue Contribution</strong>

</label>

<div class="progress">

<div
class="progress-bar bg-warning text-dark"
style="width:<?php echo $revenue_percent;?>%;">

<?php echo $revenue_percent;?>%

</div>

</div>

</div>

</div>

<div class="col-lg-6 mb-4">

<div class="card-box">

<h3 class="mb-4">

📋 Customer Summary

</h3>

<table class="table">

<tr>

<td>

<strong>Total Customers</strong>

</td>

<td>

<?php echo $total_customers; ?>

</td>

</tr>

<tr>

<td>

<strong>Total Orders</strong>

</td>

<td>

<?php echo $total_orders; ?>

</td>

</tr>

<tr>

<td>

<strong>Total Revenue</strong>

</td>

<td>

RWF
<?php echo number_format($total_revenue); ?>

</td>

</tr>

<tr>

<td>

<strong>Top Customer</strong>

</td>

<td>

Highest Spending Customer

</td>

</tr>

<tr>

<td>

<strong>Status</strong>

</td>

<td>

<span class="badge bg-success">

Customer Database Active

</span>

</td>

</tr>

</table>

</div>

</div>

</div>

<div class="card-box">

<h3 class="mb-4">

👥 Customer List

</h3>

<table class="table table-bordered table-hover table-striped">

<thead>

<tr>

<th>ID</th>

<th>Customer</th>

<th>Email</th>

<th>Phone</th>

<th>Orders</th>

<th>Total Spent</th>

<th>Registered</th>

</tr>

</thead>

<tbody>
    
    <?php

if(mysqli_num_rows($customers)>0)
{

while($customer=mysqli_fetch_assoc($customers))
{

?>

<tr>

<td>

<?php echo $customer['id']; ?>

</td>

<td>

<?php echo htmlspecialchars($customer['full_name']); ?>

</td>

<td>

<?php echo htmlspecialchars($customer['email']); ?>

</td>

<td>

<?php echo htmlspecialchars($customer['phone']); ?>

</td>

<td>

<span class="badge bg-primary">

<?php echo $customer['total_orders']; ?>

</span>

</td>

<td>

<span class="text-success fw-bold">

RWF <?php echo number_format($customer['total_spent']); ?>

</span>

</td>

<td>

<?php

if(!empty($customer['created_at']))
{
echo date("d M Y",strtotime($customer['created_at']));
}
else
{
echo "-";
}

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

<td colspan="7" class="text-center text-muted p-5">

No customers found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

<div class="row mt-4">

<div class="col-lg-4 mb-4">

<div class="card-box text-center">

<h4>👥 Registered Customers</h4>

<h2 class="text-primary">

<?php echo $total_customers; ?>

</h2>

<p>Total customer accounts</p>

</div>

</div>

<div class="col-lg-4 mb-4">

<div class="card-box text-center">

<h4>🛒 Customer Orders</h4>

<h2 class="text-success">

<?php echo $total_orders; ?>

</h2>

<p>Total orders placed</p>

</div>

</div>

<div class="col-lg-4 mb-4">

<div class="card-box text-center">

<h4>💰 Customer Spending</h4>

<h2 class="text-danger">

RWF <?php echo number_format($total_revenue); ?>

</h2>

<p>Total customer purchases</p>

</div>

</div>

</div>
    
    <!-- Footer -->

<div class="card-box mt-4">

<div class="row text-center">

<div class="col-md-3">

<h5 class="text-primary">
👥 Customers
</h5>

<p>
Monitor customer registrations and account growth.
</p>

</div>

<div class="col-md-3">

<h5 class="text-success">
🛒 Orders
</h5>

<p>
Track the number of orders placed by customers.
</p>

</div>

<div class="col-md-3">

<h5 class="text-warning">
💰 Spending
</h5>

<p>
View how much customers have spent in your store.
</p>

</div>

<div class="col-md-3">

<h5 class="text-danger">
📊 Reports
</h5>

<p>
Generate customer reports for business analysis.
</p>

</div>

</div>

<hr>

<div class="text-center">

<p class="mb-1">

<strong>Dream Gadget Store Admin Panel</strong>

</p>

<p class="text-muted">

Customer Report Module

<br>

© <?php echo date("Y"); ?> Dream Gadget Store. All Rights Reserved.

</p>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
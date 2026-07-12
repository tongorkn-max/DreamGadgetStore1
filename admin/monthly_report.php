<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$current_month = isset($_GET['month']) ? $_GET['month'] : date("m");
$current_year  = isset($_GET['year']) ? $_GET['year'] : date("Y");

$monthly_orders = mysqli_query($conn,"
SELECT
orders.id,
customers.full_name,
orders.total_amount,
orders.payment_status,
orders.status,
orders.order_date
FROM orders
LEFT JOIN customers
ON customers.id = orders.customer_id
WHERE MONTH(order_date)='$current_month'
AND YEAR(order_date)='$current_year'
ORDER BY order_date DESC
");

$monthly_sales = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total_amount) AS total
FROM orders
WHERE MONTH(order_date)='$current_month'
AND YEAR(order_date)='$current_year'
"));

$total_monthly_sales = $monthly_sales['total'] ?? 0;

$total_orders = mysqli_num_rows($monthly_orders);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Monthly Report</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/admin.css">
<style>

body{
    background:#eef2f7;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,.10);
}

.table th{
    background:#212529;
    color:white;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="card shadow mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-5">

<label class="form-label">

<strong>Select Month</strong>

</label>

<select name="month" class="form-select">

<?php
for($m=1;$m<=12;$m++)
{
    $month_num=sprintf("%02d",$m);
?>

<option
value="<?php echo $month_num;?>"
<?php if($current_month==$month_num) echo "selected";?>>

<?php echo date("F",mktime(0,0,0,$m,1));?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-5">

<label class="form-label">

<strong>Select Year</strong>

</label>

<select name="year" class="form-select">

<?php

for($y=date("Y");$y>=2023;$y--)

{

?>

<option
value="<?php echo $y;?>"
<?php if($current_year==$y) echo "selected";?>>

<?php echo $y;?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-2 d-grid">

<label>&nbsp;</label>

<button class="btn btn-primary">

🔍 View Report

</button>

</div>

</div>

</form>

</div>

</div>

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>

📅

<?php echo date("F",mktime(0,0,0,$current_month,1)); ?>

<?php echo $current_year; ?>

Sales Report

</h2>

<a href="reports.php" class="btn btn-primary">

← Back to Reports

</a>

</div>

<div class="row mb-4">

<div class="col-md-6">

<div class="card">

<div class="card-body text-center">

<h5>Total Monthly Sales</h5>

<h2 class="text-success">

RWF <?php echo number_format($total_monthly_sales); ?>

</h2>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card">

<div class="card-body text-center">

<h5>Total Orders This Month</h5>

<h2 class="text-primary">

<?php echo $total_orders; ?>

</h2>

</div>

</div>

</div>

</div>

<div class="card">

<div class="card-header bg-dark text-white">

<h4 class="mb-0">

Monthly Orders

</h4>

</div>

<div class="card-body">

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

if(mysqli_num_rows($monthly_orders)>0)
{

while($row=mysqli_fetch_assoc($monthly_orders))
{

?>

<tr>

<td>#<?php echo $row['id']; ?></td>

<td><?php echo $row['full_name']; ?></td>

<td>RWF <?php echo number_format($row['total_amount']); ?></td>

<td><?php echo $row['payment_status']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo date("d M Y",strtotime($row['order_date'])); ?></td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="6" class="text-center text-muted p-4">

No orders found for this month.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>
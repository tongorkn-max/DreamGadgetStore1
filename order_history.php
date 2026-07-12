<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$orders = mysqli_query($conn,"
SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY id DESC
");

$order_count = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM orders
WHERE user_id='$user_id'
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.page-container{
    background:white;
    border-radius:20px;
    padding:35px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.page-title{
    font-size:40px;
    font-weight:bold;
    color:#0f172a;
}

.summary-card{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    border:none;
    border-radius:18px;
    padding:25px;
    margin-bottom:25px;
}

.table-container{
    background:white;
    border-radius:15px;
    overflow:hidden;
}

.table thead{
    background:#111827;
    color:white;
}

.table tbody tr:hover{
    background:#f8fafc;
}

.status-pending{
    background:#dc3545;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
}

.status-processing{
    background:#ffc107;
    color:black;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
}

.status-delivered{
    background:#198754;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container py-5">

<div class="page-container">

<h2 class="page-title">
📦 My Orders
</h2>

<p class="text-muted">
Track all your purchases from Dream Gadget Store.
</p>

<div class="row mb-4">

<div class="col-md-4">

<div class="summary-card">

<h2><?php echo $order_count; ?></h2>

<p class="mb-0">
Total Orders
</p>

</div>

</div>

</div>

<div class="table-container">

<table class="table table-hover align-middle mb-0">

<thead>

<tr>
<th>Order ID</th>
<th>Total Amount</th>
<th>Status</th>
<th>Date</th>
</tr>

</thead>

<tbody>

<?php while($order=mysqli_fetch_assoc($orders)){ ?>

<tr>

<td>
<strong>#<?php echo $order['id']; ?></strong>
</td>

<td>
RWF <?php echo number_format($order['total_amount']); ?>
</td>

<td>

<?php
if($order['status'] == 'Pending')
{
    echo '<span class="status-pending">Pending</span>';
}
elseif($order['status'] == 'Processing')
{
    echo '<span class="status-processing">Processing</span>';
}
elseif($order['status'] == 'Delivered')
{
    echo '<span class="status-delivered">Delivered</span>';
}
else
{
    echo $order['status'];
}
?>

</td>

<td>
<?php echo $order['order_date']; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
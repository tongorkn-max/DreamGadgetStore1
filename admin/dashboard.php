<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$product_count =
mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM products")
);

$order_count =
mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM orders")
);

$customer_count =
mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM customers")
);

$message_count =
mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM contact_messages
WHERE status='Unread'
")
);

$pending_payments =
mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM orders
WHERE payment_status='Pending Verification'
")
);

$sales = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT SUM(total_amount) as total_sales
FROM orders
")
);

$total_sales = $sales['total_sales'] ?? 0;

$monthly_sales = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT SUM(total_amount) AS total
FROM orders
WHERE MONTH(order_date)=MONTH(CURDATE())
AND YEAR(order_date)=YEAR(CURDATE())
")
);

$monthly_sales_total =
$monthly_sales['total'] ?? 0;

$monthly_sales_percent =
min(
round(($monthly_sales_total / 10000000) * 100),
100
);

$delivered_orders =
mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM orders
WHERE status='Delivered'
")
);

$order_completion =
($order_count > 0)
? round(($delivered_orders / $order_count) * 100)
: 0;

$customer_growth =
min(
round(($customer_count / 100) * 100),
100
);

$recent_orders = mysqli_query($conn,"
SELECT *
FROM orders
ORDER BY id DESC
LIMIT 5
");
?>

<!DOCTYPE html>

<html>
<head>

<title>Dream Gadget Store Admin Dashboard</title>

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

.dashboard-card{
    min-height:120px;
    border:none;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

.dashboard-card .card-body{
    height:100%;
    padding:20px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
}

.dashboard-card h2{
    font-size:34px;
    margin-bottom:8px;
    font-weight:bold;
}

.dashboard-card h3{
    font-size:26px;
    margin-bottom:8px;
    font-weight:bold;
    white-space:nowrap;
}

.dashboard-card p{
    margin:0;
    font-size:16px;
    font-weight:500;
}

.analytics-box{
    background:white;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

.analytics-box h4{
    margin-bottom:20px;
    font-weight:600;
}

.progress{
    height:22px;
    border-radius:30px;
}

.progress-bar{
    font-weight:bold;
}

.table{
    margin-bottom:0;
}

.table th{
    background:#0f172a;
    color:white;
}
.table-striped tbody tr:nth-of-type(odd){
    background:#f8fafc;
}

.table-hover tbody tr:hover{
    background:#e0edff;
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
.welcome-box .btn{
    border-radius:10px;
    padding:10px 18px;
    font-weight:bold;
}

@media (max-width:768px){

.sidebar{
    min-height:auto;
    padding:15px;
}

.sidebar h3{
    font-size:22px;
    text-align:center;
}

.sidebar a{
    text-align:center;
    padding:10px;
    font-size:15px;
}

.dashboard-card{
    min-height:110px;
}

.dashboard-card h2{
    font-size:26px;
}

.dashboard-card h3{
    font-size:18px;
}

.dashboard-card p{
    font-size:14px;
}

.welcome-box h2{
    font-size:24px;
}

.welcome-box p{
    font-size:14px;
}

.analytics-box{
    margin-bottom:20px;
}

.table{
    font-size:13px;
}

.welcome-box .d-flex{
    flex-direction:column;
    align-items:flex-start !important;
}

.welcome-box .btn{
    width:100%;
    margin-top:10px;
}

.welcome-box .btn.me-2{
    margin-right:0 !important;
}

}
</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<div class="col-lg-2 col-md-3 col-12 sidebar">

<h3>Dream Gadget Store</h3>

<hr>

<a href="dashboard.php">🏠 Dashboard</a>

<a href="products.php">📦 Products</a>

<a href="orders.php">🛒 Orders</a>

<a href="customers.php">👥 Customers</a>

<a href="messages.php">📩 Messages</a>

<a href="categories.php">📂 Categories</a>

<a href="reports.php">📊 Reports</a>

<a href="logout.php">🚪 Logout</a>
</div>

<div class="col-lg-10 col-md-9 col-12 p-3 p-md-4">

<div class="welcome-box">

<div class="d-flex justify-content-between align-items-center flex-wrap">

<div>

<h2>📊 Admin Dashboard</h2>

<p>
Welcome to Dream Gadget Store Administration Panel.
Manage products, customers, orders and monitor store performance.
</p>

<div class="mt-3 mt-md-0">

<a href="../index.php" class="btn btn-light fw-bold">
🏠 View Store
</a>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-6 col-md-2 mb-3">

<div class="card dashboard-card bg-primary text-white">

<div class="card-body">

<h2><?php echo $product_count; ?></h2>

<p>Products</p>

</div>

</div>

</div>

<div class="col-6 col-md-2 mb-3">

<div class="card dashboard-card bg-success text-white">

<div class="card-body">

<h2><?php echo $order_count; ?></h2>

<p>Orders</p>

</div>

</div>

</div>

<div class="col-6 col-md-2 mb-3">

<div class="card dashboard-card bg-warning text-dark">

<div class="card-body">

<h2><?php echo $customer_count; ?></h2>

<p>Customers</p>

</div>

</div>

</div>

<div class="col-6 col-md-2 mb-3">

<div class="card dashboard-card text-white"
style="background:#dc3545;">

<div class="card-body">

<h2><?php echo $message_count; ?></h2>

<p>Unread Messages</p>

</div>

</div>

</div>
<div class="col-6 col-md-2 mb-3">

<div class="card dashboard-card text-white"
style="background:#7c3aed;">

<div class="card-body">

<h2><?php echo $pending_payments; ?></h2>

<p>Pending Payments</p>

</div>

</div>

</div>
<div class="col-6 col-md-2 mb-3">

<div class="card dashboard-card text-white"
style="background:linear-gradient(135deg,#0f172a,#1e3a8a);">

<div class="card-body">

<h3 class="sales-total">
RWF<br><?php echo number_format($total_sales); ?>
</h3>

<p>RWF Total Sales</p>
</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-12 col-lg-6 mb-4">

<div class="analytics-box">

<h4>Sales Analytics</h4>

<label>Monthly Sales</label>

<div class="progress mb-3">

<div
class="progress-bar bg-success"
style="width:<?php echo $monthly_sales_percent; ?>%">

<?php echo $monthly_sales_percent; ?>%

</div>

</div>

<label>Order Completion</label>

<div class="progress mb-3">

<div
class="progress-bar bg-primary"
style="width:<?php echo $order_completion; ?>%">

<?php echo $order_completion; ?>%

</div>

</div>

<label>Customer Growth</label>

<div class="progress">

<div
class="progress-bar bg-warning"
style="width:<?php echo $customer_growth; ?>%">

<?php echo $customer_growth; ?>%

</div>

</div>
</div>

</div>

<div class="col-12 col-lg-6 mb-4">

<div class="analytics-box">

<h4>Store Summary</h4>

<p><strong>Total Products:</strong> <?php echo $product_count; ?></p>

<p><strong>Total Orders:</strong> <?php echo $order_count; ?></p>

<p><strong>Total Customers:</strong> <?php echo $customer_count; ?></p>

<p><strong>Total Revenue:</strong>
RWF <?php echo number_format($total_sales); ?>
</p>

</div>

</div>

</div>

<div class="analytics-box mt-4">

<h4>Recent Orders</h4>

<table class="table table-bordered table-striped table-hover">

<tr>

<th>Order ID</th>

<th>Total Amount</th>

<th>Status</th>

</tr>

<?php while($order = mysqli_fetch_assoc($recent_orders)){ ?>

<tr>

<td>#<?php echo $order['id']; ?></td>

<td>
RWF <?php echo number_format($order['total_amount']); ?>
</td>

<td>
<?php echo $order['status']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</div>

</body>
</html>

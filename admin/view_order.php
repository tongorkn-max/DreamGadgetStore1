<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$id = $_GET['id'];

$order = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT orders.*,
customers.full_name,
customers.email,
customers.phone,
customers.address
FROM orders
INNER JOIN customers
ON orders.customer_id = customers.id
WHERE orders.id='$id'
"));

$items = mysqli_query($conn,"
SELECT order_items.*,
products.product_name
FROM order_items
INNER JOIN products
ON order_items.product_id = products.id
WHERE order_items.order_id='$id'
");
?>

<!DOCTYPE html>

<html>
<head>

<title>Order Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

.card-box{
    border:none;
    border-radius:18px;
    overflow:hidden;
    background:white;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

.card-header-custom{
    background:linear-gradient(135deg,#1e3a8a,#2563eb);
    color:white;
    padding:15px 20px;
    font-weight:600;
    border-radius:18px 18px 0 0;
}

.table-dark{
    background:#0f172a;
}

.badge{
    padding:8px 12px;
    font-size:13px;
}

.summary-card{
    background:linear-gradient(135deg,#1e3a8a,#2563eb);
    color:white;
}

.status-box{
    padding:12px;
    border-radius:12px;
    background:#f8fafc;
    margin-top:10px;
}

.action-btns .btn{
    margin-right:8px;
    margin-bottom:8px;
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

<a href="logout.php">🚪 Logout</a>

</div>

<div class="col-md-10 content">

<div class="welcome-box">

<h2>📦 Order Details #<?php echo $id; ?></h2>

<p class="mb-0">
View complete customer order information and manage order status.
</p>

</div>

<div class="row">

<div class="col-md-8">

<div class="card card-box mb-4">

<div class="card-header-custom">
👤 Customer Information
</div>

<div class="card-body">

<hr>

<p>
<strong>Name:</strong>
<?php echo $order['full_name']; ?>
</p>

<p>
<strong>Email:</strong>
<?php echo $order['email']; ?>
</p>

<p>
<strong>Phone:</strong>
<?php echo $order['phone']; ?>
</p>

<p>
<strong>Address:</strong>
<?php echo $order['address']; ?>
</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card card-box summary-card">

<div class="card-body">

<h5>📋 Order Summary</h5>

<hr>

<p>
<strong>Order ID:</strong>
#<?php echo $id; ?>
</p>

<p>
<strong>Total Amount:</strong><br>
RWF <?php echo number_format($order['total_amount']); ?>
</p>
<p>
<strong>Payment Method:</strong><br>
<?php echo $order['payment_method']; ?>
</p>

<p>
<strong>Mobile Money Number:</strong><br>
<?php echo $order['payment_phone']; ?>
</p>

<p>
<strong>Transaction ID:</strong><br>
<?php echo $order['transaction_id']; ?>
</p>

<p>
<strong>Payment Status:</strong><br>

<?php
if($order['payment_status'] == 'Pending Verification')
{
    echo '<span class="badge bg-warning text-dark">Pending Verification</span>';
}
elseif($order['payment_status'] == 'Paid')
{
    echo '<span class="badge bg-success">Paid</span>';
}
else
{
    echo '<span class="badge bg-danger">Rejected</span>';
}
?>
</p>
<p>
<strong>Status:</strong><br>

<?php
if($order['status'] == 'Pending')
{
    echo '<span class="badge bg-danger">Pending</span>';
}
elseif($order['status'] == 'Processing')
{
    echo '<span class="badge bg-warning text-dark">Processing</span>';
}
elseif($order['status'] == 'Delivered')
{
    echo '<span class="badge bg-success">Delivered</span>';
}
else
{
    echo '<span class="badge bg-secondary">'.$order['status'].'</span>';
}
?>

</p>

</div>

</div>

</div>

</div>

<div class="card card-box mb-4">

<div class="card-header-custom">
🛍 Ordered Products
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover">

<thead class="table-dark">

<tr>
<th>Product</th>
<th>Quantity</th>
<th>Price</th>
</tr>

</thead>

<tbody>

<?php while($item=mysqli_fetch_assoc($items)){ ?>

<tr>

<td><?php echo $item['product_name']; ?></td>

<td><?php echo $item['quantity']; ?></td>

<td>
RWF <?php echo number_format($item['price']); ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<div class="card card-box">

<div class="card-header-custom">
⚙ Update Order Status
</div>
<a href="update_payment_status.php?id=<?php echo $id; ?>&status=Paid"
class="btn btn-success">
💳 Mark Paid
</a>

<a href="update_payment_status.php?id=<?php echo $id; ?>&status=Rejected"
class="btn btn-danger">
❌ Reject Payment
</a>
<div class="card-body action-btns">
<a href="update_order_status.php?id=<?php echo $id; ?>&status=Processing"
class="btn btn-warning">
Processing </a>

<a href="update_order_status.php?id=<?php echo $id; ?>&status=Delivered"
class="btn btn-success">
Delivered </a>

<a href="update_order_status.php?id=<?php echo $id; ?>&status=Cancelled"
class="btn btn-danger">
Cancelled </a>

<a href="orders.php"
class="btn btn-secondary">
Back To Orders </a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>

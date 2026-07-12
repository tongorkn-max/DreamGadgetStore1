<?php

include("config/db.php");

$order_id = $_GET['id'];

$order = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT transaction_id
FROM orders
WHERE id='$order_id'
")
);

?>

<!DOCTYPE html>
<html>

<head>

<title>Order Successful</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.success-section{
    padding:70px 0;
}

.success-card{
    background:white;
    border-radius:25px;
    padding:50px;
    text-align:center;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.success-icon{
    font-size:80px;
    margin-bottom:20px;
}

.order-id-box{
    background:#f8fafc;
    border-left:5px solid #22c55e;
    padding:20px;
    border-radius:15px;
    margin:25px 0;
}

.transaction-box{
    background:#eff6ff;
    border-left:5px solid #2563eb;
    padding:20px;
    border-radius:15px;
    margin:20px 0;
}

.btn-shop{
    background:#2563eb;
    border:none;
    padding:12px 30px;
    border-radius:10px;
    font-weight:bold;
}

.btn-shop:hover{
    background:#1d4ed8;
}

.btn-orders{
    padding:12px 30px;
    border-radius:10px;
    font-weight:bold;
}

.btn-print{
    background:#16a34a;
    border:none;
    color:white;
    padding:12px 30px;
    border-radius:10px;
    font-weight:bold;
}

.btn-print:hover{
    background:#15803d;
    color:white;
}

@media print{

body *{
visibility:hidden;
}

.receipt-container,
.receipt-container *{
visibility:visible;
}

.receipt-container{
position:absolute;
left:0;
top:0;
width:100%;
box-shadow:none !important;
}

.btn,
.navbar{
display:none !important;
}

body{
background:white !important;
}

}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container success-section">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="success-card receipt-container">

<div class="success-icon">
✅
</div>

<h1 class="text-success mb-3">
Order Placed Successfully!
</h1>

<p class="lead text-muted">
Thank you for shopping with Dream Gadget Store.
Your order has been received and is now being processed.
</p>

<div class="order-id-box">

<h4>
Order ID: <strong>#<?php echo $order_id; ?></strong>
</h4>

<p class="mb-0">
You can track your order from the My Orders page.
</p>

</div>

<div class="transaction-box">

<h5 class="text-primary">
💳 Transaction ID
</h5>

<h4>
<?php echo $order['transaction_id']; ?>
</h4>

<p class="mb-0 text-muted">
Keep this Transaction ID for payment verification and support.
</p>

</div>

<div class="row mt-4">

<div class="col-md-4 mb-3">

<div class="border rounded p-3">
📦<br>
Order Received
</div>

</div>

<div class="col-md-4 mb-3">

<div class="border rounded p-3">
🚚<br>
Processing & Shipping
</div>

</div>

<div class="col-md-4 mb-3">

<div class="border rounded p-3">
🎉<br>
Delivery
</div>

</div>

</div>

<div class="mt-5">

<button
onclick="window.print();"
class="btn btn-print me-2">

🖨️ Print Receipt

</button>

<a href="products.php"
class="btn btn-shop text-white me-2">

🛒 Continue Shopping

</a>

<a href="order_history.php"
class="btn btn-outline-primary btn-orders">

📋 My Orders

</a>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
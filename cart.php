<?php
session_start();
include("config/db.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dream Gadget Store - Shopping Cart</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.cart-container{
    background:white;
    border-radius:25px;
    padding:35px;
    margin-top:40px;
    margin-bottom:40px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.page-title{
    font-size:48px;
    font-weight:bold;
    color:#071a52;
}

.page-subtitle{
    color:#6c757d;
    margin-bottom:30px;
}

.cart-card{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    border-radius:20px;
    padding:25px;
    margin-bottom:30px;
}

.cart-card h2{
    font-size:40px;
    font-weight:bold;
}

.table{
    border-radius:15px;
    overflow:hidden;
}

.table thead{
    background:#071a52;
    color:white;
}

.table th{
    padding:15px;
}

.table td{
    vertical-align:middle;
}

.qty-input{
    width:90px;
}

.grand-total{
    background:#071a52;
    color:white;
    font-size:24px;
    font-weight:bold;
    border-radius:15px;
    padding:20px;
    text-align:right;
}

.btn-update{
    border-radius:10px;
    font-weight:bold;
}

.btn-remove{
    border-radius:10px;
}

.action-buttons{
    margin-top:25px;
}

.action-buttons .btn{
    border-radius:12px;
    padding:12px 25px;
    font-weight:bold;
}

.empty-cart{
    text-align:center;
    padding:50px;
}

.empty-cart h3{
    color:#6c757d;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container">

<div class="cart-container">

<h1 class="page-title">🛒 Shopping Cart</h1>

<p class="page-subtitle">
Review your selected items before checkout.
</p>

<?php
$cart_items = 0;

if(isset($_SESSION['cart']))
{
    $cart_items = array_sum($_SESSION['cart']);
}
?>

<div class="row mb-4">

<div class="col-md-4">

<div class="cart-card">

<h2><?php echo $cart_items; ?></h2>

<p class="mb-0">Items In Cart</p>

</div>

</div>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php

$grand_total = 0;

if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)
{
    foreach($_SESSION['cart'] as $id => $qty)
    {
        $query = mysqli_query($conn,"SELECT * FROM products WHERE id='$id'");
        $product = mysqli_fetch_assoc($query);

        $total = $product['price'] * $qty;
        $grand_total += $total;
?>

<tr>

<td>
<strong>
<?php echo $product['product_name']; ?>
</strong>
</td>

<td>
RWF <?php echo number_format($product['price']); ?>
</td>

<td>

<form action="update_cart.php" method="POST" class="d-flex gap-2">

<input
type="hidden"
name="id"
value="<?php echo $id; ?>">

<input
type="number"
name="qty"
value="<?php echo $qty; ?>"
min="1"
class="form-control qty-input">

<button class="btn btn-warning btn-sm btn-update">
Update
</button>

</form>

</td>

<td>
<strong>
RWF <?php echo number_format($total); ?>
</strong>
</td>

<td>

<a
href="remove_from_cart.php?id=<?php echo $id; ?>"
class="btn btn-danger btn-sm btn-remove">
Remove
</a>

</td>

</tr>

<?php
    }
}
else
{
?>

<tr>

<td colspan="5">

<div class="empty-cart">

<h1>🛒</h1>

<h3>Your Cart Is Empty</h3>

<p class="text-muted">
Add products to start shopping.
</p>

</div>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

<div class="grand-total mt-4">

Grand Total:
RWF <?php echo number_format($grand_total); ?>

</div>

<div class="action-buttons">

<a href="products.php" class="btn btn-primary">
← Continue Shopping
</a>

<?php if($grand_total > 0){ ?>

<a href="checkout.php" class="btn btn-success">
Proceed To Checkout →
</a>

<?php } ?>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
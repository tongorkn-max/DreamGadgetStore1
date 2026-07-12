<?php
session_start();
include("config/db.php");

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$payment_method = $_POST['payment_method'];
$payment_phone = $_POST['payment_phone'];
$transaction_id =
"TXN".date("YmdHis").rand(100,999);

mysqli_query($conn,"
INSERT INTO customers
(full_name,email,phone,address)
VALUES
('$full_name','$email','$phone','$address')
");

$customer_id = mysqli_insert_id($conn);

$grand_total = 0;

foreach($_SESSION['cart'] as $id => $qty)
{
    $product_query = mysqli_query($conn,
    "SELECT * FROM products WHERE id='$id'");

    $product = mysqli_fetch_assoc($product_query);

    $grand_total += ($product['price'] * $qty);
}

$user_id = isset($_SESSION['user_id'])
? $_SESSION['user_id']
: NULL;

mysqli_query($conn,"
INSERT INTO orders
(
customer_id,
user_id,
total_amount,
payment_method,
payment_phone,
transaction_id,
payment_status
)
VALUES
(
'$customer_id',
'$user_id',
'$grand_total',
'$payment_method',
'$payment_phone',
'$transaction_id',
'Pending Verification'
)
");

$order_id = mysqli_insert_id($conn);

foreach($_SESSION['cart'] as $id => $qty)
{
    $product_query = mysqli_query($conn,
    "SELECT * FROM products WHERE id='$id'");

    $product = mysqli_fetch_assoc($product_query);

    mysqli_query($conn,"
    INSERT INTO order_items
    (order_id,product_id,quantity,price)
    VALUES
    ('$order_id','$id','$qty','".$product['price']."')
    ");
}

unset($_SESSION['cart']);

header("Location: order_success.php?id=".$order_id);
exit();
?>
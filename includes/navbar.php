<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}

$cart_count = 0;
$reply_count = 0;

if(isset($_SESSION['cart']))
{
    foreach($_SESSION['cart'] as $item)
    {
        if(is_array($item) && isset($item['qty']))
        {
            $cart_count += $item['qty'];
        }
        else
        {
            $cart_count++;
        }
    }
}

if(isset($_SESSION['user_id']))
{
    include("config/db.php");

    $email = $_SESSION['user_email'];

    $reply_query = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM contact_messages
    WHERE email='$email'
    AND TRIM(admin_reply) <> ''
    AND admin_reply IS NOT NULL
    AND reply_status='Unread'
    ");

    $reply_data = mysqli_fetch_assoc($reply_query);

    $reply_count = $reply_data['total'];
}
?>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.custom-navbar{
background:linear-gradient(135deg,#0f172a,#1e3a8a,#2563eb);
padding:12px 0;
box-shadow:0 5px 20px rgba(0,0,0,.15);
position:sticky;
top:0;
z-index:9999;
}

.navbar-brand{
font-size:26px;
font-weight:800;
color:#fff !important;
}

.nav-link{
color:white !important;
font-weight:600;
margin:0 5px;
transition:.3s;
}

.nav-link:hover{
color:#ffc107 !important;
}

.cart-badge{
font-size:11px;
padding:4px 8px;
border-radius:50px;
margin-left:5px;
}

.mobile-bottom-nav{
display:none;
}

@media(max-width:768px){

.navbar-brand{
font-size:20px;
}

.nav-link{
padding:12px 0;
border-bottom:1px solid rgba(255,255,255,.1);
}


.mobile-bottom-nav{
display:none;
}

@media screen and (max-width:768px){

.mobile-bottom-nav{
display:flex !important;
justify-content:space-between;
align-items:center;
position:fixed !important;
bottom:0 !important;
left:0 !important;
right:0 !important;
width:100% !important;
height:70px !important;
background:#ffffff !important;
border-top:1px solid #e5e7eb;
box-shadow:0 -3px 15px rgba(0,0,0,.12);
z-index:99999999 !important;
padding:0 !important;
margin:0 !important;
}

.mobile-bottom-nav a{
flex:1;
text-align:center;
text-decoration:none;
color:#2563eb !important;
font-size:11px;
font-weight:700;
padding-top:8px;
}

.mobile-bottom-nav i{
display:block;
font-size:22px;
margin-bottom:4px;
}

body{
padding-bottom:75px !important;
}
}


</style>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">

<div class="container">

<a class="navbar-brand" href="index.php">
🛒 Dream Gadget Store
</a>

<button
class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarNav">

<ul class="navbar-nav me-auto">

<li class="nav-item">
<a class="nav-link" href="index.php">
🏠 Home
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="products.php">
📱 Products
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="categories.php">
📂 Categories
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="about.php">
ℹ️ About
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="contact.php">
📞 Contact
</a>
</li>

</ul>

<ul class="navbar-nav">

<li class="nav-item">
<a class="nav-link" href="cart.php">
🛒 Cart

<?php if($cart_count > 0){ ?>

<span class="badge bg-danger cart-badge">
<?php echo $cart_count; ?>
</span>

<?php } ?>

</a>
</li>

<?php if(isset($_SESSION['user_id'])){ ?>

<li class="nav-item">
<a class="nav-link" href="order_history.php">
📦 My Orders
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="customer_messages.php">
📩 Replies

<?php if($reply_count > 0){ ?>

<span class="badge bg-danger cart-badge">
<?php echo $reply_count; ?>
</span>

<?php } ?>

</a>
</li>

<li class="nav-item">
<a class="nav-link" href="customer_logout.php">
🚪 Logout
</a>
</li>

<?php } else { ?>

<li class="nav-item">
<a class="nav-link" href="login.php">
🔑 Login
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="register.php">
📝 Register
</a>
</li>

<li class="nav-item">
<a class="nav-link text-warning fw-bold" href="admin/login.php">
⚙️ Admin
</a>
</li>

<?php } ?>

</ul>

</div>

</div>

</nav>

<div class="mobile-bottom-nav">

<a href="index.php">
<i class="fas fa-home"></i>
Home
</a>

<a href="products.php">
<i class="fas fa-mobile-alt"></i>
Products
</a>

<a href="cart.php">
<i class="fas fa-shopping-cart"></i>

<?php if($cart_count > 0){ ?>
<span class="badge bg-danger">
<?php echo $cart_count; ?>
</span>
<?php } ?>

<br>
Cart
</a>

<a href="order_history.php">
<i class="fas fa-box"></i>
Orders
</a>

<a href="<?php echo isset($_SESSION['user_id']) ? 'customer_messages.php' : 'login.php'; ?>">
<i class="fas fa-user"></i>
Account
</a>

</div>

<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$product_count = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM products")
);

if(isset($_GET['search']) && !empty($_GET['search']))
{
    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $products = mysqli_query($conn,"
    SELECT * FROM products
    WHERE id LIKE '%$search%'
    OR product_name LIKE '%$search%'
    ORDER BY id DESC
    ");
}
else
{
    $products = mysqli_query($conn,"
    SELECT * FROM products
    ORDER BY id DESC
    ");
}
?>

<!DOCTYPE html>

<html>
<head>

<title>Manage Products</title>

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

.welcome-box h2{
    margin-bottom:8px;
}

.welcome-box p{
    margin-bottom:0;
}

.card-box{
    border:none;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

.product-img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:10px;
}

.table{
    background:white;
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

<a href="messages.php">📩 Messages</a>
    
 <a href="reports.php">📊 Reports</a>

<a href="logout.php">🚪 Logout</a>

</div>

<div class="col-md-10 content">

<div class="welcome-box">

<h2>📦 Manage Products</h2>

<p>
Manage all products available in Dream Gadget Store.
</p>

</div>

<form method="GET" class="mb-4">

<div class="row">

<div class="col-md-8">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by Product ID or Product Name"
value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

</div>

<div class="col-md-2">

<button
type="submit"
class="btn btn-primary w-100">
Search
</button>

</div>

<div class="col-md-2">

<a href="products.php"
class="btn btn-secondary w-100">
Reset
</a>

</div>

</div>

</form>

<div class="row mb-4">

<div class="col-md-3">

<div class="card card-box bg-primary text-white">

<div class="card-body">

<h2><?php echo $product_count; ?></h2>

<p>Total Products</p>

</div>

</div>

</div>

</div>

<a href="add_product.php" class="btn btn-success mb-3">
➕ Add New Product
</a>

<div class="card card-box">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Image</th>
<th>Product Name</th>
<th>Price</th>
<th>Stock</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($products)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>
<img
src="../assets/images/<?php echo $row['image']; ?>"
class="product-img">
</td>

<td>
<strong>
<?php echo $row['product_name']; ?>
</strong>
</td>

<td>
RWF <?php echo number_format($row['price']); ?>
</td>

<td>

<span class="badge bg-success">
<?php echo $row['stock']; ?>
</span>

</td>

<td>

<a
href="edit_product.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a
href="delete_product.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this product?')">
Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>

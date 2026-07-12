<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

if(isset($_POST['save']))
{
    $name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category_id'];

    $image = $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../assets/images/".$image
    );

    mysqli_query($conn,"
    INSERT INTO products
    (category_id,product_name,description,price,image,stock)
    VALUES
    ('$category','$name','$description','$price','$image','$stock')
    ");

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Product</title>

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
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

.form-control,
.form-select{
    border-radius:12px;
    border:1px solid #dbeafe;
    padding:12px;
}

.form-control:focus,
.form-select:focus{
    border-color:#2563eb;
    box-shadow:0 0 10px rgba(37,99,235,0.15);
}

.btn-success,
.btn-secondary{
    border:none;
    border-radius:12px;
    padding:10px 18px;
    font-weight:600;
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

<a href="logout.php">🚪 Logout</a>

</div>

<div class="col-md-10 content">

<div class="welcome-box">

<h2>📦 Add New Product</h2>

<p class="mb-0">
Add a new product to Dream Gadget Store inventory and keep your store updated.
</p>

</div>

<div class="card card-box">

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">
Product Name
</label>

<input
type="text"
name="product_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">
Description
</label>

<textarea
name="description"
class="form-control"
rows="4"
required></textarea>

</div>

<div class="row">

<div class="col-md-6">

<div class="mb-3">

<label class="form-label">
Price (RWF)
</label>

<input
type="number"
name="price"
class="form-control"
required>

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label class="form-label">
Stock Quantity
</label>

<input
type="number"
name="stock"
class="form-control"
required>

</div>

</div>

</div>

<div class="mb-3">

<label class="form-label">
Category
</label>

<select
name="category_id"
class="form-select"
required>

<option value="">
Select Category
</option>

<?php
$cat = mysqli_query($conn,"SELECT * FROM categories");

while($c = mysqli_fetch_assoc($cat))
{
?>

<option value="<?php echo $c['id']; ?>">
<?php echo $c['category_name']; ?>
</option>

<?php
}
?>

</select>

</div>

<div class="mb-4">

<label class="form-label">
Product Image
</label>

<input
type="file"
name="image"
class="form-control"
required>

</div>

<button
name="save"
class="btn btn-success">
💾 Save Product
</button>

<a href="products.php"
class="btn btn-secondary">
← Back to Products
</a>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
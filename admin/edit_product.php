<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$id = $_GET['id'];

$product = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM products WHERE id='$id'")
);

if(isset($_POST['update']))
{
    $name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category_id'];

    if(!empty($_FILES['image']['name']))
    {
        $image = $_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/images/".$image
        );

        mysqli_query($conn,"
        UPDATE products SET
        category_id='$category',
        product_name='$name',
        description='$description',
        price='$price',
        stock='$stock',
        image='$image'
        WHERE id='$id'
        ");
    }
    else
    {
        mysqli_query($conn,"
        UPDATE products SET
        category_id='$category',
        product_name='$name',
        description='$description',
        price='$price',
        stock='$stock'
        WHERE id='$id'
        ");
    }

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Product</title>

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
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

.form-control,
.form-select{
    border-radius:12px;
}

.product-image{
    width:220px;
    height:220px;
    object-fit:cover;
    border-radius:15px;
    border:4px solid #e5e7eb;
    padding:8px;
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

<a href="logout.php">🚪 Logout</a>

</div>

<div class="col-md-10 content">

<div class="welcome-box">

<h2>✏️ Edit Product</h2>

<p class="mb-0">
Update product information, stock quantity, category and image.
</p>

</div>

<div class="card card-box">

<div class="card-body p-4">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">
Product Name
</label>

<input
type="text"
name="product_name"
class="form-control"
value="<?php echo $product['product_name']; ?>"
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
required><?php echo $product['description']; ?></textarea>

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
value="<?php echo $product['price']; ?>"
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
value="<?php echo $product['stock']; ?>"
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

<?php
$cats = mysqli_query($conn,"SELECT * FROM categories");

while($cat = mysqli_fetch_assoc($cats))
{
?>

<option
value="<?php echo $cat['id']; ?>"
<?php if($cat['id']==$product['category_id']) echo "selected"; ?>>

<?php echo $cat['category_name']; ?>

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">

<label class="form-label">
Current Product Image
</label>

<br>

<img
src="../assets/images/<?php echo $product['image']; ?>"
class="product-image mb-3">

</div>

<div class="mb-4">

<label class="form-label">
Upload New Image (Optional)
</label>

<input
type="file"
name="image"
class="form-control">

</div>

<button
name="update"
class="btn btn-success">
💾 Update Product
</button>

<a href="products.php"
class="btn btn-secondary">
← Back To Products
</a>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>

<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$total_messages = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM contact_messages
")
);

$unread_messages = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM contact_messages
WHERE status='Unread'
")
);

$messages = mysqli_query($conn,"
SELECT *
FROM contact_messages
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Customer Messages</title>

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

.stat-card{
    border:none;
    border-radius:18px;
    color:white;
    box-shadow:0 6px 20px rgba(0,0,0,0.15);
}

.table{
    margin-bottom:0;
}

.table-dark{
    background:#0f172a;
}

.badge{
    padding:8px 12px;
    font-size:12px;
}

.btn-primary,
.btn-danger{
    border:none;
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

<h2>📩 Customer Messages</h2>

<p class="mb-0">
Manage customer inquiries and support requests from your customers.
</p>

</div>

<div class="row mb-4">

<div class="col-md-3">

<div class="card stat-card bg-primary">

<div class="card-body">

<h2><?php echo $total_messages; ?></h2>

<p class="mb-0">Total Messages</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card stat-card bg-danger">

<div class="card-body">

<h2><?php echo $unread_messages; ?></h2>

<p class="mb-0">Unread Messages</p>

</div>

</div>

</div>

</div>

<div class="card card-box">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($messages)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['subject']; ?></td>

<td>

<?php
if($row['status']=='Unread')
{
echo '<span class="badge bg-danger">Unread</span>';
}
else
{
echo '<span class="badge bg-success">Read</span>';
}
?>

</td>

<td><?php echo $row['created_at']; ?></td>

<td>

<a href="view_message.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm">
View
</a>

<a href="delete_message.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this message?')">
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

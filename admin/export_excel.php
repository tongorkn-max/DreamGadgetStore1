<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

/*
=====================================
EXPORT EXCEL (CSV)
=====================================
*/

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=Dream_Gadget_Store_Report.csv");

$output=fopen("php://output","w");

/* CSV HEADERS */

fputcsv($output,array(

"Order ID",
"Customer",
"Phone",
"Total Amount",
"Payment Status",
"Order Status",
"Order Date"

));

$orders=mysqli_query($conn,"

SELECT

orders.id,
customers.full_name,
customers.phone,
orders.total_amount,
orders.payment_status,
orders.status,
orders.order_date

FROM orders

LEFT JOIN customers

ON customers.id=orders.customer_id

ORDER BY orders.id DESC

");

while($row=mysqli_fetch_assoc($orders))
{

fputcsv($output,array(

$row['id'],
$row['full_name'],
$row['phone'],
$row['total_amount'],
$row['payment_status'],
$row['status'],
date("d M Y",strtotime($row['order_date']))

));

}

fclose($output);
exit();

?>
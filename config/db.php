<?php

$conn = mysqli_connect(
    "sql300.infinityfree.com",
    "if0_42269432",
    "suL3T4AFYY",
    "if0_42269432_dream_gadget_store"
);

if(!$conn)
{
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
<?php
session_start();
require_once '../helper/connection.php';

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$query = mysqli_query($connection, "INSERT INTO product (name, description, price, stock, created_at, updated_at)
          VALUES ('$name', '$description', $price, $stock, NOW(), NOW())");

if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menambah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
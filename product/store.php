<?php
require_once '../helper/connection.php';
$name = $_POST['name'] ?? '';
$image = $_POST['image_url'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ? floatval($_POST['price']) : 0;
$stock = $_POST['stock'] ? intval($_POST['stock']) : 0;
$admin_id = $_POST['admin_id'] ? intval($_POST['admin_id']) : null;


$stmt = $connection->prepare("INSERT INTO product (name, description, price, stock, created_at, updated_at, image_url, admin_id)
                            VALUES (?, ?, ?, ?, NOW(), NOW(), ?, ?)");

$stmt->bind_param("ssdisi", $name, $description,$price, $stock, $image, $admin_id);

$query = $stmt->execute();

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Successfully added product'
    ];
    header('Location: ./index.php');
    exit;
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => $stmt->error
    ];
    header('Location: ./index.php');
    exit;
}

$stmt->close();
?>

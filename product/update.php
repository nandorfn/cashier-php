<?php
session_start();
require_once '../helper/connection.php';

$id = $_POST['id'] ? $_POST['id'] : null;
$name = $_POST['name'] ? $_POST['name'] : '';
$image_url = $_POST['image_url'] ? $_POST['image_url'] : '';
$description = $_POST['description'] ? $_POST['description'] : '';
$price = $_POST['price'] ? floatval($_POST['price']) : 0;
$stock = $_POST['stock'] ? intval($_POST['stock']) : 0;

if ($id) {
    $stmt = $connection->prepare("UPDATE product SET name=?, description=?, price=?, stock=?, updated_at=NOW(), image_url=? WHERE id=?");

    if ($stmt) {
        $stmt->bind_param('ssdisi', $name, $description, $price, $stock, $image_url, $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['info'] = [
                'status' => 'success',
                'message' => 'Successfully updated product'
            ];
            unset($_SESSION['cart']);
        } else {
            $_SESSION['info'] = [
                'status' => 'failed',
                'message' => 'Something went wrong!'
            ];
        }        
        $stmt->close();
    } else {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Something went wrong!'
        ];
    }
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Bad request'
    ];
}
header('Location: ./index.php');
exit();
?>

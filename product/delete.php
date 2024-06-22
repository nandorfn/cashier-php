<?php
require_once '../helper/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_id'])) {
  $product_id = $_GET['delete_id'];
  $result = mysqli_query($connection, "DELETE FROM product WHERE id='$product_id'");

  if ($result && mysqli_affected_rows($connection) > 0) {
    $_SESSION['info'] = [
      'status' => 'success',
      'message' => 'Successfully deleted product'
    ];
  } else {
    $_SESSION['info'] = [
      'status' => 'failed',
      'message' => mysqli_error($connection)
    ];
  }

  header('Location: ./index.php');
  exit;
}
?>

<div class="modal-content">
  <div class="box">
    <h3 class="title">Delete Product</h3>
    <p>Are you sure to delete this product?</p>
      <div class="field is-grouped">
        <div class="control">
          <button class="button is-danger" id="confirmDelete" type="button">Yes</button>
        </div>
        <div class="control">
          <button class="button" type="button" onclick="closeModal('deleteModal')">Cancel</button>
        </div>
      </div>
  </div>
</div>

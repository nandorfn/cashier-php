<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$product_id = $_GET['update_id'];
$query = mysqli_query($connection, "SELECT * FROM product WHERE id='$product_id'");

if ($query && mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    $productName = $data['name'];
    $image_url = $data['image_url'];
    $description = $data['description'];
    $price = $data['price'];
    $stock = $data['stock'];
} else {
    $productName = '';
    $image_url = '';
    $description = '';
    $price = '';
    $stock = '';
}

mysqli_free_result($query);
mysqli_close($connection);
require_once "../layout/_navbar.php";
?>

<div class="box container mt-6">
  <h3 class="title is-5">Edit Product</h3>
  <form action="./update.php" method="POST" id="editForm">
    <input type="hidden" name="id" value="<?= htmlspecialchars($product_id, ENT_QUOTES, 'UTF-8') ?>">
    <div class="field">
      <label class="label">Product Name</label>
      <div class="control">
        <input class="input" type="text" placeholder="product name..." name="name" value="<?= $productName ?>">
      </div>
    </div>
    <div class="field">
      <label class="label">Image URL</label>
      <div class="control">
        <input class="input" type="text" placeholder="your image link..." name="image_url" value="<?= $image_url ?>">
      </div>
    </div>
    <div class="field">
      <label class="label">Description</label>
      <div class="control">
        <textarea class="textarea" placeholder="description..." name="description"><?= $description ?></textarea>
      </div>
    </div>
    <div class="field">
      <label class="label">Price</label>
      <div class="control">
        <input class="input" type="number" placeholder="Rp" name="price" value="<?= $price ?>">
      </div>
    </div>
    <div class="field">
      <label class="label">Stock</label>
      <div class="control">
        <input class="input" type="number" placeholder="0" name="stock" value="<?= $stock ?>">
      </div>
    </div>
    <div class="field is-grouped">
      <div class="control">
        <button class="button is-primary" type="submit">Save</button>
      </div>
      <div class="control">
        <a class="button is-danger" href="./index.php">Cancel</a>
      </div>
    </div>
  </form>
</div>
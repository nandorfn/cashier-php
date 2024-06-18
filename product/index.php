<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "SELECT * FROM product");
?>
<!-- Navbar -->
<nav class="navbar is-warning" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="#">
      <strong>Product List</strong>
    </a>
  </div>
</nav>

<section class="section">
  <div>
    <button class="button is-warning" onclick="openModal('addModal')">Create Product</button>

    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while ($data = mysqli_fetch_array($result)) :
        ?>
        <tr>
          <td><?= $data['product_id'] ?></td>
          <td><?= $data['name'] ?></td>
          <td><?= $data['description'] ?></td>
          <td><?= $data['price'] ?></td>
          <td><?= $data['stock'] ?></td>
          <td>
            <div class="buttons">
              <button class="button is-danger is-small" onclick="openModal('deleteModal')">
                <span class="icon">
                  <i class="fas fa-trash"></i>
                </span>
              </button>
              <button class="button is-info is-small" onclick="openModal('editModal')">
                <span class="icon">
                  <i class="fas fa-edit"></i>
                </span>
              </button>
            </div>
          </td>
        </tr>
        <?php
    $no++;
    endwhile;
  ?>
      </tbody>

  </div>
</section>

<!-- Modal Tambah/Edit -->
<div id="addModal" class="modal">
  <div class="modal-background"></div>
  <?php
    require_once './create.php'
  ?>
  <button class="modal-close is-large" aria-label="close" onclick="closeModal('addModal')"></button>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="modal">
  <div class="modal-background"></div>
  <?php
    require_once './delete.php'
  ?>
  <button class="modal-close is-large" aria-label="close" onclick="closeModal('deleteModal')"></button>
</div>

<!-- Modal Edit -->
<div id="editModal" class="modal">
  <!-- Isi modal edit disini -->
</div>

<?php
require_once '../layout/_bottom.php';
?>
<script>
// Fungsi untuk membuka modal
function openModal(modalId) {
  document.getElementById(modalId).classList.add('is-active');
}

// Fungsi untuk menutup modal
function closeModal(modalId) {
  document.getElementById(modalId).classList.remove('is-active');
}
</script>
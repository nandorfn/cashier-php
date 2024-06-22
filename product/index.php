<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
$admin = isset($_SESSION['login']) ? $_SESSION['login'] : null;
$admin_id = $admin["id"];
$result = mysqli_query($connection, "SELECT * FROM product WHERE admin_id = $admin_id");

function isValidImageUrl($url) {
  if (empty($url)) {
      return false;
  }
  return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

function getImageUrlOrDefault($url) {
  if (isValidImageUrl($url)) {
      return $url;
  } else {
      return '../assets/images/no-image.png';
  }
}

require_once '../layout/_navbar.php';
?>

<section class="section">
  <div>
    <button class="button is-warning" onclick="openModal('addModal')">Create Product</button>
    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
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
            $imageSrc = getImageUrlOrDefault($data['image_url']);
        ?>
        <tr>
          <td><?= $data['id'] ?></td>
          <td>
            <figure class="image is-64x64">
              <img src="<?= $imageSrc ?>" />
            </figure>
              
          </td>
          <td><?= $data['name'] ?></td>
          <td><?= $data['description'] ?></td>
          <td>Rp<?= intval($data['price']) ?></td>
          <td><?= $data['stock'] ?></td>
          <td>
            <div class="buttons">
              <button class="button is-danger is-small" onclick="deleteModal(<?= $data['id'] ?>)">
                <span class="icon">
                  <i class="fas fa-trash"></i>
                </span>
              </button>
              <button class="button is-info is-small" onclick="editModal(<?= $data['id'] ?>)">
                <span class="icon">
                  <i class="fas fa-edit"></i>
                </span>
              </button>
            </div>
          </td>
        </tr>
        <?php
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
</div>

<?php
require_once '../layout/_bottom.php';
?>
<script>
// Fungsi untuk membuka modal
function openModal(modalId) {
  document.getElementById(modalId).classList.add('is-active');
}

function deleteModal(productId) {
  openModal("deleteModal")
  document.getElementById('confirmDelete').addEventListener('click', function() {
      window.location.href = './delete.php?delete_id=' + productId;
      closeModal("deleteModal");
})
}

function editModal(productId) {
  window.location.href = './edit.php?update_id=' + productId;
}

// Fungsi untuk menutup modal
function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('is-active');
}
</script>
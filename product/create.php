<div class="modal-content">
  <div class="box">
    <h3 class="title">Create Product</h3>
    <form action="../product/store.php" method="POST" id="addForm">
      <input type="hidden" name="admin_id" value="<?= htmlspecialchars($admin_id, ENT_QUOTES, 'UTF-8') ?>">
      <div class="field">
        <label class="label">Product Name</label>
        <div class="control">
          <input class="input" type="text" placeholder="product name..." name="name">
        </div>
      </div>
      <div class="field">
        <label class="label">Image URL</label>
        <div class="control">
          <input class="input" type="text" placeholder="your image link..." name="image_url">
        </div>
      </div>
      <div class="field">
        <label class="label">Description</label>
        <div class="control">
          <textarea class="textarea" placeholder="description..." name="description"></textarea>
        </div>
      </div>
      <div class="field">
        <label class="label">Price</label>
        <div class="control">
          <input class="input" type="number" placeholder="Rp." name="price" onkeypress="return isNumberKey(event)">
        </div>
      </div>
      <div class="field">
        <label class="label">Stock</label>
        <div class="control">
          <input class="input" type="number" placeholder="0" name="stock" onkeypress="return isNumberKey(event)">
        </div>
      </div>
      <div class="field is-grouped">
        <div class="control">
          <button class="button is-primary" type="submit" id="saveButton" disabled>Save</button>
        </div>
        <div class="control">
          <button class="button is-danger" type="button" onclick="closeModal('addModal')">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function isNumberKey(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 8 && charCode != 46 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}

const nameInput = document.querySelector('input[name="name"]');
const priceInput = document.querySelector('input[name="price"]');
const stockInput = document.querySelector('input[name="stock"]');
const saveButton = document.getElementById('saveButton');

nameInput.addEventListener('input', () => {
  if (nameInput.value.trim() !== '') {
    validateAndEnableSave();
  } else {
    saveButton.disabled = true;
  }
});

priceInput.addEventListener('input', () => {
  if (!isNaN(priceInput.value) && priceInput.value !== '') {
    validateAndEnableSave();
  } else {
    saveButton.disabled = true;
  }
});

stockInput.addEventListener('input', () => {
  if (!isNaN(stockInput.value) && stockInput.value !== '') {
    validateAndEnableSave();
  } else {
    saveButton.disabled = true;
  }
});

function validateAndEnableSave() {
  saveButton.disabled = false;
}
</script>

<div class="modal-content">
    <div class="box">
      <h3 class="title">Create Product</h3>
      <form action="./store.php" method="POST" id="addForm">
        <div class="field">
          <label class="label">Product Name</label>
          <div class="control">
            <input class="input" type="text" placeholder="Nama Produk" name="name">
          </div>
        </div>
        <div class="field">
          <label class="label">Description</label>
          <div class="control">
            <textarea class="textarea" placeholder="Deskripsi" name="description"></textarea>
          </div>
        </div>
        <div class="field">
          <label class="label">Price</label>
          <div class="control">
            <input class="input" type="number" placeholder="Harga" name="price">
          </div>
        </div>
        <div class="field">
          <label class="label">Stock</label>
          <div class="control">
            <input class="input" type="number" placeholder="Stok" name="stock">
          </div>
        </div>
        <div class="field is-grouped">
          <div class="control">
            <button class="button is-primary" type="submit">Save</button>
          </div>
          <div class="control">
            <button class="button is-danger" type="button" onclick="closeModal('addModal')">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
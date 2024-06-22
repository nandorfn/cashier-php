<?php
session_start();
require_once '../layout/_top.php';
require_once '../helper/connection.php';
require_once "../layout/_navbar.php";
$result = mysqli_query($connection, "SELECT * FROM product WHERE admin_id = $admin_id");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$admin = isset($_SESSION['login']) ? $_SESSION['login'] : null;

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_to_cart"])) {
        $product_id = $_POST['id'];

        $found_index = -1;
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $product_id) {
                $found_index = $index;
                break;
            }
        }

        if ($found_index !== -1) {
            $cart_item = $_SESSION['cart'][$found_index];
            $cart_item['quantity'] += 1;
            $_SESSION['cart'][$found_index] = $cart_item;
        } else {
            $product = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'image' => $_POST['image'],
                'quantity' => 1
            ];
            $_SESSION['cart'][] = $product;
        }
    } elseif (isset($_POST["remove_item"])) {
        $remove_id = $_POST["remove_item"];

        $remove_index = -1;
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $remove_id) {
                $remove_index = $index;
                break;
            }
        }

        if ($remove_index !== -1) {
            unset($_SESSION['cart'][$remove_index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    } elseif (isset($_POST["increase_quantity"])) {
        $product_id = $_POST['increase_quantity'];

        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $product_id) {
                $_SESSION['cart'][$index]['quantity'] += 1;
                break;
            }
        }
    } elseif (isset($_POST["decrease_quantity"])) {
        $product_id = $_POST['decrease_quantity'];

        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $product_id && $item['quantity'] > 1) {
                $_SESSION['cart'][$index]['quantity'] -= 1;
                break;
            }
        }
    } elseif (isset($_POST["order"])) {
          if (isset($_POST['amount'])) {
              $amount = $_POST['amount'];
      
              $grand_total = 0;
              foreach ($_SESSION['cart'] as $item) {
                  $subtotal = $item['price'] * $item['quantity'];
                  $grand_total += $subtotal;
              }
      
              $created_at = date('Y-m-d H:i:s');
              $updated_at = date('Y-m-d H:i:s');
      
              $queryTransaction = "INSERT INTO transaction (admin_id, grand_total, created_at, updated_at) 
                                  VALUES ('{$admin['id']}', '{$grand_total}', '{$created_at}', '{$updated_at}')";
      
              mysqli_query($connection, $queryTransaction) or die(mysqli_error($connection));
      
              $transaction_id = mysqli_insert_id($connection);
      
              foreach ($_SESSION['cart'] as $item) {
                  $subtotal = $item['price'] * $item['quantity'];
                  $queryRelasi = "INSERT INTO order_item (transaction_id, product_id, quantity, sub_total) 
                                  VALUES ('{$transaction_id}', '{$item['id']}', '{$item['quantity']}', '{$subtotal}')";
      
                  mysqli_query($connection, $queryRelasi) or die(mysqli_error($connection));
              }
      
              foreach ($_SESSION['cart'] as $item) {
                  $updateStockQuery = "UPDATE product SET stock = stock - {$item['quantity']} WHERE id = {$item['id']}";
                  mysqli_query($connection, $updateStockQuery) or die(mysqli_error($connection));
              }
      
              $_SESSION['cart'] = array();
              header('Location: index.php'); 
              exit;
          }
      }
}
?>
<section class="m-5 columns">
  <div class="column is-9">
    <div class="columns is-multiline is-2 gap-3">
      <?php while ($data = mysqli_fetch_array($result)) : ?>
      <div class="column is-3">
        <div class="card">
          <div class="card-image">
            <figure class="image is-4by3">
              <img src="<?=$imageSrc = getImageUrlOrDefault($item['image_url']) ?>" />
            </figure>
          </div>
          <div class="card-content">
            <h3><?= $data['name'] ?></h3>
            <p>Rp<?= number_format($data['price'], 0, ',', '.') ?></p>
          </div>
          <div class="card-footer p-2 is-flex is-justify-content-end">
            <form method="POST" action="">
              <input type="hidden" name="id" value="<?= $data['id'] ?>">
              <input type="hidden" name="name" value="<?= $data['name'] ?>">
              <input type="hidden" name="price" value="<?= $data['price'] ?>">
              <input type="hidden" name="image" value="<?= $data['image_url'] ?>">
              <button class="button is-primary" type="submit" name="add_to_cart">+</button>
            </form>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <div class="column is-3">
    <div class="box is-flex is-flex-direction-column is-justify-content-space-between">
      <div>
        <h2 class="is-size-3 mb-5">Order</h2>
        <div id="order-list" style="height: 50vh; overflow-y: scroll;">
          <form method="POST" action="">
            <?php
            $total = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $index => $item) {
                    $imageSrc = getImageUrlOrDefault($item['image']);
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    echo '<div class="order-item py-2" style="border-bottom: 1px solid #ccc;">';
                    echo '<div class="media">';
                    echo '<figure class="media-left">';
                    echo '<p class="image is-64x64">';
                    echo '<img src="' . $imageSrc . '" alt="' . $item['name'] . '">';
                    echo '</p>';
                    echo '</figure>';
                    echo '<div class="media-content">';
                    echo '<div class="content">';
                    echo '<p>';
                    echo '<strong>' . $item['name'] . '</strong><br>';
                    echo '<div class="is-flex is-flex-direction-row is-justify-content-space-between is-align-items-center">
                            <label>Quantity: </label> 
                            <button class="button is-small" type="submit" name="decrease_quantity" value="' . $item['id'] . '">-</button>
                            ' . $item['quantity'] . '
                            <button class="button is-small" type="submit" name="increase_quantity" value="' . $item['id'] . '">+</button>
                          </div>
                          <br>';
                    echo 'Price: Rp' . number_format($item['price'], 0, ',', '.') . '<br>';
                    echo 'Subtotal: Rp' . number_format($subtotal) . '<br>';
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="media-right">';
                    echo '<button class="button is-ghost is-small" type="submit" name="remove_item" value="' . $item['id'] . '">
                          <img src="../assets/icon/x-icon.svg" />
                          </button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
          </form>
        </div>
      </div>
      <div class="total py-3">
        <div class="is-flex is-flex-direction-row is-justify-content-space-between">
          <b>Total:</b>
          <h3 id="total-price">Rp<?= number_format($total) ?></h3>
        </div>
        <form method="POST" action="">
          <div class="field">
            <label class="label">Amount</label>
            <div class="control">
              <input id="amount" name="amount" class="input" type="number" placeholder="Rp" oninput="calculateChange()">
            </div>
          </div>
          <div class="field">
            <label class="label">Change</label>
            <div class="control">
              <input id="change" class="input" type="text" readonly>
            </div>
          </div>
          <button class="button is-warning is-fullwidth mt-3" type="submit" name="order" id="orderButton"
            disabled>ORDER</button>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
function calculateChange() {
  const total = <?= $total ?>;
  const amount = parseInt(document.getElementById('amount').value);
  let change = amount - total;

  if (isNaN(change)) {
    change = 0;
  }

  document.getElementById('change').value = 'Rp' + new Intl.NumberFormat('id-ID').format(change);

  const orderButton = document.getElementById('order-button');
  if (change < 0) {
    orderButton.disabled = true;
  } else {
    orderButton.disabled = false;
  }
}

const orderButton = document.getElementById('orderButton');
const amountInput = document.querySelector('input[name="amount"]');

function updateOrderButtonStatus() {
  const amount = parseFloat(amountInput.value);
  const total = <?= $total ?>;

  if (!isNaN(amount) && amount >= total) {
    orderButton.removeAttribute('disabled');
  } else {
    orderButton.setAttribute('disabled', 'disabled');
  }
}

updateOrderButtonStatus();

amountInput.addEventListener('input', updateOrderButtonStatus);
</script>

</body>

</html>
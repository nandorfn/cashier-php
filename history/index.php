<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = !empty($search) ? "AND (p.name LIKE '%$search%' OR t.id LIKE '%$search%')" : '';

$query = "
    SELECT t.id AS transaction_id, 
          GROUP_CONCAT(p.name, ' x ', oi.quantity SEPARATOR ', ') AS product_list,
          t.created_at AS transaction_date,
          t.grand_total AS total
    FROM transaction t
    INNER JOIN order_item oi ON t.id = oi.transaction_id
    INNER JOIN product p ON oi.product_id = p.id
    WHERE t.admin_id = ? $searchCondition
    GROUP BY t.id, t.created_at, t.grand_total
    ORDER BY t.created_at DESC
";

$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, 'i', $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

require_once "../layout/_navbar.php";
?>
<section class="section">
  <div>
    <form class="mb-3 is-flex is-fullwidth is-flex-direction-column is-align-items-end" action="" method="GET">
      <div class="field has-addons">
        <div class="control">
          <input class="input" type="text" placeholder="Search by Product Name or ID" name="search" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="control">
          <button class="button is-warning" type="submit">
            Search
          </button>
        </div>
      </div>
    </form>

    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>ID</th>
          <th>Product List</th>
          <th>Transaction Date</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($data = mysqli_fetch_array($result)) :
        ?>
        <tr>
          <td><?= $data['transaction_id'] ?></td>
          <td><?= $data['product_list'] ?></td>
          <td><?= $data['transaction_date'] ?></td>
          <td>Rp<?= number_format($data['total'], 0, ',', '.') ?></td>
        </tr>
        <?php
        endwhile;
        ?>
      </tbody>
    </table>
  </div>
</section>

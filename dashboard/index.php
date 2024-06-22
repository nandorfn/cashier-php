<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$current_month = date('m');
$current_year = date('Y');
$query = "SELECT 
              'Total Earned' AS type,
              SUM(grand_total) AS result
          FROM 
              transaction
          WHERE 
              admin_id = ?
          UNION
          SELECT 
              'Total Earned This Month' AS type,
              SUM(grand_total) AS result
          FROM 
              transaction
          WHERE 
              YEAR(created_at) = ? AND MONTH(created_at) = ? AND admin_id = ?
          UNION
          SELECT 
              'Total Product' AS type,
              COUNT(*) AS result
          FROM 
              product
          WHERE 
              admin_id = ?
          UNION
          SELECT 
              'Total Empty Product' AS type,
              COUNT(*) AS result
          FROM 
              product
          WHERE 
              admin_id = ? AND stock = 0
          UNION
          SELECT 
              'Total Transaction' AS type,
              COUNT(*) AS result
          FROM 
              transaction
          WHERE 
              admin_id = ?
          UNION
          SELECT 
              'Total Sold Product' AS type,
              SUM(oi.quantity) AS result
          FROM 
              order_item oi
              JOIN transaction t ON oi.transaction_id = t.id
          WHERE 
              t.admin_id = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, 'iiiiiiii', $admin_id, $current_year, $current_month, $admin_id, $admin_id, $admin_id, $admin_id, $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

require_once "../layout/_navbar.php";
?>

<section class="section">
  <div class="columns is-multiline is-centered">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="column is-3">
                <div class="card">
                  <div class="card-content">
                    <div class="content">
                      <p class="title is-6 mb-5">' . $row['type'] . '</p>';
                        if ($row['type'] == 'Total Product' || $row['type'] == 'Total Empty Product' || $row['type'] == 'Total Transaction' || $row['type'] == 'Total Sold Product') {
                          echo '<p class="subtitle is-3 has-text-weight-semibold">' . number_format($row['result']) . '</p>';
                        } else {
                          echo '<p class="subtitle is-3 has-text-weight-semibold">Rp' . number_format($row['result'], 0, ',', '.') . '</p>';
                        }
        echo '      </div>
                  </div>
                </div>
              </div>';
    }
    ?>
  </div>
</section>

<?php
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>

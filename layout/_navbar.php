<?php
$current_path = $_SERVER['REQUEST_URI'];
$path_parts = explode('/', $current_path);
?>

<nav class="navbar is-warning pr-4" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="#">
      <strong><?= ucfirst($path_parts[1]) ?></strong>
    </a>
  </div>

  <div class="navbar-end">
    <h1 class="my-auto is-size-6 has-text-weight-medium">Hi, <?= $admin['name'] ?></h1>
  </div>
</nav>

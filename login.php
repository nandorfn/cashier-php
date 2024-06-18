<?php
require_once 'helper/connection.php';
session_start();
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM login WHERE username='$username' and password='$password' LIMIT 1";
  $result = mysqli_query($connection, $sql);

  $row = mysqli_fetch_assoc($result);
  if ($row) {
    $_SESSION['login'] = $row;
    header('Location: index.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Cashier</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body>
  <div class="container mt-6">
    <section class="section">
      <div class="columns is-centered">
        <div class="column is-4">
          <div class="box">
            <div class="has-text-centered">
              <img src="https://ucarecdn.com/ed3d7f66-7bd7-4cdf-88d9-e52c4e01cb7e/-/preview/469x101/" alt="logo" width="200">
            </div>
            <h4 class="title is-4 has-text-warning has-text-centered">Login Admin</h4>
            <form method="POST" action="">
              <div class="field">
                <label class="label" for="username">Username</label>
                <div class="control">
                  <input id="username" type="text" class="input" name="username" required autofocus>
                </div>
                <p class="help is-danger" style="display: none;">Please input username!</p>
              </div>

              <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control">
                  <input id="password" type="password" class="input" name="password" required>
                </div>
                <p class="help is-danger" style="display: none;">Please input password!</p>
              </div>

              <div class="field">
                <div class="control">
                  <label class="checkbox">
                    <input type="checkbox" name="remember" id="remember-me">
                    Remember me
                  </label>
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <button name="submit" type="submit" class="button is-warning is-fullwidth">
                    Login
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>

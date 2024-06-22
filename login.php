<?php
require_once 'helper/connection.php';
session_start();
$email_error = '';
$password_error = '';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $email_error = "Please input email.";
    }
    if (empty($password)) {
        $password_error = "Please input password.";
    }

    if (empty($email_error) && empty($password_error)) {
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = $connection->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();

                    if (password_verify($password, $row['password'])) {
                      $_SESSION['login'] = $row;
                      header('Location: index.php');
                      exit();
                    } else {
                        $password_error = "Email and password invalid";
                    }
                } else {
                    $email_error = "Email and password invalid";
                }
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $connection->error;
        }
    }

    $connection->close();
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
                <label class="label" for="email">Email</label>
                <div class="control">
                  <input id="email" type="text" class="input" name="email" required autofocus>
                </div>
                <?php if (!empty($email_error)) : ?>
                  <p class="help is-danger"><?php echo $email_error; ?></p>
                <?php endif; ?>
              </div>

              <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control">
                  <input id="password" type="password" class="input" name="password" required>
                </div>
                <?php if (!empty($password_error)) : ?>
                  <p class="help is-danger"><?php echo $password_error; ?></p>
                <?php endif; ?>
              </div>
              <p>Don't have an account? <a href="./register.php">Register here</a></p>

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

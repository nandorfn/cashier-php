<?php
require_once './helper/connection.php';
$name_error = '';
$email_error = '';
$password_error = '';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($name)) {
        $name_error = "Please input name.";
    }
    if (empty($email)) {
        $email_error = "Please input email.";
    }
    if (empty($password)) {
        $password_error = "Please input password.";
    }

    if (empty($name_error) && empty($email_error) && empty($password_error)) {
        $check_email_query = "SELECT * FROM admin WHERE email = ?";
        $stmt_check_email = $connection->prepare($check_email_query);
        if ($stmt_check_email) {
            $stmt_check_email->bind_param("s", $email);
            $stmt_check_email->execute();
            $stmt_check_email->store_result();

            if ($stmt_check_email->num_rows > 0) {
                $email_error = "Email already exists.";
            }

            $stmt_check_email->close();
        } else {
            echo "Error: " . $connection->error;
            exit();
        }

        if (empty($email_error)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO admin (name, email, password, createdAt, updatedAt) VALUES (?, ?, ?, NOW(), NOW())";
            $stmt_insert = $connection->prepare($insert_query);
            if ($stmt_insert) {
                $stmt_insert->bind_param("sss", $name, $email, $hashed_password);
                if ($stmt_insert->execute()) {
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Error: " . $stmt_insert->error;
                }
                $stmt_insert->close();
            } else {
                echo "Error: " . $connection->error;
            }
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
  <title>Register &mdash; Cashier</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body>
  <div class="container mt-6">
    <section class="section">
      <div class="columns is-centered">
        <div class="column is-4">
          <div class="box">
            <div class="has-text-centered">
              <img src="https://ucarecdn.com/ed3d7f66-7bd7-4cdf-88d9-e52c4e01cb7e/-/preview/469x101/" alt="logo"
                width="200">
            </div>
            <h4 class="title is-4 has-text-warning has-text-centered">Register Admin</h4>
            <form method="POST" action="">
              <div class="field">
                <label class="label" for="name">Name</label>
                <div class="control">
                  <input id="name" type="text" class="input" name="name" required autofocus>
                </div>
                <?php if (!empty($name_error)): ?>
                <p class="help is-danger"><?php echo $name_error; ?></p>
                <?php endif; ?>
              </div>

              <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control">
                  <input id="email" type="text" class="input" name="email" required autofocus>
                </div>
                <?php if (!empty($email_error)): ?>
                <p class="help is-danger"><?php echo $email_error; ?></p>
                <?php endif; ?>
              </div>

              <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control">
                  <input id="password" type="password" class="input" name="password" required>
                </div>
                <?php if (!empty($password_error)): ?>
                <p class="help is-danger"><?php echo $password_error; ?></p>
                <?php endif; ?>
              </div>


              <div class="field">
                <div class="control">
                  <button name="submit" type="submit" class="button is-warning is-fullwidth">
                    Register
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
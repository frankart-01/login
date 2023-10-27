<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <?php
            // Initialize variables for the registration form
            $new_user = $new_pass = $email = "";
            $usernameError = $passwordError = $emailError = "";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get and validate user input
                $new_user = $_POST['username'];
                $new_pass = $_POST['password'];
                $email = $_POST['email'];

                // Add your validation logic here

                // If input is valid, insert the new user into the database
                if (empty($usernameError) && empty($passwordError) && empty($emailError)) {
                    require_once 'connect.php'; // Include the database connection file

                    // Hash the password (for security, use password_hash() in a real application)
                    $hashedPassword = password_hash($new_pass, PASSWORD_BCRYPT);

                    // Insert the user into the database
                    $sql = "INSERT INTO users (username, password, contact) VALUES ('$new_user', '$new_pass', '$email')";
                    if ($connection->query($sql) === TRUE) {
                        // Registration successful, redirect to login page
                        header("Location: index.php");
                        exit;
                    } else {
                        echo '<div class="alert alert-danger">Error: ' . $connection->error . '</div>';
                    }

                    // Close the database connection
                    $connection->close();
                }
            }
            ?>

            <h2>Sign Up</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $new_user; ?>" required>
                    <div class="text-danger"><?php echo $usernameError; ?></div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                    <div class="text-danger"><?php echo $passwordError; ?></div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                    <div class="text-danger"><?php echo $emailError; ?></div>
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
            <p class="mt-3">Already have an account? <a href="index.php">Log in</a></p>
        </div>
    </div>
</div>

</body>
</html>

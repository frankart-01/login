<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Login</h2>
            <?php
            // Start a PHP session
            session_start();
            
             // Establish a database connection
                require_once 'connect.php';

            // Check if the user is already logged in
            if (isset($_SESSION['user_id'])) {
                header("Location: dashboard.php");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get user input
                $username = $_POST['username'];
                $password = $_POST['password'];

               

                $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    // Valid login, start a session
                    $user = $result->fetch_assoc();
                    $_SESSION['user_id'] = $user['user_id'];
                    header("Location: dashboard.php");
                    exit;
                } else {
                    echo '<div class="alert alert-danger">Invalid credentials. Please try again.</div>';
                }

                // Close the database connection after use
                $connection->close();
            }
            ?>
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3">
                    <label for "password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <p class="mt-3">Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</div>

</body>
</html>

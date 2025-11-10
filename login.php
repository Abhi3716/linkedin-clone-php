<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
                header("Location: home.php");
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No account found with that email.";
        }

        $stmt->close();
    } else {
        $error = "Database query failed: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        * { box-sizing: border-box; }
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(135deg, #e0f2ff, #ffffff);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }
    .login-container {
        background: #fff;
        width: 380px;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        text-align: center;
    }
    h2 {
        color: #0073b1;
        margin-bottom: 20px;
        font-size: 26px;
    }
    input {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
    }
    button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background-color: #0073b1;
        color: white;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }
    button:hover {
        background-color: #005b8a;
    }
    .error {
        color: red;
        margin-bottom: 10px;
        font-size: 14px;
    }
    a {
        color: #0073b1;
        text-decoration: none;
    }
    a:hover { text-decoration: underline; }
    .signup-link {
        margin-top: 15px;
        font-size: 14px;
    }
    </style>
</head>
<body>
    <div class="box">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</body>
</html>

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<p style='color:red;'>Email already registered. Please <a href='login.php'>login here</a>.</p>";
    } else {
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>Account created successfully! <a href='login.php'>Login now</a></p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - LinkedIn Clone</title>
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
    .signup-container {
        background: #fff;
        width: 400px;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        text-align: center;
    }
    h2 {
        color: #0073b1;
        margin-bottom: 25px;
        font-size: 28px;
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
    .message {
        font-size: 14px;
        margin-bottom: 10px;
    }
    .error {
        color: red;
    }
    .success {
        color: green;
    }
    a {
        color: #0073b1;
        text-decoration: none;
        font-weight: bold;
    }
    a:hover { text-decoration: underline; }
    .login-link {
        margin-top: 15px;
        font-size: 14px;
    }
    </style>
</head>
<body>
    <div class="signup-box">
        <h2>Create Account</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>

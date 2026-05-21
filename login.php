<?php
session_start();
include('includes/config.php');

// For development - comment in production
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

if (isset($_POST['submit'])) { // Signup form
    $name = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['emailid'] ?? '');
    $contactno = trim($_POST['contactno'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($contactno) || empty($password)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Email already registered!');</script>";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = $con->prepare("INSERT INTO users (name, email, contactno, password) VALUES (?, ?, ?, ?)");
            $insert->bind_param("ssss", $name, $email, $contactno, $hashed);
            if ($insert->execute()) {
                echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
            } else {
                echo "<script>alert('Registration failed. Try again.');</script>";
            }
            $insert->close();
        }
        $stmt->close();
    }
}

if (isset($_POST['login'])) { // Login
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $con->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = $email;
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['name'];

        $uip = $_SERVER['REMOTE_ADDR'];
        $log = $con->prepare("INSERT INTO userlog (userEmail, userip, status) VALUES (?, ?, 1)");
        $log->bind_param("ss", $email, $uip);
        $log->execute();
        $log->close();

        header("Location: my-cart.php");
        exit();
    } else {
        $_SESSION['errmsg'] = "Invalid email or password";
        header("Location: login.php");
        exit();
    }
}
?>

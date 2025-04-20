<?php
include("connection.php");
session_start();

if ($conn === false) {
    die("Connection error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $name, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['user'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['role'] = $row['role']; 

        if ($row['role'] == 'Admin') {
            header("Location: admin_dashboard.php");
            exit();
        } elseif ($row['role'] == 'Customer') {
            header("Location: customer_dashboard.php");
            exit();
        } else {
            header("Location: login.php?Invalid=Unknown user role.");
            exit();
        }
    } else {
        header("Location: login.php?Invalid=Please provide correct login information.");
        exit();
    }
}
?>

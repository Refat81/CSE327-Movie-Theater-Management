<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Admins only.");
    exit();
}

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if ($user_id) {
    $delete_sql = "DELETE FROM users WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: view_users.php?message=User deleted successfully.");
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
} else {
    echo "Invalid user ID.";
}
?>

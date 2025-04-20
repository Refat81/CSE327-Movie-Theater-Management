<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Admins only.");
    exit();
}

if (isset($_GET['show_id']) && !empty($_GET['show_id'])) {
    $show_id = $_GET['show_id'];

    $delete_tickets_sql = "DELETE FROM tickets WHERE show_id = '$show_id'";
    $delete_tickets_result = mysqli_query($conn, $delete_tickets_sql);

    $delete_show_sql = "DELETE FROM showtimes WHERE show_id = '$show_id'";
    $delete_show_result = mysqli_query($conn, $delete_show_sql);

    if ($delete_show_result) {
        header("Location: showtimes_list.php?message=Show deleted successfully.");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
} else {
    echo "<div class='alert alert-warning'>No show ID provided.</div>";
}
?>

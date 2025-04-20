<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php?error=Access denied. Please login as Customer.");
    exit();
}

$user_id = $_SESSION['user_id']; 
$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : null;
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;
$price = isset($_POST['price']) ? $_POST['price'] : null;

if ($ticket_id && $payment_method && $price) {
    $payment_status = "Success";

    if ($payment_status === "Success") {
        $update_ticket_sql = "UPDATE tickets SET status = 'Paid' WHERE ticket_id = '$ticket_id' AND user_id = '$user_id'";
        if (mysqli_query($conn, $update_ticket_sql)) {
            $insert_payment_sql = "INSERT INTO payments (ticket_id, amount, status, payment_method)
                                   VALUES ('$ticket_id', '$price', 'Success', '$payment_method')";
            if (mysqli_query($conn, $insert_payment_sql)) {
                $msg = "<div class='alert alert-success text-center mt-3'>Payment successful! Your ticket has been paid. <a href='ticket.php?ticket_id=$ticket_id'>View Ticket</a></div>";
            } else {
                $msg = "<div class='alert alert-danger text-center mt-3'>Payment failed. Please try again later.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger text-center mt-3'>Ticket status update failed. Please try again later.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger text-center mt-3'>Payment failed. Please try again later.</div>";
    }
} else {
    $msg = "<div class='alert alert-danger text-center mt-3'>Invalid request. Please try again.</div>";
}

echo $msg;
?>

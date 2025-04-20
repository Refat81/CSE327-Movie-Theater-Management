<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied.");
    exit();
}

if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];

    mysqli_begin_transaction($conn);

    try {
        $delete_showtimes_sql = "DELETE FROM showtimes WHERE movie_id = ?";
        $stmt = mysqli_prepare($conn, $delete_showtimes_sql);
        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        $delete_seats_sql = "DELETE FROM seats WHERE show_id IN (SELECT show_id FROM showtimes WHERE movie_id = ?)";
        $stmt = mysqli_prepare($conn, $delete_seats_sql);
        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        $delete_tickets_sql = "DELETE FROM tickets WHERE show_id IN (SELECT show_id FROM showtimes WHERE movie_id = ?)";
        $stmt = mysqli_prepare($conn, $delete_tickets_sql);
        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        $delete_movie_sql = "DELETE FROM movies WHERE movie_id = ?";
        $stmt = mysqli_prepare($conn, $delete_movie_sql);
        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);

        header("Location: viewmovie.php?message=Movie deleted successfully.");
        exit();
    } catch (Exception $e) {
        mysqli_roll_back($conn);
        echo "Error deleting movie: " . $e->getMessage();
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error: Movie ID is missing.";
}

mysqli_close($conn);
?>

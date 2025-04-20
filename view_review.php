<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied.");
    exit();
}

$sql = "
    SELECT r.review_id, m.title AS movie_title, u.name AS user_name, r.rating, r.comment
    FROM reviews r
    JOIN movies m ON r.movie_id = m.movie_id
    JOIN users u ON r.user_id = u.user_id
    ORDER BY r.review_id DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Reviews</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #232526, #414345);
            color: white;
            font-family: 'Poppins', sans-serif;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            background: rgba(255, 255, 255, 0.08);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .review-card {
            background: rgba(255, 255, 255, 0.07);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            border-left: 5px solid #ffc107;
        }
        .stars {
            color: #ffc107;
        }
        .btn-back {
            margin-top: 20px;
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
        }
        .btn-back:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">📋 All Movie Reviews</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review-card">
                <h5>🎬 <?= htmlspecialchars($row['movie_title']) ?></h5>
                <p><strong>👤 By:</strong> <?= htmlspecialchars($row['user_name']) ?></p>
                <p><strong>⭐ Rating:</strong> <span class="stars"><?= str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']) ?></span></p>
                <p><strong>💬 Comment:</strong><br><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center">No reviews found.</p>
    <?php endif; ?>

    <div class="text-center">
        <a href="admin_dashboard.php" class="btn btn-back">🔙 Back to Admin Dashboard</a>
    </div>
</div>

</body>
</html>

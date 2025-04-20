<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Admins only.");
    exit();
}

$sql = "SELECT r.report_id, r.report_type, r.content, r.created_at, u.name, u.email 
        FROM reports r
        JOIN users u ON r.generated_by = u.user_id
        ORDER BY r.created_at DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback - Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            padding-bottom: 50px;
        }
        .container {
            max-width: 900px;
            margin-top: 60px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px); 
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 40px;
        }
        .feedback-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px); 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
            padding: 20px;
            transition: transform 0.3s ease;
        }
        .feedback-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .btn-back {
            width: 150px;
            margin: 20px auto;
            display: block;
            background-color: #2980b9;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #3498db;
        }
        .card-title {
            font-size: 22px;
            font-weight: 600;
            color: #ecf0f1;
        }
        .card-text {
            font-size: 16px;
            color: #bdc3c7;
        }
        .alert-info {
            color: white;
            background-color: #2ecc71;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Customer Feedback & Reports</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='card feedback-card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . htmlspecialchars($row['report_type']) . "</h5>";
            echo "<p><strong>Reported by:</strong> " . htmlspecialchars($row['name']) . " (Email: " . htmlspecialchars($row['email']) . ")</p>";
            echo "<p><strong>Feedback Submitted on:</strong> " . date('Y-m-d H:i', strtotime($row['created_at'])) . "</p>";
            echo "<p><strong>Content:</strong> " . nl2br(htmlspecialchars($row['content'])) . "</p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='alert alert-info'>No feedback available.</div>";
    }
    ?>

    <a href="admin_dashboard.php" class="btn-back">← Back to Dashboard</a>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

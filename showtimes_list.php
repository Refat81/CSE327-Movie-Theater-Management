<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Admins only.");
    exit();
}

$sql = "
    SELECT s.show_id, s.movie_id, s.time, s.screen_no, s.price, m.title AS movie_title
    FROM showtimes s
    JOIN movies m ON s.movie_id = m.movie_id
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching showtimes: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Showtimes Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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

        .card {
            border: none;
            border-left: 5px solid #007bff;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 18px rgba(0, 0, 0, 0.08);
        }

        .card-body {
            padding: 25px;
            background-color: #fff;
            border-radius: 10px;
        }

        .card-title {
            font-size: 22px;
            font-weight: 600;
            color: #34495e;
        }

        .card-text {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
            font-weight: 500;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .alert {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #2980b9;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            width: 100%;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3498db;
        }

        .back-btn {
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 12px 20px;
            border-radius: 8px;
        }

        .back-btn:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>All Showtimes</h1>

    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($show = mysqli_fetch_assoc($result)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($show['movie_title']) ?></h5>
                    <p class="card-text">
                        <strong>Showtime:</strong> <?= date('Y-m-d H:i', strtotime($show['time'])) ?><br>
                        <strong>Screen:</strong> <?= htmlspecialchars($show['screen_no']) ?><br>
                        <strong>Price:</strong> $<?= htmlspecialchars($show['price']) ?>
                    </p>
                    <a href="delete_show.php?show_id=<?= $show['show_id'] ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Are you sure you want to delete this show?')">Delete Show</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center">No showtimes found in the database.</div>
    <?php endif; ?>

    <center>
        <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
    </center>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

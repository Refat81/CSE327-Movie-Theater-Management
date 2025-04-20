<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied.");
    exit();
}

$movie_sql = "SELECT * FROM movies";
$movie_result = mysqli_query($conn, $movie_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(20, 20, 20),rgb(85, 88, 90));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 50px;
        }

        .container {
            max-width: 1100px;
            margin: 60px auto;
        }

        h1 {
            text-align: center;
            color: #fff;
            font-weight: 700;
            margin-bottom: 40px;
            font-size: 32px;
        }

        .movie-card {
            display: flex;
            flex-direction: row;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
            transition: transform 0.2s ease-in-out;
        }

        .movie-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .poster {
            width: 220px;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .movie-content {
            padding: 25px;
            flex-grow: 1;
        }

        .movie-title {
            font-size: 24px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
        }

        .movie-info {
            font-size: 15px;
            color: #fff;
            line-height: 1.6;
        }

        .btn-group {
            margin-top: 15px;
        }

        .btn-group a {
            margin-right: 10px;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f39c12, #f1c40f);
            color: white;
            border: none;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f1c40f, #f39c12);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
        }

        .btn-back {
            background-color: #34495e;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #2c3e50;
        }

        @media (max-width: 768px) {
            .movie-card {
                flex-direction: column;
                align-items: center;
            }

            .poster {
                width: 100%;
                height: auto;
            }

            .movie-content {
                text-align: center;
            }

            .btn-group {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🎬 Movie List</h1>

    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($movie_result) > 0): ?>
        <?php while ($movie = mysqli_fetch_assoc($movie_result)): ?>
            <div class="movie-card">
                <img class="poster" src="<?= !empty($movie['poster']) ? $movie['poster'] : 'images/placeholder.jpg' ?>" alt="Poster">
                <div class="movie-content">
                    <div class="movie-title"><?= htmlspecialchars($movie['title']) ?></div>
                    <div class="movie-info">
                        <strong>Genre:</strong> <?= htmlspecialchars($movie['genre']) ?><br>
                        <strong>Duration:</strong> <?= htmlspecialchars($movie['duration']) ?> minutes<br><br>
                        <strong>Description:</strong><br> <?= nl2br(htmlspecialchars($movie['description'])) ?>
                    </div>
                    <div class="btn-group">
                        <a href="edit_movie.php?movie_id=<?= $movie['movie_id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                        <a href="delete_movie.php?movie_id=<?= $movie['movie_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this movie?')">🗑️ Delete</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">No movies found.</div>
    <?php endif; ?>

    <br>
    <center>
        <a href="admin_dashboard.php" class="btn-back">← Back to Dashboard</a>
    </center>

</div>

</body>
</html>

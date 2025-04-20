<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php?error=Access denied. Please login as a customer.");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            font-family: 'Poppins', sans-serif;
            color: #fff;
            padding-top: 50px;
        }

        .container {
            max-width: 1200px;
            margin-top: 60px;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .movie-card {
            border: none;
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
        }

        .movie-card img {
            width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .movie-card h5 {
            color: #00c6ff;
            font-size: 24px;
            margin-top: 15px;
        }

        .movie-card p {
            color: #ddd;
        }

        .btn-primary {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: #fff;
            font-size: 18px;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0072ff, #00c6ff);
        }

        .btn-back {
            display: block;
            margin: 40px auto 0;
            width: 100%;
            max-width: 300px;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 10px;
            background-color: #ff4b2b;
            color: #fff;
            text-align: center;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #ff3e1d;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Available Movies</h1>

    <?php
    if (mysqli_num_rows($movie_result) > 0) {
        while ($movie = mysqli_fetch_assoc($movie_result)) {
            ?>
            <div class="card movie-card">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?php echo $movie['poster']; ?>" alt="<?php echo $movie['title']; ?>">
                    </div>
                    <div class="col-md-8">
                        <h5><?php echo $movie['title']; ?></h5>
                        <p><strong>Genre: </strong><?php echo $movie['genre']; ?></p>
                        <p><strong>Description: </strong><?php echo substr($movie['description'], 0, 150) . '...'; ?></p>
                        <a href="book_ticket.php?movie_id=<?php echo $movie['movie_id']; ?>" class="btn btn-primary">Book Ticket</a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='alert alert-warning text-center'>No movies available at the moment.</div>";
    }
    ?>

    <a href="customer_dashboard.php" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    <br><br>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Admins only.");
    exit();
}

// ========== Decorator Design Pattern ==========

interface MovieUpdater {
    public function update(array $data): string;
}

class BasicMovieUpdater implements MovieUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function update(array $data): string {
        $stmt = mysqli_prepare($this->conn, "UPDATE movies SET title = ?, genre = ?, description = ?, poster = ? WHERE movie_id = ?");
        mysqli_stmt_bind_param($stmt, 'ssssi', $data['title'], $data['genre'], $data['description'], $data['poster'], $data['movie_id']);
        if (mysqli_stmt_execute($stmt)) {
            return "<div class='alert alert-success text-center mt-3'>Movie details updated successfully!</div>";
        } else {
            return "<div class='alert alert-danger text-center mt-3'>Error updating movie: " . mysqli_error($this->conn) . "</div>";
        }
    }
}

abstract class MovieUpdaterDecorator implements MovieUpdater {
    protected $updater;

    public function __construct(MovieUpdater $updater) {
        $this->updater = $updater;
    }

    public function update(array $data): string {
        return $this->updater->update($data);
    }
}

class ValidationDecorator extends MovieUpdaterDecorator {
    public function update(array $data): string {
        if (empty($data['title']) || empty($data['genre']) || empty($data['description'])) {
            return "<div class='alert alert-danger text-center mt-3'>All fields are required.</div>";
        }
        return parent::update($data);
    }
}


if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];

    $movie_sql = "SELECT * FROM movies WHERE movie_id = ?";
    $stmt = mysqli_prepare($conn, $movie_sql);
    mysqli_stmt_bind_param($stmt, 'i', $movie_id);
    mysqli_stmt_execute($stmt);
    $movie_result = mysqli_stmt_get_result($stmt);
    $movie = mysqli_fetch_assoc($movie_result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    if (!empty($image)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $target_file = $movie['poster'];
    }

    $data = [
        'movie_id' => $movie_id,
        'title' => $title,
        'genre' => $genre,
        'description' => $description,
        'poster' => $target_file
    ];

    $updater = new ValidationDecorator(new BasicMovieUpdater($conn));
    $msg = $updater->update($data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Movie</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            padding-bottom: 50px;
        }

        .container {
            max-width: 800px;
            margin-top: 60px;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .form-group label {
            color: #ecf0f1;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid #34495e;
            color: white;
            font-size: 16px;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: #2980b9;
            box-shadow: 0 0 5px rgba(41, 128, 185, 0.7);
        }

        .btn-primary {
            background-color: #2980b9;
            color: white;
            width: 100%;
            font-size: 18px;
            padding: 12px;
            border-radius: 8px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3498db;
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

        .img-thumbnail {
            margin-top: 20px;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 30px;
            }

            .btn-primary {
                width: auto;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Movie Details</h1>
    <?php if (isset($msg)) echo $msg; ?>

    <div class="card">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">

            <div class="form-group">
                <label for="title">Movie Title</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $movie['title']; ?>" required>
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" class="form-control" name="genre" id="genre" value="<?php echo $movie['genre']; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="4" required><?php echo $movie['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Movie Poster</label>
                <input type="file" class="form-control-file" name="image" id="image">
                <?php if ($movie['poster']): ?>
                    <img src="<?php echo $movie['poster']; ?>" alt="Current Poster" class="img-thumbnail mt-3" width="200">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Update Movie</button>
            <br><br>
            <center>
                <a href="admin_dashboard.php" class="btn btn-back">Back to Dashboard</a>
            </center>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

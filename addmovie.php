<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Please login as Admin.");
    exit();
}

// ========== Singleton Design Pattern ==========
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "movie_theater_db";

        $this->conn = mysqli_connect($servername, $username, $password, $database);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function __clone() {}

    public function __wakeup() {}
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string(Database::getInstance()->getConnection(), $_POST['title']);
    $genre = mysqli_real_escape_string(Database::getInstance()->getConnection(), $_POST['genre']);
    $duration = mysqli_real_escape_string(Database::getInstance()->getConnection(), $_POST['duration']);
    $description = mysqli_real_escape_string(Database::getInstance()->getConnection(), $_POST['description']);

    $poster_path = "";

    if (!empty($_FILES['poster']['name'])) {
        $poster_tmp = $_FILES['poster']['tmp_name'];
        $poster_name = time() . "_" . basename($_FILES['poster']['name']);
        $upload_dir = "uploads/posters/";
        $poster_path = $upload_dir . $poster_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (!move_uploaded_file($poster_tmp, $poster_path)) {
            $message = "<div class='alert alert-warning'>⚠️ Poster upload failed.</div>";
            $poster_path = "";
        }
    }

    $sql = "INSERT INTO movies (title, genre, duration, description, poster) 
            VALUES ('$title', '$genre', '$duration', '$description', '$poster_path')";

    if (mysqli_query(Database::getInstance()->getConnection(), $sql)) {
        $message .= "<div class='alert alert-success'>✅ Movie added successfully!</div>";
    } else {
        $message .= "<div class='alert alert-danger'>❌ Error: " . mysqli_error(Database::getInstance()->getConnection()) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Movie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        .container {
            max-width: 700px;
            margin-top: 60px;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-weight: 600;
            font-size: 30px;
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: 600;
            color: #fff;
        }

        .form-control,
        .form-control-file {
            border-radius: 8px;
            font-size: 16px;
            padding: 10px;
        }

        .btn-primary {
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            padding: 12px;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: white;
            border: none;
            width: 100%;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0072ff, #00c6ff);
        }

        .btn-secondary {
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            padding: 12px;
            background: #ff4b2b;
            color: #fff;
            border: none;
            width: 100%;
        }

        .btn-secondary:hover {
            background: #ff3e1d;
        }

        .alert {
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🎬 Add New Movie</h1>

        <?php if (!empty($message)) echo $message; ?>

        <div class="card">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Movie Title:</label>
                    <input type="text" class="form-control" name="title" id="title" required>
                </div>

                <div class="form-group">
                    <label for="genre">Genre:</label>
                    <input type="text" class="form-control" name="genre" id="genre" required>
                </div>

                <div class="form-group">
                    <label for="duration">Duration (minutes):</label>
                    <input type="number" class="form-control" name="duration" id="duration" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="poster">Poster (optional):</label>
                    <input type="file" class="form-control-file" name="poster" id="poster" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Add Movie</button>
            </form>

            <br>
            <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>

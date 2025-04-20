<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Please login as Admin.");
    exit();
}

// ----- Factory Design pattern -----
class Showtime {
    public $movie_id, $screen_no, $time, $price;

    public function __construct($movie_id, $screen_no, $time, $price) {
        $this->movie_id = $movie_id;
        $this->screen_no = $screen_no;
        $this->time = $time;
        $this->price = $price;
    }

    public function save($conn) {
        $stmt = $conn->prepare("INSERT INTO showtimes (movie_id, screen_no, time, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisd", $this->movie_id, $this->screen_no, $this->time, $this->price);
        return $stmt->execute();
    }
}

class ShowtimeFactory {
    public static function createShowtime($movie_id, $screen_no, $time, $price) {
        return new Showtime($movie_id, $screen_no, $time, $price);
    }
}
// --------------------------------------

$movies_result = mysqli_query($conn, "SELECT * FROM movies");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $screen_no = $_POST['screen_no'];
    $time = $_POST['time'];
    $price = $_POST['price'];

    $showtime = ShowtimeFactory::createShowtime($movie_id, $screen_no, $time, $price);

    if ($showtime->save($conn)) {
        echo "<div class='alert alert-success'>Showtime added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error while adding showtime.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Showtime</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            padding-bottom: 50px;
        }

        .container {
            max-width: 600px;
            margin-top: 60px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
            font-weight: bold;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid #007bff;
            border-radius: 10px;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.3);
            border-color: #3498db;
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

        .btn-block {
            margin-top: 20px;
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

        .alert {
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Showtime</h2>
    <form method="POST">
        <div class="form-group">
            <label for="movie_id">Select Movie:</label>
            <select name="movie_id" class="form-control" required>
                <option value="">-- Select a Movie --</option>
                <?php while ($row = mysqli_fetch_assoc($movies_result)) { ?>
                    <option value="<?php echo $row['movie_id']; ?>"><?php echo $row['title']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="screen_no">Screen Number:</label>
            <input type="number" name="screen_no" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time">Showtime (YYYY-MM-DD HH:MM):</label>
            <input type="datetime-local" name="time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="price">Ticket Price:</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Add Showtime</button>
        <br><br>

        <center>
            <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
        </center>
    </form>
</div>

</body>
</html>

<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php?error=Please login as a Customer to submit a review.");
    exit();
}

$user_id = $_SESSION['user_id']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO reviews (movie_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $movie_id, $user_id, $rating, $comment);

    if ($stmt->execute()) {
        $success = "Review submitted successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

$movies = $conn->query("SELECT movie_id, title FROM movies");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Review</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .review-form {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }
        .form-control, .btn {
            border-radius: 10px;
        }
        .btn {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="review-form">
    <h3 class="text-center mb-4">Leave a Movie Review 🎬</h3>

    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST">
        <div class="form-group">
            <label for="movie_id">Movie</label>
            <select name="movie_id" id="movie_id" class="form-control" required>
                <option value="">Select Movie</option>
                <?php while ($row = $movies->fetch_assoc()) : ?>
                    <option value="<?= $row['movie_id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="rating">Rating (1 to 5)</label>
            <input type="number" name="rating" id="rating" min="1" max="5" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="comment">Your Comment</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="What did you think?" required></textarea>
        </div>

        <button type="submit" class="btn btn-success btn-block">Submit Review</button>
        <br>
        <div class="text-center mt-3">
            <a href="customer_dashboard.php" class="btn btn-warning">🔙 Back to Dashboard</a>
        </div>
    </form>
</div>

</body>
</html>

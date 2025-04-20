<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php?error=Access denied. Please login as Customer.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #A9C9FF, #FFBBEC);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .dashboard-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            color: #4A4A4A;
        }

        .nav-link {
            display: block;
            background: linear-gradient(135deg, #6CC1FF,rgb(235, 151, 179));
            color: #fff;
            text-align: center;
            padding: 12px 25px;
            margin: 15px 0;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .nav-link:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        .home-btn {
            margin-top: 20px;
            display: inline-block;
            background: #4A4A4A;
            color: #fff;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s, transform 0.3s;
        }

        .home-btn:hover {
            background: #333;
            transform: scale(1.05);
        }

        .welcome-message {
            font-size: 18px;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

    </style>
</head>

<body>

    <div class="container">
        <div class="dashboard-container">
            <h2>Welcome to Your Dashboard</h2>
            <p class="welcome-message">We are thrilled to have you here! Explore and manage your bookings, reviews, and support requests.</p>

            <div class="text-center">
                <a href="book_ticket.php" class="nav-link">🎟️ Book Ticket</a>
                <a href="userviewmovie.php" class="nav-link">🎥 View Movie List</a>
                <a href="view_my_ticket.php" class="nav-link">🎥 Downlode Ticket</a>
                <a href="review.php" class="nav-link">📝 Review Movie</a>
                <a href="create_report.php" class="nav-link">📞 Customer Support</a>
            </div>

            <div class="text-center mt-3">
                <a href="logout.php" class="home-btn">🚪 Logout</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

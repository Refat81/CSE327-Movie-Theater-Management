<?php
session_start();


if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Please login as Admin.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
    }

    .dashboard-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 40px 30px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
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
      color: #fff;
    }

    .nav-link {
      display: block;
      background: linear-gradient(135deg, #1d976c, #93f9b9);
      color: #000;
      text-align: center;
      padding: 12px 20px;
      margin: 10px 0;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .nav-link:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
      color: #000;
    }

    .home-btn {
      margin-top: 20px;
      display: inline-block;
      background: #ff4b2b;
      color: #fff;
      padding: 12px 25px;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s, transform 0.3s;
    }

    .home-btn:hover {
      background: #ff3e1d;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <div class="dashboard-container">
    <h2>Admin Dashboard</h2>
    <a href="make_admin.php" class="nav-link">🛡️ Make Admin</a>
    <a href="addmovie.php" class="nav-link">🎬 Add New Movie</a>
    <a href="viewmovie.php" class="nav-link">📃 View Movie List</a>
    <a href="viewmovie.php" class="nav-link">🛠️ Delete & Edit Movies</a>
    <a href="view_users.php" class="nav-link">👥 View Users</a>
    <a href="add_showtime.php" class="nav-link">⏰ Add Show Time</a>
    <a href="showtimes_list.php" class="nav-link">❌ Delete Show</a>
    <a href="view_feedback.php" class="nav-link">💬 View Feedback</a>
    <a href="view_review.php" class="nav-link">⭐ View review</a>

    <div class="text-center">
      <a href="logout.php" class="home-btn">🚪 Logout</a>
    </div>
  </div>

</body>
</html>

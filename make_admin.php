<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Admins only.");
    exit();
}

require 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST['user_id'];

    $stmt = $conn->prepare("UPDATE users SET role = 'Admin' WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "✅ User promoted to Admin successfully.";
    } else {
        $message = "⚠️ Failed to promote user. Please try again.";
    }
    $stmt->close();
}

$result = $conn->query("SELECT user_id, name, email, role FROM users WHERE role != 'Admin'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Make Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      height: 100vh;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .admin-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 40px 30px;
      width: 90%;
      max-width: 900px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 32px;
      color: #fff;
    }

    .table {
      background: transparent;
      color: #fff;
    }

    .table thead th {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .btn-make-admin {
      background: linear-gradient(135deg, #1d976c, #93f9b9);
      border: none;
      color: #000;
      font-weight: bold;
      padding: 6px 12px;
      border-radius: 8px;
      transition: transform 0.2s;
    }

    .btn-make-admin:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
    }

    .back-btn {
      display: inline-block;
      margin-top: 20px;
      background: #ff4b2b;
      color: #fff;
      padding: 12px 25px;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s, transform 0.3s;
    }

    .back-btn:hover {
      background: #ff3e1d;
      transform: scale(1.05);
    }

    .message {
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
      color: #00ffae;
    }
  </style>
</head>
<body>

<div class="admin-container">
  <h2>👑 Promote Users to Admin</h2>

  <?php if (isset($message)) echo "<div class='message'>$message</div>"; ?>

  <div class="table-responsive">
    <table class="table table-hover table-bordered">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['user_id']) ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['role']) ?></td>
          <td>
            <form method="POST">
              <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
              <button type="submit" class="btn btn-make-admin">Make Admin</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <div class="text-center">
    <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
  </div>
</div>

</body>
</html>

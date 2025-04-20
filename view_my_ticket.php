<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php?error=Access denied. Please login as Customer.");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT t.ticket_id, t.seat_no, t.status, s.time, s.screen_no, s.price, m.title
    FROM tickets t
    JOIN showtimes s ON t.show_id = s.show_id
    JOIN movies m ON s.movie_id = m.movie_id
    WHERE t.user_id = '$user_id'
    ORDER BY t.ticket_id DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right,rgb(192, 216, 226),rgb(126, 156, 167), #2c5364);
            font-family: 'Poppins', sans-serif;
            color: #fff;
            padding-top: 50px;
        }
        .container {
            max-width: 900px;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        table {
            color: #fff;
        }
        th {
            background-color: #1d3557;
            color: #fff;
        }
        .btn-download {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
        }
        .btn-download:hover {
            background: #0056b3;
            color: #fff;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }
        .back-link a:hover {
            color: #ccc;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fas fa-ticket-alt mr-2"></i>My Booked Tickets</h2>
    <div class="card">
        <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Movie</th>
                        <th>Showtime</th>
                        <th>Screen</th>
                        <th>Seat</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($ticket = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $ticket['ticket_id'] ?></td>
                            <td><?= htmlspecialchars($ticket['title']) ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($ticket['time'])) ?></td>
                            <td><?= $ticket['screen_no'] ?></td>
                            <td><?= strtoupper($ticket['seat_no']) ?></td>
                            <td>$<?= $ticket['price'] ?></td>
                            <td><span class="badge badge-success"><?= $ticket['status'] ?></span></td>
                            <td>
                                <a href="ticket.php?ticket_id=<?= $ticket['ticket_id'] ?>" class="btn btn-download">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="alert alert-info text-center">You haven't booked any tickets yet.</div>
        <?php endif; ?>
    </div>

    <div class="back-link">
        <a href="customer_dashboard.php"><i class="fas fa-arrow-left mr-2"></i>Back to Dashboard</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

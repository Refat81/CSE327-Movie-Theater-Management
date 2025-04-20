<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php?error=Access denied. Please login as Customer.");
    exit();
}

// ========== Observer Design Pattern ==========
interface TicketObserver {
    public function onTicketBooked($ticketData);
}

class EmailService implements TicketObserver {
    public function onTicketBooked($ticketData) {
        error_log("EmailService: Email sent for ticket ID " . $ticketData['ticket_id']);
    }
}

class PaymentService implements TicketObserver {
    public function onTicketBooked($ticketData) {
        error_log("PaymentService: Payment processed for ticket ID " . $ticketData['ticket_id']);
    }
}

class TicketBookingSubject {
    private $observers = [];

    public function attach(TicketObserver $observer) {
        $this->observers[] = $observer;
    }

    public function notify($ticketData) {
        foreach ($this->observers as $observer) {
            $observer->onTicketBooked($ticketData);
        }
    }
}

$user_id = $_SESSION['user_id'];
$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : null;

if ($movie_id) {
    $showtimes_sql = "SELECT * FROM showtimes WHERE movie_id = '$movie_id'";
    $showtimes_result = mysqli_query($conn, $showtimes_sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['show_id'], $_POST['seat_no'], $_POST['payment_method'])) {
    $show_id = $_POST['show_id'];
    $seat_no = strtoupper(trim($_POST['seat_no']));
    $payment_method = $_POST['payment_method'];

    if (empty($payment_method)) {
        $msg = "<div class='alert alert-warning text-center mt-3'>Please select a payment method.</div>";
    } else {
        $check_sql = "SELECT * FROM tickets WHERE show_id = '$show_id' AND seat_no = '$seat_no'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $msg = "<div class='alert alert-warning text-center mt-3'>Seat already booked! Please choose another seat.</div>";
        } else {
            $insert_sql = "INSERT INTO tickets (user_id, show_id, seat_no, status) VALUES ('$user_id', '$show_id', '$seat_no', 'Booked')";
            if (mysqli_query($conn, $insert_sql)) {
                $ticket_id = mysqli_insert_id($conn);

                $ticketData = [
                    'ticket_id' => $ticket_id,
                    'user_id' => $user_id,
                    'show_id' => $show_id,
                    'seat_no' => $seat_no
                ];

                $subject = new TicketBookingSubject();
                $subject->attach(new EmailService());
                $subject->attach(new PaymentService());
                $subject->notify($ticketData);

                $msg = "<div class='alert alert-success text-center mt-3'>
                            Payment via <strong>$payment_method</strong> successful.<br>
                            Ticket booked successfully! 
                            <a href='ticket.php?ticket_id=$ticket_id' class='btn btn-sm btn-success ml-2'>Download Ticket</a>
                        </div>";
            } else {
                $msg = "<div class='alert alert-danger text-center mt-3'>Booking failed: " . mysqli_error($conn) . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            font-family: 'Poppins', sans-serif;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            max-width: 700px;
            width: 100%;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: none;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        h1 i {
            vertical-align: middle;
            font-size: 28px;
            color: #ff4757;
            margin-right: 10px;
        }
        label {
            color: #fff;
            font-weight: 500;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            width: 100%;
            font-size: 16px;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            background: linear-gradient(135deg, #1d976c, #93f9b9);
            color: #000;
            border: none;
        }
        .btn-primary:hover {
            background: #1fab89;
            color: #fff;
        }
        .seat-map {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin: 20px 0;
        }
        .seat {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
        }
        .available {
            background-color: #28a745;
            color: white;
        }
        .booked {
            background-color: #dc3545;
            color: white;
        }
        .back-btn {
            margin-top: 20px;
            text-align: center;
        }
        .back-btn a {
            color: #fff;
            font-weight: 500;
            text-decoration: none;
            transition: 0.3s;
        }
        .back-btn a:hover {
            color: #ccc;
        }
    </style>
</head>
<body>

<div class="container">
    <h1><i class="fas fa-ticket-alt"></i>Book Your Ticket</h1>
    <?php if (isset($msg)) echo $msg; ?>

    <div class="card">
        <?php if (!$movie_id): ?>
            <form method="GET">
                <div class="form-group">
                    <label for="movie_id"><i class="fas fa-film mr-2" style="color:#b197fc;"></i> Select Movie</label>
                    <select name="movie_id" id="movie_id" class="form-control" required>
                        <option value="">-- Choose a Movie --</option>
                        <?php
                        $movie_result = mysqli_query($conn, "SELECT * FROM movies");
                        while ($movie = mysqli_fetch_assoc($movie_result)) {
                            echo "<option value='{$movie['movie_id']}'>{$movie['title']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Load Showtimes</button>
            </form>
        <?php elseif (isset($showtimes_result) && mysqli_num_rows($showtimes_result) > 0): ?>
            <form method="POST">
                <div class="form-group">
                    <label for="show_id"><i class="fas fa-clock mr-2" style="color:#ffd166;"></i> Select Showtime</label>
                    <select class="form-control" name="show_id" id="show_id" required>
                        <?php while ($row = mysqli_fetch_assoc($showtimes_result)): ?>
                            <option value="<?= $row['show_id'] ?>">
                                <?= date('Y-m-d H:i', strtotime($row['time'])) ?> | Screen <?= $row['screen_no'] ?> | $<?= $row['price'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="seat-map">
                    <?php
                    $rows = ['A', 'B', 'C', 'D', 'E'];
                    $cols = 5;
                    $default_show_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT show_id FROM showtimes WHERE movie_id = '$movie_id' LIMIT 1"))['show_id'];
                    $use_show_id = $_POST['show_id'] ?? $default_show_id;

                    $booked_seats = [];
                    $seat_query = mysqli_query($conn, "SELECT seat_no FROM tickets WHERE show_id = '$use_show_id'");
                    while ($s = mysqli_fetch_assoc($seat_query)) {
                        $booked_seats[] = $s['seat_no'];
                    }

                    foreach ($rows as $r) {
                        for ($i = 1; $i <= $cols; $i++) {
                            $seat = $r . $i;
                            $class = in_array($seat, $booked_seats) ? 'booked' : 'available';
                            echo "<div class='seat $class'>$seat</div>";
                        }
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label for="seat_no"><i class="fas fa-chair mr-2" style="color:#00d4ff;"></i> Seat Number (e.g., A1, B5)</label>
                    <input type="text" class="form-control" name="seat_no" id="seat_no" required>
                </div>

                <div class="form-group">
                    <label for="payment_method"><i class="fas fa-credit-card mr-2" style="color:#f4a261;"></i> Select Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="">-- Choose Payment Method --</option>
                        <option value="Card">Credit/Debit Card</option>
                        <option value="bKash">bKash</option>
                        <option value="Nagad">Nagad</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Book Ticket</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center">No showtimes found for this movie.</div>
        <?php endif; ?>

        <div class="back-btn">
            <a href="customer_dashboard.php"><i class="fas fa-arrow-left mr-2"></i>Back to Dashboard</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

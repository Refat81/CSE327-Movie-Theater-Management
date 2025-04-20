<?php
include('connection.php');

$ticket_id = $_GET['ticket_id'];
$sql = "SELECT t.ticket_id, u.name, m.title, s.time, s.screen_no, t.seat_no 
        FROM tickets t
        JOIN users u ON t.user_id = u.user_id
        JOIN showtimes s ON t.show_id = s.show_id
        JOIN movies m ON s.movie_id = m.movie_id
        WHERE t.ticket_id = '$ticket_id'";
$result = mysqli_query($conn, $sql);
$ticket = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Ticket</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }

        .ticket {
            background: #fff;
            border: 2px dashed #333;
            padding: 30px;
            width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative;
        }

        .ticket-header {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .ticket-section {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .label {
            font-weight: bold;
            color: #444;
        }

        .qr {
            position: absolute;
            top: 30px;
            right: 30px;
        }

        .download-btn {
            display: block;
            text-align: center;
            margin-top: 30px;
        }

        .download-btn a {
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 25px;
        }
    </style>
</head>
<body>

<div class="ticket" id="ticketContent">
    <div class="ticket-header">Movie Ticket</div>
    
    <div class="ticket-section"><span class="label">Ticket ID:</span> <?php echo $ticket['ticket_id']; ?></div>
    <div class="ticket-section"><span class="label">Name:</span> <?php echo $ticket['name']; ?></div>
    <div class="ticket-section"><span class="label">Movie:</span> <?php echo $ticket['title']; ?></div>
    <div class="ticket-section"><span class="label">Showtime:</span> <?php echo $ticket['time']; ?></div>
    <div class="ticket-section"><span class="label">Screen:</span> <?php echo $ticket['screen_no']; ?></div>
    <div class="ticket-section"><span class="label">Seat:</span> <?php echo $ticket['seat_no']; ?></div>

    <div class="qr">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=TicketID<?php echo $ticket['ticket_id']; ?>" alt="QR Code">
    </div>
</div>

<div class="download-btn">
    <a href="#" onclick="printTicket()">Download Ticket</a>
</div>

<script>
    function printTicket() {
        var printContents = document.getElementById('ticketContent').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

</body>
</html>
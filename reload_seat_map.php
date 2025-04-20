<?php
include("connection.php");

if (isset($_POST['show_id'])) {
    $show_id = $_POST['show_id'];

    $booked_seats = [];
    $seat_query = mysqli_query($conn, "SELECT seat_no FROM tickets WHERE show_id = '$show_id'");
    while ($s = mysqli_fetch_assoc($seat_query)) {
        $booked_seats[] = $s['seat_no'];
    }

    $rows = ['A', 'B', 'C', 'D', 'E'];
    $cols = 5;

    foreach ($rows as $r) {
        for ($i = 1; $i <= $cols; $i++) {
            $seat = $r . $i;
            $class = in_array($seat, $booked_seats) ? 'booked' : 'available';
            echo "<div class='seat $class'>$seat</div>";
        }
    }
}
?>

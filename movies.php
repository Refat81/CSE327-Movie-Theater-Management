<?php
include("connection.php");

$sql = "SELECT * FROM movies";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
</head>
<body>
    <h1>Available Movies</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Genre</th>
                <th>Duration</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['genre']; ?></td>
                    <td><?php echo $row['duration']; ?> mins</td>
                    <td><?php echo $row['description']; ?></td>
                    <td><a href="book_ticket.php?movie_id=<?php echo $row['movie_id']; ?>">Book Ticket</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

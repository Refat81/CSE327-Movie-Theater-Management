<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            font-family: 'Arial', sans-serif;
            color: white;
            padding-bottom: 50px;
        }

        .container {
            max-width: 1200px;
            margin-top: 40px;
        }

        .movie-details {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            color: #ecf0f1;
        }

        .movie-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }

        .movie-description {
            padding: 15px;
        }

        .movie-description p {
            font-size: 14px;
            line-height: 1.5;
        }

        .book-ticket-btn {
            margin-top: 10px;
            font-size: 16px;
            border-radius: 25px;
            padding: 8px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .book-ticket-btn:hover {
            background-color: #218838;
            color: white;
        }

        .custom-back-btn {
            border-radius: 25px;
            padding: 10px 25px;
            font-size: 16px;
            font-weight: 500;
            border: 2px solid #ffffff;
            transition: all 0.3s ease;
            color: #ffffff;
        }

        .custom-back-btn:hover {
            background-color: #ffffff;
            color: #2c3e50;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row">

        <!-- Movie 1 -->
        <div class="col-md-6">
            <div class="movie-details">
                <div class="movie-header">Avengers: Infinity War</div>
                <div class="movie-description">
                    <p><strong>Genre:</strong> SuperHero, Action</p>
                    <p><strong>Duration:</strong> 2h 29m</p>
                    <p>Thanos aims to collect all Infinity Stones and wipe out half of life. The Avengers must unite to stop him in an epic showdown.</p>
                    <a href="login.php" class="book-ticket-btn">Book Ticket</a>
                </div>
            </div>
        </div>

        <!-- Movie 2 -->
        <div class="col-md-6">
            <div class="movie-details">
                <div class="movie-header">Avengers: Endgame</div>
                <div class="movie-description">
                    <p><strong>Genre:</strong> SuperHero, Action, Sci-Fi</p>
                    <p><strong>Duration:</strong> 3h 1m</p>
                    <p>The Avengers reassemble after the snap to undo the chaos and bring back lost allies in this emotional and powerful conclusion.</p>
                    <a href="login.php" class="book-ticket-btn">Book Ticket</a>
                </div>
            </div>
        </div>

        <!-- Movie 3 -->
        <div class="col-md-6">
            <div class="movie-details">
                <div class="movie-header">Thor: Love and Thunder</div>
                <div class="movie-description">
                    <p><strong>Genre:</strong> SuperHero, Fantasy</p>
                    <p><strong>Duration:</strong> 1h 59m</p>
                    <p>Thor embarks on a journey of self-discovery, but must face Gorr the God Butcher with help from Valkyrie and Jane Foster.</p>
                    <a href="login.php" class="book-ticket-btn">Book Ticket</a>
                </div>
            </div>
        </div>

        <!-- Movie 4 -->
        <div class="col-md-6">
            <div class="movie-details">
                <div class="movie-header">Jurassic World</div>
                <div class="movie-description">
                    <p><strong>Genre:</strong> Adventure, Sci-Fi, Action</p>
                    <p><strong>Duration:</strong> 2h 4m</p>
                    <p>A new theme park built on the original site of Jurassic Park goes haywire when a genetically engineered dinosaur escapes.</p>
                    <a href="login.php" class="book-ticket-btn">Book Ticket</a>
                </div>
            </div>
        </div>

        <!-- Movie 5 -->
        <div class="col-md-6">
            <div class="movie-details">
                <div class="movie-header">Men in Black</div>
                <div class="movie-description">
                    <p><strong>Genre:</strong> Sci-Fi, Comedy, Action</p>
                    <p><strong>Duration:</strong> 1h 38m</p>
                    <p>Agents J and K of a top-secret organization protect the Earth from alien threats and ensure intergalactic peace.</p>
                    <a href="login.php" class="book-ticket-btn">Book Ticket</a>
                </div>
            </div>
        </div>

        <!-- Movie 6 -->
        <div class="col-md-6">
            <div class="movie-details">
                <div class="movie-header">Deadpool & Wolverine</div>
                <div class="movie-description">
                    <p><strong>Genre:</strong> Action, Comedy, SuperHero</p>
                    <p><strong>Duration:</strong> 2h 10m</p>
                    <p>Deadpool joins forces with Wolverine for a wild adventure full of snark, claws, and fourth-wall-breaking chaos.</p>
                    <a href="login.php" class="book-ticket-btn">Book Ticket</a>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-outline-light custom-back-btn">← Back to Dashboard</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

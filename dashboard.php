<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Movie Theater Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background-color: #141414;
      color: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    nav {
      background-color: transparent;
      position: absolute;
      top: 0;
      width: 100%;
      z-index: 10;
    }

    .navbar-nav li a {
      color: white;
      margin: 17px;
      font-size: 16px;
      text-decoration: none;
      font-weight: 600;
    }

    .navbar-nav .active {
      color: #e50914;
    }

    .hero-section {
      position: relative;
      height: 100vh;
      background: url('images/net.jpg') no-repeat center center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      padding: 20px;
    }

    .hero-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }

    .hero-content {
      z-index: 2;
    }

    .hero-content h1 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .hero-content p {
      font-size: 1.25rem;
      margin-bottom: 30px;
    }

    .hero-content .btn {
      background-color: #e50914;
      border-color: #e50914;
      color: white;
      font-weight: bold;
    }

    .movie-card {
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s;
      background-color: #222;
      overflow: hidden;
      position: relative;
    }

    .movie-card:hover {
      transform: scale(1.05);
    }

    .card-img-top {
      object-fit: cover;
      height: 280px;
    }

    .card-body {
      padding: 15px;
    }

    .card-title {
      color: #fff;
      font-size: 1.25rem;
      font-weight: bold;
    }

    .card-text {
      font-size: 1rem;
      color: #aaa;
    }

    .btn-outline-danger {
      color: #e50914;
      border-color: #e50914;
      font-weight: 600;
    }

    .btn-outline-danger:hover {
      background-color: #e50914;
      color: white;
    }

    .movie-row {
      margin-top: 100px;
    }

    .movie-row h3 {
      font-size: 1.75rem;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .movie-grid {
      display: flex;
      overflow-x: scroll;
      gap: 20px;
      padding: 20px;
    }

    .movie-grid::-webkit-scrollbar {
      display: none;
    }

    footer {
      background-color: #141414;
      color: #777;
      padding: 20px 0;
      text-align: center;
    }

    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 2rem;
      }

      .hero-content p {
        font-size: 1rem;
      }

      .movie-grid {
        gap: 10px;
      }
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="dashboard.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="detiles.php">Browse Movies</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Admin Panel</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>Welcome to Movie Theater Management</h1>
      <p>Browse, book, and enjoy the latest movies anytime, anywhere.</p>
      <a href="login.php" class="btn btn-lg">Book Tickets</a>
    </div>
  </div>

  <div class="container">
    <div class="movie-row">
      <h3>Now Showing</h3>
      <div class="movie-grid">

        <!-- Movie Card 1 -->
        <div class="card movie-card">
          <img src="images/inf.jpg" class="card-img-top" alt="Infinity War">
          <div class="card-body">
            <h5 class="card-title">Infinity War</h5>
            <p class="card-text">Genre: Action, Superhero<br>Duration: 2h 29m</p>
            <a href="detiles.php" class="btn btn-outline-danger">View Details</a>
          </div>
        </div>

        <!-- Movie Card 2 -->
        <div class="card movie-card">
          <img src="images/endgame.jpg" class="card-img-top" alt="Endgame">
          <div class="card-body">
            <h5 class="card-title">End Game</h5>
            <p class="card-text">Genre: Action, Superhero<br>Duration: 3h 2m</p>
            <a href="detiles.php" class="btn btn-outline-danger">View Details</a>
          </div>
        </div>
                <!-- Movie Card 3 -->
        <div class="card movie-card">
          <img src="images/thoor.jpg" class="card-img-top" alt="Infinity War">
          <div class="card-body">
            <h5 class="card-title">Thor: Love and Thunder</h5>
            <p class="card-text">Genre: Action, Superhero<br>Duration: 2h</p>
            <a href="detiles.php" class="btn btn-outline-danger">View Details</a>
          </div>
        </div>
        <!-- Movie Card 4 -->
        <div class="card movie-card">
          <img src="images/jura.jpg" class="card-img-top" alt="Infinity War">
          <div class="card-body">
            <h5 class="card-title">Jurassic World</h5>
            <p class="card-text">Genre: Action, Adventure<br>Duration: 2h 4m</p>
            <a href="detiles.php" class="btn btn-outline-danger">View Details</a>
          </div>
        </div>
        <!-- Movie Card 5 -->
        <div class="card movie-card">
          <img src="images/mani.jpg" class="card-img-top" alt="Infinity War">
          <div class="card-body">
            <h5 class="card-title">Men in Black</h5>
            <p class="card-text">Genre: Action, Spy<br>Duration: 1h 38m</p>
            <a href="detiles.php" class="btn btn-outline-danger">View Details</a>
          </div>
        </div>
        <!-- Movie Card 6 -->
        <div class="card movie-card">
          <img src="images/de.webp" class="card-img-top" alt="Infinity War">
          <div class="card-body">
            <h5 class="card-title">Deadpool & Wolverine</h5>
            <p class="card-text">Genre: Action, Superhero<br>Duration: 2h 8m</p>
            <a href="detiles.php" class="btn btn-outline-danger">View Details</a>
          </div>
        </div>


      </div>
    </div>
  </div>

  <footer>
    &copy; Movie Theater Management System
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

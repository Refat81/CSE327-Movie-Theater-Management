<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - MTMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background: linear-gradient(135deg,rgb(68, 18, 18), #2a5298);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: fadeIn 1.2s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    .login-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      padding: 40px 30px;
      border-radius: 20px;
      width: 320px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      text-align: center;
      color: #fff;
    }

    .login-container h2 {
      font-size: 28px;
      margin-bottom: 25px;
      font-weight: 600;
    }

    label {
      display: block;
      text-align: left;
      margin-top: 15px;
      font-weight: 600;
      color: #f1f1f1;
      font-size: 14px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px 15px;
      margin-top: 5px;
      border: none;
      border-radius: 10px;
      background-color: rgba(255, 255, 255, 0.9);
      font-size: 14px;
    }

    input[type="submit"] {
      margin-top: 25px;
      padding: 12px;
      background-color: #00c6ff;
      background-image: linear-gradient(45deg, #0072ff, #00c6ff);
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      transition: transform 0.3s ease;
    }

    input[type="submit"]:hover {
      transform: scale(1.05);
    }

    .btn-link {
      display: block;
      margin-top: 15px;
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      padding: 10px 15px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-link:hover {
      background-color: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Login</h2>
    <form action="login_prosses.php" method="post">
      <label>Email:</label>
      <input type="text" name="username" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <input type="submit" name="submit" value="Login">

      <a class="btn-link" href="register.php">Register Now</a>
      <a class="btn-link" href="dashboard.php">Home</a><br><br>
    </form>
  </div>

</body>
</html>

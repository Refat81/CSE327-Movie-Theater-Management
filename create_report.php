<?php
include("connection.php");
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php?error=Access denied. Please login as Customer.");
    exit();
}

$user_id = $_SESSION['user_id'];

$msg = "";

// ----- facade design pattern -----
class UserService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function isLoggedIn($userId) {
        $query = "SELECT * FROM users WHERE user_id = '$userId' AND role = 'Customer'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result) > 0;
    }
}

class ReportService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function saveReport($userId, $reportType, $content) {
        $reportType = mysqli_real_escape_string($this->conn, $reportType);
        $content = mysqli_real_escape_string($this->conn, $content);

        $insertSql = "INSERT INTO reports (generated_by, report_type, content) VALUES ('$userId', '$reportType', '$content')";
        
        if (!mysqli_query($this->conn, $insertSql)) {
            throw new Exception("Error saving the report: " . mysqli_error($this->conn));
        }
    }
}

class ReportFacade {
    private $userService;
    private $reportService;

    public function __construct($userService, $reportService) {
        $this->userService = $userService;
        $this->reportService = $reportService;
    }

    public function submitReport($userId, $reportType, $content) {
        if (!$this->userService->isLoggedIn($userId)) {
            throw new Exception("User not logged in.");
        }

        $this->reportService->saveReport($userId, $reportType, $content);
    }
}


$userService = new UserService($conn);
$reportService = new ReportService($conn);
$reportFacade = new ReportFacade($userService, $reportService);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['report_type']) && isset($_POST['content'])) {
    try {
        $reportFacade->submitReport($user_id, $_POST['report_type'], $_POST['content']);
        $msg = "<div class='alert alert-success'>Your report has been submitted successfully!</div>";
    } catch (Exception $e) {
        $msg = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback - Report Issue</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            font-family: 'Poppins', sans-serif;
            color: #fff;
            padding-top: 50px;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: #fff;
            font-size: 18px;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0072ff, #00c6ff);
        }

        .btn-secondary {
            display: inline-block;
            margin-top: 20px;
            font-weight: 600;
            background-color: #ff4b2b;
            color: #fff;
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
        }

        .btn-secondary:hover {
            background-color: #ff3e1d;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Submit Your Feedback</h1>

    <?php if ($msg != "") echo $msg; ?>

    <div class="card">
        <form action="create_report.php" method="POST">
            <div class="form-group">
                <label for="report_type">Report Type</label>
                <select class="form-control" name="report_type" id="report_type" required>
                    <option value="">Select Report Type</option>
                    <option value="Complaint">Complaint</option>
                    <option value="Suggestion">Suggestion</option>
                    <option value="Bug Report">Bug Report</option>
                    <option value="General Feedback">General Feedback</option>
                </select>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" name="content" id="content" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Report</button>
        </form>
    </div>

    <center>
        <div class="mt-4">
            <a href="customer_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        </div>
    </center>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

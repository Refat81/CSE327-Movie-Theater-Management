<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php?error=Access denied. Admins only.");
    exit();
}

// ------------------- Proxy Design Pattern -------------------
interface UserAccess {
    public function getAllUsers($conn);
}

class UserManager implements UserAccess {
    public function getAllUsers($conn) {
        $sql = "SELECT * FROM users";
        return mysqli_query($conn, $sql);
    }
}

class UserProxy implements UserAccess {
    private $userManager;

    public function __construct() {
        $this->userManager = new UserManager();
    }

    public function getAllUsers($conn) {
        if ($_SESSION['role'] === 'Admin') {
            return $this->userManager->getAllUsers($conn);
        } else {
            return false;
        }
    }
}

$proxy = new UserProxy();
$users_result = $proxy->getAllUsers($conn);
// -------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(116, 77, 109),rgb(89, 123, 158));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            padding-bottom: 50px;
        }

        .container {
            max-width: 1000px;
            margin-top: 60px;
        }

        .card {
            background: rgba(240, 233, 233, 0.42);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .table th, .table td {
            text-align: center;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            margin-top: 10px;
        }

        .btn-sm {
            font-size: 12px;
            padding: 6px 12px;
        }

        .table-responsive {
            margin-top: 30px;
        }

        .back-btn {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-primary {
            background-color: #2980b9;
            color: white;
            width: 100%;
            font-size: 18px;
            padding: 12px;
            border-radius: 8px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3498db;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>View Users</h1>

    <?php
    if (isset($_GET['message'])) {
        echo "<div class='alert alert-success'>" . $_GET['message'] . "</div>";
    }

    if ($users_result && mysqli_num_rows($users_result) > 0): ?>
        <div class="card">
            <div class="card-body">
                <h4>Customer Details</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                                <tr>
                                    <td><?php echo $user['user_id']; ?></td>
                                    <td><?php echo $user['name']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><?php echo $user['role']; ?></td>
                                    <td>
                                        <a href="delete_user.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <center>
                    <a href="admin_dashboard.php" class="btn btn-primary back-btn">Back to Admin Dashboard</a>
                </center>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No users found or access denied.</div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

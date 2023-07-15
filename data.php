<!DOCTYPE html>
<html>
<head>
  <title>User Data</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: red;
      overflow: hidden;
      width: 100%;
    }

    .navbar a {
      float: left;
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }

    .navbar a:hover {
      background-color: #ddd;
    }

    .navbar a.active {
      background-color: #4CAF50;
      color: white;
    }

    .table-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
    }

    table {
      border-collapse: collapse;
      width: 50%;
      text-align: center;
    }

    th, td {
      border: 2px solid red;
      padding: 8px;
    }
  </style>
</head>
<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="aboutus.php">About Us</a>
    <a href="signup.php">Signup</a>
    <a href="login.php">Login</a>
</div>
<?php

function connectToDatabase() {
    $host = "localhost";
    $dbname = "task";
    $username = "mahi";
    $password = "mahi11 7";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch(PDOException $e) {
        echo "Database Connection Error: " . $e->getMessage();
        exit;
    }
}

$conn = connectToDatabase();

session_start(); 
if (isset($_SESSION['user_email'])) {
    $userEmail = $_SESSION['user_email'];

    // Fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $userEmail);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch course data for the user
    if ($userData) {
        $userId = $userData['uid'];

        $stmt = $conn->prepare("SELECT * FROM course WHERE uid = :uid");
        $stmt->bindParam(':uid', $userId);
        $stmt->execute();
        $courseData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $courseData = []; 
    }
} else {
    $userData = []; 
    $courseData = []; 
}

// Close the database connection
$conn = null;
?>

<?php if (count($courseData) > 0): ?>
  <div class="table-container">
    <table>
      <tr>
        <th>Name</th>
        <th>Mark</th>
        <th>Grade</th>
      </tr>
      <?php foreach ($courseData as $course): ?>
        <tr>
          <td><?php echo $course['name']; ?></td>
          <td><?php echo $course['mark']; ?></td>
          <td><?php echo $course['grade']; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
<?php else: ?>
  <p>Your grades are not submitted yet.</p>
<?php endif; ?>

</body>
</html>






<!DOCTYPE html>
<html>
<?php

$email = $password = "";

$emailErr = $passwordErr = "";


function sanitizeInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// start db conn

function connectToDatabase() {
  $host = "localhost"; 
  $dbname = "task"; 
  $username = "mahi"; 
  $password = "mahi11 7"; 

  
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

  
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  return $conn;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validation

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = sanitizeInput($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = sanitizeInput($_POST["password"]);
  }

  
  if ($emailErr == "" && $passwordErr == "") {
    try {
      
      $conn = connectToDatabase();

      
      $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();

      //  user
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      
      if ($user && password_verify($password, $user['password'])) {
        echo "Login successful!";
      } else {
        echo "Invalid email or password!";
      }
    

    // Close db conn
    $conn = null;

    header("Location: data.php");
      exit;
  } catch(PDOException $e) {
    
    echo "Error: " . $e->getMessage();
  }
}
}
?>
<head>
  <title>Login Form</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: white;
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

    .form-container {
      border: 2px solid red;
      padding: 20px;
      margin-top: 20px;
    }

    .error {
      color: red;
    }

    .center-button {
      display: flex;
      justify-content: center;
      align-items: center;
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

  <div class="form-container">
    <h2>Login Form</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="mb-3">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
        <span class="error"><?php echo $emailErr; ?></span>
      </div>
      <br>
      <div class="mb-3">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <span class="error"><?php echo $passwordErr; ?></span>
      </div>
      <br>
      <div class="center-button">
        <input type="submit" name="submit" value="Login">
      </div>
    </form>
  </div>
</body>

</html>

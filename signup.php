<!DOCTYPE html>
<html>
<?php

$name = $code = $email = $number = $password = "";


$nameErr = $codeErr = $emailErr = $numberErr = $passwordErr = "";


function sanitizeInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


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
  // Validate name
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = sanitizeInput($_POST["name"]);
  }

  
  if (empty($_POST["code"])) {
    $codeErr = "Code is required";
  } else {
    $code = sanitizeInput($_POST["code"]);
  }

  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = sanitizeInput($_POST["email"]);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  
  if (empty($_POST["number"])) {
    $numberErr = "Number is required";
  } else {
    $number = sanitizeInput($_POST["number"]);
  }

  
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = sanitizeInput($_POST["password"]);
  }

  
  if ($nameErr == "" && $codeErr == "" && $emailErr == "" && $numberErr == "" && $passwordErr == "") {
    try {
      
      $conn = connectToDatabase();

    
      $stmt = $conn->prepare("INSERT INTO users 
                   (name, code, email, number, password) 
                VALUES 
                   (:name, :code, :email, :number, :password)");

      
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':code', $code);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':number', $number);
      $stmt->bindParam(':password', $password);

  
      $stmt->execute();

      // Close db conn
      $conn = null;

      
      header("Location: login.php");
      exit;
    } catch(PDOException $e) {
    
      echo "Error: " . $e->getMessage();
    }
  }
}
?>
<head>
  <title>Registration Form</title>
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
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Registration Form</h2>
    <div class="mb-3">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name">
      <span class="error"><?php echo $nameErr; ?></span>
    </div>
    <br><br>
    <div class="mb-3">
      <label for="code">Code:</label>
      <input type="text" name="code" id="code">
      <span class="error"><?php echo $codeErr; ?></span>
    </div>
    <br><br>
    <div class="mb-3">
      <label for="email">Email:</label>
      <input type="text" name="email" id="email">
      <span class="error"><?php echo $emailErr; ?></span>
    </div>
    <br><br>
    <div class="mb-3">
      <label for="number">Number:</label>
      <input type="text" name="number" id="number">
      <span class="error"><?php echo $numberErr; ?></span>
    </div>
    <br><br>
    <div class="mb-3">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password">
      <span class="error"><?php echo $passwordErr; ?></span>
    </div>
    <br><br>
    <div class="center-button">
      <input type="submit" name="submit" value="Register">
    </div>
  </form>
</div>
</body>
</html>


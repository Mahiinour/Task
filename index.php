<!DOCTYPE html>
<html>
<head>
  <title>Registration Website</title>
  <style>
    body {
      background-color: #ffffff;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    .navbar {
      background-color: red;
      overflow: hidden;
      width: 100%;
    }

    .navbar a {
      float: left;
      display: block;
      color: black;
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

    .content {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #ffffff;
      border: 1px solid #ff0000;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .description {
      font-size: 16px;
      margin-bottom: 20px;
    }

    .button-container {
      text-align: center;
    }

    .register-button {
      display: inline-block;
      background-color: #ff0000;
      color: #ffffff;
      padding: 10px 20px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .register-button:hover {
      background-color: #990000;
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

  <div class="content">
    <div class="title">Register Now</div>
    <div class="description">Join our community and register for an account today. Take advantage of our exciting features and services.</div>
    <div class="button-container">
      <a href="signup.php" class="register-button">Register</a>
    </div>
  </div>
</body>
</html>

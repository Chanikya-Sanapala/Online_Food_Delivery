<?php
session_start();

// If user not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Food Delivery Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Sidebar + Dashboard content -->
  <div class="sidebar">
    <a href="#">Search</a>
    <a href="#">Home</a>
    <a href="#">Favs</a>
    <a href="#">Profile</a>
    <a href="#">Setting</a>
    <a href="logout.php" style="color: red;">Logout</a>
  </div>

  <div class="dashboard">
    <h1>Welcome, <?php echo $_SESSION['first_name']; ?> 👋</h1>
    <p>50% OFF Tasty Food On Your Hand</p>

    <h2>Recommended Food for You</h2>
    <!-- your food items here -->
  </div>
</body>
</html>

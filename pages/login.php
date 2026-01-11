<?php
session_start();
require '../includes/config.php';

// Handle Registration
if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName  = $_POST['lName'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
         echo "<script>alert('Email already exists! Please sign in.'); 
               window.location.href='login.php';</script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! You can login now.'); 
                  window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error registering user.');</script>";
        }
        $stmt->close();
    }
    $checkEmail->close();
}

// Handle Login
if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['role'] = $row['role']; // Store role in session

            // Redirect based on role (optional)
            if ($row['role'] === 'admin') {
                echo "<script>window.location.href='../admin/dashboard.php';</script>";
            } else {
                echo "<script>window.location.href='../index.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('User not found! Please register.');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Food Delivery - Login / Signup</title>
  <!-- Updated Path to CSS -->
  <link rel="stylesheet" href="../assets/css/login.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed; background-size: cover;">
  
  <!-- Sign Up Form -->
  <div class="container" id="signup" style="display:none;">
    <h1>Create Account</h1>
    <!-- Action is self -->
    <form method="post" action="login.php">
      <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="fName" placeholder="First Name" required>
      </div>
      <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="lName" placeholder="Last Name" required>
      </div>
      <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="name@example.com" required>
      </div>
      <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
      </div>
      <input type="submit" value="Sign Up" name="signUp" class="btn">
    </form>
    <p>Already have an ID? <button id="signInButton" class="link-btn">Sign In</button></p>
  </div>

  <!-- Sign In Form -->
  <div class="container" id="signIn">
    <h1>Sign In</h1>
    <form method="post" action="login.php">
      <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="name@example.com" required>
      </div>
      <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
      </div>
      <input type="submit" value="Sign In" name="signIn" class="btn">
    </form>
    <p>Don't have an account? <button id="signUpButton" class="link-btn">Sign Up</button></p>
  </div>

  <!-- Updated Path to JS -->
  <script src="../assets/js/log.js"></script>
</body>
</html>

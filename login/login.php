<?php
include 'config.php';

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            echo "<script>alert('Login successful! Welcome {$row['first_name']}'); 
                  window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Invalid password!'); 
                  window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found! Please register.'); 
              window.location.href='login.html';</script>";
    }
}
?>

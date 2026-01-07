<?php
include 'config.php';

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName  = $_POST['lName'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, email, password) 
            VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful! You can login now.'); 
              window.location.href='login.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

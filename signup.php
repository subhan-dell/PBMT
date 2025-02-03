<?php
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["s_password"];

    
    $sql_check = "SELECT * FROM login WHERE username='$email'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('User already exists. Please log in.'); window.location.href='index.html';</script>";
    } else {
        $sql_insert = "INSERT INTO login (username, password) VALUES ('$email', '$password')";
        if (mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('Registration successful! Please log in.'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Error occurred. Please try again.'); window.location.href='index.html';</script>";
        }
    }
}

mysqli_close($conn);
?>

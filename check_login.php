<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION["username"] = $username;
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "<script>alert('Invalid username or password. Please sign up.'); window.location.href='index.html';</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["username"]) && isset($_GET["password"])) {
        $username = $_GET["username"];
        $password = $_GET["password"];

        $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            echo "Login successful via GET method!";
        } else {
            echo "Invalid credentials via GET method!";
        }
    }
}

mysqli_close($conn);
?>

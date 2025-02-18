<?php
// PHP Code Start
$conn = mysqli_connect('localhost', 'root', '', 'pbmt');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM expenses WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Expense deleted successfully!'); window.location.href='userdata2.php';</script>";
    } else {
        echo "<script>alert('Error deleting expense'); window.location.href='userdata2.php';</script>";
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
// PHP Code End
?>

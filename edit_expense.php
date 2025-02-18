<?php
// PHP Code Start
$conn = mysqli_connect('localhost', 'root', '', 'pbmt');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM expenses WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $expense = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (isset($_POST['update_expense'])) {
    $id = $_POST['id'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $day = $_POST['day'];

    $sql = "UPDATE expenses SET category=?, amount=?, date=?, day=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sdssi", $category, $amount, $date, $day, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Expense updated successfully!'); window.location.href='userdata2.php';</script>";
    } else {
        echo "<script>alert('Error updating expense'); window.location.href='userdata2.php';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
// PHP Code End
?>

<!-- HTML Code Start -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-4">Edit Expense</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">
            
            <label>Expense Category:</label>
            <select name="category" class="form-control" required>
                <option value="Housing" <?php if ($expense['category'] == 'Housing') echo 'selected'; ?>>Housing</option>
                <option value="Utilities" <?php if ($expense['category'] == 'Utilities') echo 'selected'; ?>>Utilities</option>
                <option value="Food" <?php if ($expense['category'] == 'Food') echo 'selected'; ?>>Food</option>
                <option value="Transportation" <?php if ($expense['category'] == 'Transportation') echo 'selected'; ?>>Transportation</option>
                <option value="Entertainment" <?php if ($expense['category'] == 'Entertainment') echo 'selected'; ?>>Entertainment</option>
                <option value="Savings" <?php if ($expense['category'] == 'Savings') echo 'selected'; ?>>Savings</option>
            </select><br>

            <label>Expense Amount:</label>
            <input type="number" name="amount" class="form-control" value="<?php echo $expense['amount']; ?>" required><br>

            <label>Date:</label>
            <input type="date" name="date" class="form-control" value="<?php echo $expense['date']; ?>" required><br>

            <label>Add Day:</label>
            <input type="text" name="day" class="form-control" value="<?php echo $expense['day']; ?>" required><br>

            <button type="submit" name="update_expense" class="btn btn-success">Update Expense</button>
        </form>
    </div>
</body>
</html>
<!-- HTML Code End -->

<?php 
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Data</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: white;
            color: black;
            overflow-x: hidden;
        }
        h2 {
            text-align: center;
        }

        /* Navbar styling */
        .navbar {
            background-color: #1E3A8A;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .navbar-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .navbar-container ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
        }

        .navbar-container ul li {
            margin: 5px;
        }

        .navbar-container ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            font-size: 16px;
            background: #4CAF50;
            border-radius: 4px;
            display: inline-block;
            transition: 0.3s;
        }

        .navbar-container ul li a:hover {
            background-color: #357a38;
        }

        /* Edit delete btn */
        .btn {
            display: inline-block;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        /* Edit button (yellow) */
        .btn-warning {
            background-color: #FFC107;
            color: black;
            border: 1px solid #FFC107;
        }

        .btn-warning:hover {
            background-color: #E0A800;
            border-color: #D39E00;
            color: white;
        }

        /* Delete button (red) */
        .btn-danger {
            background-color: #DC3545;
            color: white;
            border: 1px solid #DC3545;
        }

        .btn-danger:hover {
            background-color: #C82333;
            border-color: #BD2130;
        }

        /* Table Styling */
        .table-container {
            width: 90%;
            margin: auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #1E3A8A;
            color: white;
        }

        /* Responsive Table */
        @media screen and (max-width: 600px) {
            th, td {
                padding: 8px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <?php 
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        while ($row = mysqli_fetch_array($query)) {
            echo $row['fName'].' '.$row['lName'];
        }
    }
    ?> 
    <div class="navbar-container">
        <ul class="navbar-menu">
            <li><a href="userdata.php">Add Budget</a></li>
            <li><a href="homepage2.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav><br><br>

<!-- Search Form for Day -->
<div style="text-align: center; margin-bottom: 20px;">
    <form method="POST" action="">
        <label for="day">Enter Day Name: </label>
        <input type="text" name="day" id="day" required>
        <button type="submit" name="search_day">Search</button>
    </form>
</div>

<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'pbmt');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize the SQL query
$sql = "SELECT * FROM expenses";

// Check if the form has been submitted and filter by day
if (isset($_POST['search_day'])) {
    $day_name = mysqli_real_escape_string($conn, $_POST['day']);
    $sql .= " WHERE day LIKE '%$day_name%'"; 
}

// Execute the query
$result = mysqli_query($conn, $sql);

// Display the table of expenses
?>

<!-- Table for displaying data -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Day</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['amount']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['day']}</td>
                        <td>
                            <a href='edit_expense.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_expense.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No expenses found for the selected day.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Calculate total expenses
$sql = "SELECT SUM(amount) AS total_expenses FROM expenses";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_expenses = $row['total_expenses'];
mysqli_close($conn);
?>

<!-- Display Total Expenses -->
<div id="total-expenses" style="margin-top: 20px; padding: 10px; border: 1px solid black; color:black; background-color:rgb(252, 249, 249);">
    <h3>Total Expenses for This Month: <?php echo number_format($total_expenses, 2); ?>Rs</h3>
</div>

</body>
</html>

<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'pbmt');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch total expenses for this month
$today = date('Y-m-d');
$sql = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE MONTH(date) = MONTH(CURRENT_DATE())";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_expenses = $row['total_expenses'];

// Fetch latest monthly income
$sql_income = "SELECT income FROM monthly_income ORDER BY id DESC LIMIT 1";
$result_income = mysqli_query($conn, $sql_income);
$row_income = mysqli_fetch_assoc($result_income);
$monthly_income = isset($row_income['income']) ? $row_income['income'] : 0;

// Expense form submission
if (isset($_POST['submit_expense'])) {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $day = $_POST['day'];

    $sql = "INSERT INTO expenses (category, amount, date, day) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sdss", $category, $amount, $date, $day);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Expense added successfully!')</script>";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// Monthly income form submission
if (isset($_POST['submit_income'])) {
    $monthly_income = $_POST['monthly_income'];
    $sql = "INSERT INTO monthly_income (income) VALUES (?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "d", $monthly_income);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Monthly income added successfully!')</script>";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// Fetch categories and expenses data for the chart
$category_data = [];
$amount_data = [];
$categories_sql = "SELECT category, SUM(amount) as category_amount FROM expenses WHERE MONTH(date) = MONTH(CURRENT_DATE()) GROUP BY category";
$categories_result = mysqli_query($conn, $categories_sql);

while ($row_category = mysqli_fetch_assoc($categories_result)) {
    $category_data[] = $row_category['category'];
    $amount_data[] = $row_category['category_amount'];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, rgb(238, 242, 245), #8e44ad);
            color: white;
            overflow-x: hidden;
        }

        h2 {
            margin: auto;
        }

        .navbar {
            background-color: #1E3A8A;
            color: white;
            padding: 15px 0;
        }

        .navbar-container ul {
            list-style-type: none;
            display: flex;
            justify-content: space-around;
        }

        .navbar-container ul li {
            display: inline;
        }

        .navbar-container ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            font-size: 18px;
        }

        .navbar-container ul li a:hover {
            background-color: #4CAF50;
            border-radius: 4px;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            color: black
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #1E3A8A;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #2563EB;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px 10px;
            text-align: center;
            color: #333;
        }

        table th {
            background-color: #1E3A8A;
            color: white;
        }

        .chart-container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            text-align: center;
        }

        canvas {
            max-width: 100% !important;
            height: auto !important;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            font-size: 1.8rem;
            color: #1E3A8A;
        }

        @media (max-width: 768px) {
            .navbar-container ul {
                flex-direction: column;
                align-items: center;
            }

            .navbar-container ul li {
                margin: 5px 0;
            }

            form {
                padding: 15px;
                margin: 15px;
            }

            table {
                font-size: 14px;
            }

            .chart-container {
                margin: 0 10px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <?php 
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $conn = mysqli_connect('localhost', 'root', '', 'pbmt');
            $query = mysqli_query($conn, "SELECT * FROM signin WHERE email='$email'");
            while ($row = mysqli_fetch_array($query)) {
                echo $row['fName'] . ' ' . $row['lName'];
            }
        }
        ?>
        <div class="navbar-container">
            <ul class="navbar-menu">
            <li><a href="homepage2.php">Home</a></li>
                <li><a href="userdata.php">Add Budget</a></li>
                <li><a href="previous_data.php">Expense History</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <h2>Welcome to Your Budget Management</h2>

    <?php if ($monthly_income == 0) : ?>
        <h2>Enter Monthly Income</h2>
        <form method="POST" action="">
            <label for="monthly_income">Monthly Income:</label>
            <input type="number" id="monthly_income" name="monthly_income" required><br>
            <button type="submit" name="submit_income">Submit Income</button>
        </form>
    <?php else : ?>
        <div id="total-income" style="margin-top: 20px; padding: 10px; border: 1px solid black; background-color: rgb(17, 17, 17);">
            <h3>Your Monthly Income: <?php echo number_format($monthly_income, 2); ?> Rs</h3>
        </div>
    <?php endif; ?>

    <h2>Add Today's Expense</h2>
    <form method="POST" action="">
        <label for="category">Expense Category:</label>
        <select id="category" name="category" required>
            <option value="Housing">Housing</option>
            <option value="Utilities">Utilities</option>
            <option value="Food">Food</option>
            <option value="Transportation">Transportation</option>
            <option value="Entertainment">Entertainment</option>
            <option value="Savings">Savings</option>
        </select><br>

        <label for="amount">Expense Amount:</label>
        <input type="number" id="amount" name="amount" required><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required><br>

        <label for="day">Add Day:</label>
        <input type="text" id="day" name="day" required><br>

        <button type="submit" name="submit_expense">Add Expense</button>
    </form>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Day</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = mysqli_connect('localhost', 'root', '', 'pbmt');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT id, category, amount, date, day FROM expenses WHERE date = CURDATE()";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
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
                echo "<tr><td colspan='4'>No expenses added yet for today.</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>

    <div id="total-expenses" style="margin-top: 20px; padding: 10px; border: 1px solid black; background-color: rgb(14, 13, 13);">
        <h3>Total Expenses for This Month: <?php echo number_format($total_expenses, 2); ?> Rs</h3>
        <h3>Income of This Month: <?php echo number_format($monthly_income, 2); ?> Rs</h3>
    </div>

    <a href="previous_data.php" class="btn btn-primary" style="display: block; width: 200px; text-align: center; margin: 20px auto;">See Previous Data</a>

    <h2>Expenses Distribution (Pie Chart)</h2>
    <div class="chart-container">
        <canvas id="expenseChart"></canvas>
    </div>

    <h2>Expenses Over Time (Line Chart)</h2>
    <div class="chart-container">
        <canvas id="lineChart"></canvas>
    </div>

    <script>
        const categoryLabels = <?php echo json_encode($category_data); ?>;
        const categoryAmounts = <?php echo json_encode($amount_data); ?>;

        const ctx = document.getElementById('expenseChart').getContext('2d');
        const expenseChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Expense Categories',
                    data: categoryAmounts,
                    backgroundColor: ['#FF9999', '#66B3FF', '#99FF99', '#FFCC99', '#FFC0CB', '#D3D3D3'],
                    borderColor: ['#FF6666', '#3399FF', '#66FF66', '#FF9966', '#FF66B3', '#A9A9A9'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + ' Rs';
                            }
                        }
                    }
                }
            }
        });

        const lineChartData = {
            labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
            datasets: [{
                label: "Expenses Over Time",
                data: [<?php echo $total_expenses; ?>, <?php echo $total_expenses; ?>, <?php echo $total_expenses; ?>, <?php echo $total_expenses; ?>],
                borderColor: "#1E3A8A",
                borderWidth: 2,
                fill: false,
            }]
        };

        const lineChart = new Chart(document.getElementById('lineChart').getContext('2d'), {
            type: 'line',
            data: lineChartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        ticks: {
                            beginAtZero: true
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>

<?php
session_start();
include("connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Management Tool</title>
    <link rel="stylesheet" href="stylee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            color: white;
            overflow-x: hidden;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 15px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: #1abc9c;
        }

        .navbar-brand img{
            width: 70px;
            height: 70px;
            padding: 0;
        }
        .navbar-brand img:hover{
            width: 75px;
            height: 75px;
        }
        .navbar-menu {
            list-style-type: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .navbar-menu li {
            margin: 0 15px;
        }

        .navbar-menu a {
            text-decoration: none;
            color: #ecf0f1;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .navbar-menu a:hover {
            color: #1abc9c;
        }

 /*Box animation start*/       
.box {
    position: relative;
    width: 800px;
    height: 340px;
    background: #1c1c1c;
    border-radius: 8px;
    overflow: hidden;
    margin: auto;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px;
}

.borderline {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 8px;
    pointer-events: none;
    overflow: hidden;
}

.borderline::before, 
.borderline::after {
    content: '';
    position: absolute;
    width: 200%;
    height: 200%;
    left: -50%;
    top: -50%;
    background: conic-gradient(#45f3ff, #45f3ff);
    animation: rotateBorder 6s linear infinite;
}

.borderline::after {
    animation-delay: -3s;
    opacity: 0.7;
}

@keyframes rotateBorder {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.content {
    position: relative;
    z-index: 2;
    background: #1c1c1c;
    padding: 40px;
    border-radius: 8px;
    text-align: center;
    width: 100%;
    height:100%;
}

.content h2 {
    font-size: 2rem;
    color: #45f3ff;
}

.content p {
    font-size: 1.5rem;
    color: #bdc3c7;
}

.content button {
    background-color: #1abc9c;
    color: white;
    padding: 10px 20px;
    font-size: 18px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.content button:hover {
    background-color: #16a085;
}
/*logo Section*/

.logo-item {
    position: relative;
    z-index: 2;
    background: #1c1c1c;
    padding: 40px;
    border-radius: 8px;
    text-align: center;
    width: 100%;
    height:100%;
}

.logo-item img {
    width: 100%;
    max-width: 400px;
    height: auto;
    object-fit: contain; 
}


/*Footer*/
        footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.3);
        }

        .feature-section {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 60px 20px;
            text-align: center;
            color: white;
        }

        .feature-section h2 {
            font-size: 3.5vw;
            color: #ecf0f1;
            margin-bottom: 30px;
        }

        .feature-section p {
            color: #bdc3c7;
            font-size: 1.5vw;
            margin-bottom: 20px;
        }

        .feature-card {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 8px;
            padding: 30px;
            margin: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: inline-block;
            max-width: 300px;
            width: 100%;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #1abc9c;
        }

        .feature-card p {
            font-size: 16px;
            color: #bdc3c7;
        }

        .cta-btn {
            margin-top: 50px;
        }

        .cta-btn a {
            background-color: #1abc9c;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .cta-btn a:hover {
            background-color: #16a085;
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: block;
                text-align: center;
                margin-top: 10px;
            }

            .navbar-menu li {
                margin-bottom: 10px;
            }

            .hero-content {
                padding: 20px;
            }

            .hero-content h1 {
                font-size: 4vw;
            }

            .hero-content p {
                font-size: 4vw;
            }

            .feature-card {
                max-width: 100%;
                margin-bottom: 20px;
            }

            .feature-section h2 {
                font-size: 5vw;
            }

            .feature-section p {
                font-size: 4vw;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-brand">
        <img src="asserts\logo1.png" alt="Site logo"> 
            Budget Management Tool
        </div>
        <ul class="navbar-menu">
        <?php 
            if(isset($_SESSION['email'])){
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT * FROM signin WHERE email='$email'");
                while($row = mysqli_fetch_array($query)){
                    echo '<li>'.$row['fName'].' '.$row['lName'].'</li>';
                }
            }
            ?>
            <li><a href="previous_data.php">Check User Data</a></li>
            <li><a href="userdata.php">Add User Data</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<br><br><br><br><br><br>

<!-- Hero Section -->
<div class="box">
    <span class="borderline"></span>
    <div class="content">
        <h2>Welcome to Budget Management Tool</h2>
        <p>Track your monthly expenses and manage your budget effectively with our tool. Stay on top of your finances with ease!</p>
        <a href="userdata.php" target="_blank">
    <button>Start Managing Your Budget</button>
</a>
    </div>
</div>


<!-- logo Section -->
 <div class="box">
 <span class="borderline"></span>
    <div class="logo-item">
        <img src="asserts\logo.png" alt="Growth Accounting"> 
    </div>
</div>
<!-- Features Section -->
<div class="feature-section">
    <h2>Why Use the Budget Management Tool?</h2>
    <p>Our tool helps you take control of your finances, providing you with the insights you need to make informed decisions.</p>
    
    <div class="feature-card">
        <h3>Track Your Expenses</h3>
        <p>Keep track of your daily, weekly, or monthly expenses to ensure you're staying within budget.</p>
    </div>

    <div class="feature-card">
        <h3>Plan for the Future</h3>
        <p>Set savings goals and work towards building your future with better financial planning.</p>
    </div>

    <div class="feature-card">
        <h3>Generate Reports</h3>
        <p>Get detailed reports of your spending to visualize where your money is going each month.</p>
    </div>

    
</div>

<br><br><br><br><br><br><br><br><br>

<!-- Footer -->
<footer>
    <p>&copy; 2025 Budget Management Tool. All Rights Reserved.</p>
</footer>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #23242a;
        }
        .box {
            position: relative;
            width: 380px;
            height: 420px;
            background: #1c1c1c;
            border-radius: 8px;
            overflow: hidden;
            margin: auto;
        }
        .box::before{
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 380px;
            height: 420px;
            background: linear-gradient(0deg, transparent,transparent,#45f3ff,#45f3ff,#45f3ff);
            z-index: 1;
            transform-origin: bottom right;
            animation: animate 6s linear infinite;

        }
        .box::after{
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 380px;
            height: 420px;
            background: linear-gradient(0deg, transparent,transparent,#45f3ff,#45f3ff,#45f3ff);
            z-index: 1;
            transform-origin: bottom right;
            animation: animate 6s linear infinite;
            animation-delay: -3s;

        }
        .borderline{
            position: absolute;
            top: 0;
            inset: 0;
        }
        .borderline::before{
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 380px;
            height: 420px;
            background: linear-gradient(0deg, transparent,transparent,#b11858,#b11858,#b11858);
            z-index: 1;
            transform-origin: bottom right;
            animation: animate 6s linear infinite;
            animation-delay: -1.5s;
        }
        .borderline::after{
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 380px;
            height: 420px;
            background: linear-gradient(0deg, transparent,transparent,#b11858,#b11858,#b11858);
            z-index: 1;
            transform-origin: bottom right;
            animation: animate 6s linear infinite;
            animation-delay: -4.5s;
        }
        @keyframes animate{
            0%{
                transform: rotate(0deg);
            }
            100%{
                transform: rotate(360deg);
            }
        }
        .box form {
            position: absolute;
            inset: 4px;
            background: #23242a;
            padding: 50px 40px;
            border-radius: 8px;
            z-index: 2;
            display: flex;
            flex-direction: column;
            display: none; 
        }
        .box form.active {
            display: flex; 
        }
        .box form h2 {
            color: #fff;
            font-weight: 500;
            align-items: center;
            letter-spacing: 0.1em;
        }
        .box form .inputbox {
            position: relative;
            width: 300px;
            margin-top: 35px;
        }
        .box form .inputbox input {
            width: 100%;
            padding: 20px 10px 10px;
            background: transparent;
            outline: none;
            border: none;
            color: #fff;
            font-size: 1em;
            letter-spacing: 0.05em;
        }
        #signin-form .inputbox span {
            position: absolute;
            left: 0;
            padding: 20px 0px 10px;
            pointer-events: none;
            color: #8f8f8f;
            transition: 0.5s;
        }
        #signin-form .inputbox input:valid ~ span,
        #signin-form .inputbox input:focus ~ span {
            color: #fff;
            font-size: 0.75em;
            transform: translateY(-30px);
        }
        #signin-form .inputbox i{
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2px;
            background: #686767;
            border-radius: 4px;
            overflow: hidden;
            transition: 0.5s;
            pointer-events: none;
        }
        /* #signin-form.inputbox input:valid ~ i,
        #signin-form .inputbox input:focus ~ i{
            height: 44px;
        } */
        .box form .links {
            display: flex;
            justify-content: space-between;
        }
        .box form .links a {
            font-size: 0.75em;
            text-decoration: none;
            color: #00bfff;
            cursor: pointer;
        }
        .box form .links a:hover {
            color: #afff;
        }
        #signin-form input[type="button"] {
            border: none;
            padding: 9px 25px;
            background: #fff;
            cursor: pointer;
            font-size: 0.9em;
            border-radius: 4px;
            width: 100%;
            margin-top: 10px;
        }
        #signin-form input[type="button"]:active {
            opacity: 0.8;
        }
         #signup-form input[type="submit"] {
            border: none;
            padding: 9px 25px;
            background: #fff;
            cursor: pointer;
            font-size: 0.9em;
            border-radius: 4px;
            width: 100%;
            margin-top: 10px;
        }
         #signup-form input[type="submit"]:active {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="box">
        <span class="borderline"></span>
        <form id="signin-form" class="active" action="login.php" method="GET">
            <h2>Sign In</h2>
            <div class="inputbox">
                <input type="text" id="username" name="username" required >
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputbox">
                <input type="password" id="password" name="password" required >
                <span>Password</span>
                <i></i>
            </div>
            <div class="links">
                <a href="#" >Forget Password</a>
                <a href="#" id="signup-link">Sign Up</a>
                
            </div>
            <input type="button" value="Login" id="login-button" name="submit">
        </form>

        <form id="signup-form" action="signup.php" method="post">
            <h2>Sign Up</h2>
            <div class="inputbox">
                <input type="text" placeholder="Full Name" name="fullname" required>
            </div>
            <div class="inputbox">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="inputbox">
                <input type="password" placeholder="Password" name="s_password" required>
            </div>
            <div class="links">
                <a href="#" id="signin-link">Sign In</a>
            </div>
            <input type="submit" value="Register">
        </form>
    </div>
    
    <script>
        const signinForm = document.getElementById('signin-form');
        const signupForm = document.getElementById('signup-form');
        const signupLink = document.getElementById('signup-link');
        const signinLink = document.getElementById('signin-link');

        signupLink.addEventListener('click', () => {
            signinForm.classList.remove('active');
            signupForm.classList.add('active');
        });

        signinLink.addEventListener('click', () => {
            signupForm.classList.remove('active');
            signinForm.classList.add('active');
        });

        const loginButton = document.getElementById('login-button');
        loginButton.addEventListener('click', () => {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username === 'abc' && password === '123') {
                window.location.href = "file:///D:/BBMS/PBMT2.0/index.html"; 
            } else {
                alert('Invalid username or password!');
            }
        });
    </script>
    <?php 

      $host="localhost";
      $user="root";
      $password="";
      $db="pbmt";
      
      $conn=mysqli_connect($host,$user,$password,$db);
      
      if(isset($_POST['submit'])){
          $ftna=$_POST['username'];
          $ltna=$_POST['password'];
          $sql = "INSERT INTO clients_data
          VALUES ('$ftna','$ltna')";  
            
         if (mysqli_query($conn, $sql)) {
          echo "Record send successfully";
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        mysqli_close($conn);
              
      }
      
    ?>
</body>
</html>
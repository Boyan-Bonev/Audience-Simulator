<?php
    session_start();
    if(isset($_SESSION["user"]))
    {
        header("Location: ../dashboard/dashboard.php");
    }
?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
 </head>
 <body>
    <div class="container">
        <h2> Login </h2>
        <?php
            if(isset($_POST["login"]))
            {
                $email = $_POST["email"];
                $password = $_POST["password"];
                require_once "database.php";
                $sql = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($conn,$sql);
                $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
                if($user)
                {
                    if(password_verify($password,$user["password"]))
                    {
                        session_start();
                        $_SESSION["user"]=$user["email"];
                        $_SESSION["userId"]=$user["id"];
                        header("Location: ../dashboard/dashboard.php");
                        die();
                    }
                    else
                    {
                        echo "<div class='alert alert-danger'> Incorrect password! </div>";
                    }
                }
                else
                {
                    echo "<div class='alert alert-danger'> Incorrect email! </div>";
                }
            }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>Not registered yet? <a href="registration.php"> Sign up here </a> </div>
    </div>
 </body>
 </html>
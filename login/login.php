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
    <section class="container">
        <h2> Login </h2>
        <?php
            if(isset($_POST["login"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                
                require_once "database.php";

                $sql = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($conn,$sql);
                $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
                if(!$user) {
                    echo "<section class='alert alert-danger'> Incorrect email! </section>";
                    exit();
                }
                if(!password_verify($password,$user["password"])) {
                    echo "<section class='alert alert-danger'> Incorrect password! </section>";
                }

                session_start();
                $_SESSION["user"]=$user["email"];
                $_SESSION["userId"]=$user["id"];
                header("Location: ../dashboard/dashboard.php");
                die();
            }
        ?>
        <form action="login.php" method="post">
            <section class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </section>
            <section class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </section>
            <section class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </section>
        </form>
        <section>Not registered yet? <a href="registration.php"> Sign up here </a> </section>
    </section>
 </body>
 </html>
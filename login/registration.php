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
    <title>Sign up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="container">
        <h2> Sign up </h2>
        <?php
        if (isset($_POST["submit"])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            $image = "placeholder.jpg";
            $role = "normal";
            $points = 0;

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if(empty($name) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
                array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors,"Password must be at least 8 characters long");
            }
            if ($password!==$passwordRepeat) {
                array_push($errors, "Password does not match");
            }

            require_once "../connectToEvents.php";

            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn,$sql);
            $rowCount = mysqli_num_rows($result);
            if($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }

            if(count($errors)>0) {
                foreach ($errors as $error)
                {
                    echo "<section class='alert alert-danger'>$error</section>";
                }
            }
            else {
                $sql = "INSERT INTO users (name,email,photo,password,role,points) VALUES (?,?,?,?,?,?);";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                
                if($prepareStmt) {
                    mysqli_stmt_bind_param($stmt,"sssssi",$name,$email,$image,$passwordHash,$role,$points);
                    mysqli_stmt_execute($stmt);
                    echo "<section class='alert alert-success'>You are registered successfully!</section>";
                }
                else {
                    die();
                }
            }
        }
        ?>
        <form action="registration.php" method="post">
            <section class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Full Name:">
            </section> 
            <section class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Email:">
            </section> 
            <section class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password: ">
            </section> 
            <section class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Confirm Password: ">
            </section> 
            <section class="form-btn">
                <input type="submit" class="btn btn-primary" class="form-control" value="Sign up" name="submit">
            </section> 
            
        </form>
        <section>Already registered? <a href="login.php"> Login Here </a> </section>
    </section>
</body>
</html>
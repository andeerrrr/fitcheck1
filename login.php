<?php

    include 'config.php';

    if(isset($_GET['notif'])) {
        $message = $_GET['notif'];
        echo '<h4 id="notif" style="color:green;">'.$message.'</h4>';
        
        echo '
                <script>
                setTimeout(function() {
                    document.getElementById("notif").style.display = "none";
                }, 3000);
                </script>
            ';
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['login'])) { 
        $username = $_POST['uname'];
        $password = $_POST['pwd'];
    
        $login = "SELECT * FROM users where username ='$username'";
        $result = $conn->query($login);
    
        
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                if($row['pword'] == $password) {
                    session_start();

                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['password'] = $row['pword'];
                    $_SESSION['firstname'] = $row['firstname'];
                    $_SESSION['lastname'] = $row['lastname'];
                    $_SESSION['sex'] = $row['sex'];
                    $_SESSION['date'] = $row['dob'];
                    $_SESSION['login'] = true;
                    header('Location: index.php');

                } else {
                    $message = "Invalid password!";
                header('Location: login.php?notif='.$message);
                    
                }
            } else {
                $message = "Username not found!";
                header('Location: login.php?notif='.$message);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="Assets/icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body class="login">
    <div class="container">
    <form method="post">
        <center><img src="Assets/logo.png"></center>
        <label for="textbox"></label>
        <input type="text" name="uname" placeholder="Username" id="uname" class="typing">
        <label for="textbox"></label><br><br>
        <input type="password" name="pwd" placeholder="Password" id="pass" class="typing">
        <input type="submit" value = "Login" name = "login" id="loginbt"><br>
        <a href="sign_up.php" id="sign_up">Don't have an account?</a>
    </form>
    </div>
</body>
</html>

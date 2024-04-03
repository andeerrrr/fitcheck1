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
        if (isset($_POST['adminlogin'])) { 
        $username = $_POST['admin_uname'];
        $password = $_POST['admin_pwd'];
    
        $adminlogin = "SELECT * FROM admin where admin_username ='$username'";
        $result = $conn->query($adminlogin);
    
        
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                if($row['admin_password'] == $password) {
                    session_start();

                    $_SESSION['username'] = $row['admin_username'];
                    $_SESSION['password'] = $row['admin_password'];
                    $_SESSION['adminlogin'] = true;
                    header('Location: admin_index.php');

                } else {
                    $message = "Invalid password!";
                header('Location: admin_login.php?notif='.$message);
                    
                }
            } else {
                $message = "Username not found!";
                header('Location: admin_login.php?notif='.$message);
            }
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <form method="post">
        <label for="textbox"></label>
        <input type="text" name="admin_uname" placeholder="Username" >
        <label for="textbox"></label><br><br>
        <input type="password" name="admin_pwd" placeholder="Password"><br><br>
        <input type="submit" value = "Login" name = "adminlogin"><br><br>
    </form>
</body>
</html>
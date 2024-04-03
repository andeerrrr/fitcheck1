<?php
session_start();   
include "config.php";

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

if(isset($_POST['submit'])) {
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sex = $_POST['sex'];
    $dob = $_POST['dob'];

    // Server-side validation
    if(empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($sex) || empty($dob)) {
        $message = "All fields are required.";
        header('location: sign_up.php?notif='.$message);
        exit();
    }

    // Inserting data into the database
    $insert = "INSERT INTO users (`firstname`, `lastname`, `username`, `pword`, `sex`, `dob`)
               VALUES ('$firstname', '$lastname', '$username', '$password', '$sex', '$dob')";

    $result = $conn->query($insert);
    if($result === TRUE) {
        $message = "Account created successfully.";
        header('location: login.php?notif='.$message);
        exit();
    } else {
        $message = "Error creating account: " . $conn->error;
        header('location: sign_up.php?notif='.$message);
        exit();
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Assets/icon.png">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
    <script>
        function validateForm() {
            var firstname = document.getElementById('firstname').value;
            var lastname = document.getElementById('lastname').value;
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var sex = document.getElementById('sex').value;
            var dob = document.getElementById('dob').value;

            if(firstname == '' || lastname == '' || username == '' || password == '' || confirmPassword == '' || sex == '' || dob == '') {
                alert('All fields are required.');
                return false;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body class="signup" onload="myFunction()">

    <div class="container">

        <form method="post" onsubmit="return validateForm()" class="square">
            <center><h1>Create your account</h1></center>
            <div id="firstrow">
                <div class="fn">
                    <label for="firstname">First Name</label><br>
                    <input type="text" id="firstname" name="firstname" placeholder="Enter your name..."><br>
                </div>
                <div class="ln">
                    <label for="lastname">Last Name</label><br>
                    <input type="text" id="lastname" name="lastname" placeholder="Enter your lastname..."><br>
                </div>
            </div>
            <div id="firstrow" style="margin: -5% 0 0 0;">
                <div class="fn">
                    <label for="username">Username</label><br>
                    <center><input type="text" id="username" name="username" placeholder="Username"></center><br>
                </div>
                <div class="ln">
                    <label for="password">Password</label><br>
                    <center><input type="password" id="password" name="password" placeholder="Password"></center><br>
                </div>
            </div>
            <div>
            
                <div id="secrow">
                    <div id="options">
                         <div class="adjust">
                             <label for="sex">Sex:</label><br>
                             <select id="sex" name="sex" required>
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                             </select>
                         </div>
                         <div class="adjust">
                             <label for="dob" id="doblabel">Date of Birth:</label><br>
                             <input type="date" id="dob" name="dob" autocomplete="off" required><br>
                         </div>
                    </div>

                    <div id="conpass">
                        <label for="confirm_password">Confirm Password</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"><br>
                    </div>
                </div>

            
            </div>
            <center><input id="spbt" type="submit" value="Create account" name="submit"></center><br>
            <a href="login.php" >Already have an account?</a>
        </form>
    </div>
</body>
</html>
